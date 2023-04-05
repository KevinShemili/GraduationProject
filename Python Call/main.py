import tweepy
import re
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import json
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer
from difflib import SequenceMatcher


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

def is_similar(a, b, threshold=0.95):
    return SequenceMatcher(None, a, b).ratio() > threshold


# Defining Search keyword and number of tweets and searching tweets
query = 'trump prison -filter:retweets'
max_tweets = 500

seen_tweet_texts = set()
searched_tweets = []
for status in tweepy.Cursor(api.search_tweets, q=query, tweet_mode="extended", lang="en", result_type="mixed").items():
  preprocessed_text = remove_links_and_special_chars(status.full_text)
    # Check if the tweet text is not in the seen_tweet_texts set
  is_duplicate = False
  for seen_text in seen_tweet_texts:
    if is_similar(preprocessed_text, seen_text):
        is_duplicate = True
        break

  if not is_duplicate:
    # Add the preprocessed tweet text to the seen_tweet_texts set and append the tweet to the searched_tweets list
    seen_tweet_texts.add(preprocessed_text)
    searched_tweets.append(status)

    # Break the loop if the desired number of tweets is reached
    if len(searched_tweets) >= max_tweets:
        break

# searched_tweets = [status for status in tweepy.Cursor(api.search_tweets, q=query, tweet_mode="extended", lang="en", result_type="mixed").items(max_tweets)]

#
analyzer = SentimentIntensityAnalyzer()
pos = 0
neg = 0
neu = 0
for tweet in searched_tweets:
  analysis = analyzer.polarity_scores(tweet.full_text)
  if analysis['compound'] > 0:
    pos += 1
  elif analysis['compound'] < 0:
    neg += 1  
  else:
    neu += 1

data = {
    "positive": pos,
    "negative": neg,
    "neutral": neu,
    "total": pos + neg + neu
}

print(json.dumps(data))