#!/usr/bin/python
import requests
url = 'http://t.cn'
with open('response.txt', 'w') as f:
	f.write(requests.get(url).content)
