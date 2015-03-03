import requests
import re
import logging

url = 'https://www.youbike.com.tw/user/log/'
logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger()

response = requests.get(url)
for line in response.content.split('\n'):
    match = re.search('href=\"(.*\.txt)\"', line)
    if match:
        link = url + match.group(1)
        logger.info('Found %s' % (match.group(1)))
        with open(match.group(1), 'w') as f:
            f.write(requests.get(link).content)
            logger.info('Download %s' % (match.group(1)))
