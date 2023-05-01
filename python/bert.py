try:
    import tweepy
    import re
    import pandas as pd
    import json
    from fuzzywuzzy import fuzz
    from transformers import AutoTokenizer, AutoModelForSequenceClassification
    import torch
    import sys
    import uuid


    # Set up BERT sentiment analysis pipeline
    tokenizer = AutoTokenizer.from_pretrained("distilbert-base-uncased-finetuned-sst-2-english")
    model = AutoModelForSequenceClassification.from_pretrained("distilbert-base-uncased-finetuned-sst-2-english")

    def get_sentiment(text):
        inputs = tokenizer(text, return_tensors="pt")
        outputs = model(**inputs)
        logits = outputs.logits
        probabilities = torch.softmax(logits, dim=-1)
        sentiment = torch.argmax(probabilities)
        score = probabilities.max().item()

        return sentiment.item(), score

    consumer_key = sys.argv[3]
    consumer_secret = sys.argv[4]
    access_token = sys.argv[5]
    access_token_secret = sys.argv[6]

    # create OAuthHandler object
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
    # set access token and secret
    auth.set_access_token(access_token, access_token_secret)
    # create tweepy API object to fetch tweets
    api = tweepy.API(auth)

    def remove_links_and_special_chars(text):
        # Remove links
        text = re.sub(r"http\S+|www\S+|https\S+", '', text, flags=re.MULTILINE)

        # Remove emojis and special characters
        text = text.encode('ascii', 'ignore').decode('ascii')

        return text.lower().strip()

    def is_similar(a, b, threshold=95):
        return fuzz.token_set_ratio(a, b) > threshold

    query = sys.argv[1]
    max_tweets = int(sys.argv[2])

    seen_tweet_texts = []
    searched_tweets = []
    for status in tweepy.Cursor(api.search_tweets, q=query, tweet_mode="extended", lang="en", result_type="mixed").items():
        preprocessed_text = remove_links_and_special_chars(status.full_text)
        is_duplicate = any(is_similar(preprocessed_text, seen_text) for seen_text in seen_tweet_texts)

        if not is_duplicate:
            seen_tweet_texts.append(preprocessed_text)
            searched_tweets.append(status)

            if len(searched_tweets) >= max_tweets:
                break

    strong_pos = 0
    weak_pos = 0
    strong_neg = 0
    weak_neg = 0
    neu = 0
    for tweet in searched_tweets:
        sentiment, score = get_sentiment(tweet.full_text)
        
        if sentiment == 1: # Positive
            if 0.5 <= score < 0.85:
                weak_pos += 1
            elif score >= 0.85:
                strong_pos += 1
            else:
                neu += 1
        elif sentiment == 0: # Negative
            if 0.5 <= score < 0.85:
                weak_neg += 1
            elif score >= 0.85:
                strong_neg += 1
            else:
                neu += 1

    # Remove @ handle
    def remove_pattern(input_txt, pattern):
        r = re.findall(pattern, input_txt)
        for i in r:
            input_txt = re.sub(i, '', input_txt)
        return input_txt

    my_list_of_dicts = []
    for each_json_tweet in searched_tweets:
        tweet_id = each_json_tweet.id
        text = remove_pattern(each_json_tweet.full_text, "@[\w]*")
        retweet_count = each_json_tweet.retweet_count
        created_at = each_json_tweet.created_at
        
        my_list_of_dicts.append({
            'tweet_id': str(tweet_id),
            'text': str(text),
            'retweet_count': int(retweet_count),
            'created_at': created_at,
        })

    # Create a DataFrame directly from the list of dictionaries
    tweet_dataset = pd.DataFrame(my_list_of_dicts)

    # Generate a unique file name using UUID
    fileName = f'{uuid.uuid4()}.csv'

    # Save the DataFrame to a CSV file
    tweet_dataset.to_csv(f'../csv/{fileName}', index=False)

    result = {
        "total_sPositive": strong_pos,
        "total_wPositive": weak_pos,
        "total_sNegative": strong_neg,
        "total_wNegative": weak_neg,
        "total_neutral": neu,
        "file": fileName
    }

    print(json.dumps(result))

except Exception as e:
    error_message = {
        "error": str(e)
    }
    print(json.dumps(error_message))