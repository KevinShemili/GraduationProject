import tweepy
import re
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import json
from difflib import SequenceMatcher
from fuzzywuzzy import fuzz
from fuzzywuzzy import process
from transformers import AutoTokenizer, AutoModelForSequenceClassification
import torch

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

consumer_key = 'X8NQZbw2kuM0oPetx64JCBufo'
consumer_secret = 'SyPQfdNVJSTcy6pZiPFKNLMF8XKivWcd9aHcOiNPxOpoQeISBp'
access_token = '1641109096366571523-1Dmb1dhRIbGZqa1P1XScmK9joqS8x3'
access_token_secret = 'wdGqoT7FKz9Fl4hpcunj6bPxMNTyZyEuJrA8MVoN0XEHN'

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

query = 'biden -filter:retweets'
max_tweets = 500

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

print("Total Strong Positive = ", strong_pos)
print("Total Weak Positive = ", weak_pos)
print("Total Strong Negative = ", strong_neg)
print("Total Weak Negative = ", weak_neg)
print("Total Neutral = ", neu)

# Plotting sentiments
labels = 'Strong Positive', 'Weak Positive', 'Neutral', 'Weak Negative', 'Strong Negative'
sizes = [strong_pos, weak_pos, neu, weak_neg, strong_neg]
colors = ['gold', 'yellowgreen', 'lightcoral', 'lightskyblue', 'red']
explode = (0.1, 0, 0, 0, 0)  # explode 1st slice
plt.pie(sizes, explode=explode, labels=labels, colors=colors, autopct='%1.1f%%', shadow=True, startangle=140)
plt.axis('equal')
plt.show()

#Part-3: Creating Dataframe of Tweets
#Cleaning searched tweets and converting into Dataframe
my_list_of_dicts = []
for each_json_tweet in searched_tweets:
    my_list_of_dicts.append(each_json_tweet._json)
    
with open('tweet_json_Data.txt', 'w') as file:
        file.write(json.dumps(my_list_of_dicts, indent=4))
        
my_demo_list = []

#Removing @ handle
def remove_pattern(input_txt, pattern):
    r = re.findall(pattern, input_txt)
    for i in r:
        input_txt = re.sub(i, '', input_txt)
        
    return input_txt 

with open('tweet_json_Data.txt', encoding='utf-8') as json_file:  
    all_data = json.load(json_file)
    for each_dictionary in all_data:
        tweet_id = each_dictionary['id']
        text = remove_pattern(each_dictionary['full_text'], "@[\w]*")
        retweet_count = each_dictionary['retweet_count']
        created_at = each_dictionary['created_at']
        my_demo_list.append({'tweet_id': str(tweet_id),
                             'text': str(text),
                             'retweet_count': int(retweet_count),
                             'created_at': created_at,
                            })
        
        tweet_dataset = pd.DataFrame(my_demo_list, columns = 
                                  ['tweet_id', 'text', 
                                   'retweet_count', 
                                   'created_at'])
    
#Writing tweet dataset ti csv file for future reference
tweet_dataset.to_csv('tweet_data.csv')

tweet_dataset.shape
tweet_dataset.head()



tweet_dataset['text'] = np.vectorize(remove_pattern)(tweet_dataset['text'], "@[\w]*")

tweet_dataset.head()

tweet_dataset['text'].head(10)