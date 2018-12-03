import requests
import json

url = "http://210.26.23.63:8080/curltest/posttest.php"

data = {"fxm":"aaa","fxb":"b","fnl":"12","fxy":"22"}

headers = {'Content-type': 'application/json', 
           'Accept': 'text/plain',
		   'wsn-key':'3849506967'}

r = requests.post(url, data=json.dumps(data), headers=headers)

print(r.text)

http://[2001:da8:c004:1:3c2b:25cf:515d:e7ff]/ycm/curltest/posttest.php
{"id":"1","temp":"3","humi":"2"}