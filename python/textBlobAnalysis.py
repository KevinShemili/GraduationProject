try:
    import tweepy
    import re
    import pandas as pd
    import numpy as np
    import matplotlib.pyplot as plt
    import json
    from textblob import TextBlob
    from difflib import SequenceMatcher
    from fuzzywuzzy import fuzz
    from fuzzywuzzy import process
    import sys

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


    # Defining Search keyword and number of tweets and searching tweets
    query = sys.argv[1]
    max_tweets = int(sys.argv[2])

    seen_tweet_texts = []
    searched_tweets = []
    for status in tweepy.Cursor(api.search_tweets, q=query, tweet_mode="extended", lang="en", result_type="mixed").items():
        preprocessed_text = remove_links_and_special_chars(status.full_text)
        # Check if the tweet text is not in the seen_tweet_texts set
        is_duplicate = any(is_similar(preprocessed_text, seen_text) for seen_text in seen_tweet_texts)

        if not is_duplicate:
            # Add the preprocessed tweet text to the seen_tweet_texts list and append the tweet to the searched_tweets list
            seen_tweet_texts.append(preprocessed_text)
            searched_tweets.append(status)

            # Break the loop if the desired number of tweets is reached
            if len(searched_tweets) >= max_tweets:
                break

    strong_pos = 0
    weak_pos = 0
    strong_neg = 0
    weak_neg = 0
    neu = 0
    for tweet in searched_tweets:
        analysis = TextBlob(tweet.full_text)
        polarity = analysis.sentiment.polarity
        if 0.3 <= polarity < 0.6:
            weak_pos += 1
        elif polarity >= 0.6:
            strong_pos += 1
        elif -0.6 < polarity <= -0.3:
            weak_neg += 1
        elif polarity <= -0.6:
            strong_neg += 1
        else:
            neu += 1

    result = {
        "total_sPositive": strong_pos,
        "total_wPositive": weak_pos,
        "total_sNegative": strong_neg,
        "total_wNegative": weak_neg,
        "total_neutral": neu
    }

    print(json.dumps(result))

except Exception as e:
    error_message = {
        "error": str(e)
    }
    print(json.dumps(error_message))