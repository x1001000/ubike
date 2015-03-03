#!/usr/bin/python
import re
import sys
with open('index.html') as f:
    for line in f:
        match = re.search('txt\">(.*txt)', line)
        if match:
            with open(match.group(1)) as f:
                for line in f:
                    found = re.search(str(sys.argv[1]), line)
                    if found:
                        print match.group(1)
