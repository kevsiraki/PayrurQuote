from googlesearch import search
import requests
from bs4 import BeautifulSoup
import re

def get_quotes(query, num_results=5):
    quotes = []
    search_query = f"{query} quotes"
    
    try:
        for result in search(search_query, num_results=num_results):
            quotes.append(result)
    except Exception as e:
        print(f"An error occurred: {e}")

    return quotes

def extract_quotes_from_link(link):
    quotes = []
    try:
        response = requests.get(link)
        soup = BeautifulSoup(response.text, 'html.parser')

        # Extract quotes based on strings surrounded by double quotes
        quote_matches = soup.find_all(text=lambda text: isinstance(text, str) and '“' in text and '”' in text)

        for quote_match in quote_matches:
            quotes.append(quote_match.strip('“”'))

    except Exception as e:
        print(f"An error occurred while extracting quotes from {link}: {e}")

    return quotes

def should_exclude_text(text):
    # Filter out lines containing an integer followed by "likes"
    return re.search(r'\b\d+\s*likes\b', text)

def print_quotes_with_link(index, link, quotes):
    if quotes and not should_exclude_text(link):
        for quote in quotes:
            print(f"{quote}\n")

if __name__ == "__main__":
    poet_name = "Payrur Sevak"
    search_results = get_quotes(poet_name, num_results=5)

    if search_results:
        print(f"Quotes related to {poet_name}:\n")
        for index, link in enumerate(search_results, start=1):
            quotes = extract_quotes_from_link(link)
            print_quotes_with_link(index, link, quotes)
