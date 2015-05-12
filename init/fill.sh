#!/bin/bash
curl http://127.0.0.1:81/reset -s
CLIENT_ID=`curl -XPOST http://127.0.0.1:81/clients -s -d @clients.json | ./jq -r '.id'`
echo "$CLIENT_ID inséré correctement"


CAT1_ID=`curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/categories -s -d @cat1.json | ./jq -r '.id'`
CAT2_ID=`curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/categories -s -d @cat2.json | ./jq -r '.id'`
CAT3_ID=`curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/categories -s -d @cat3.json | ./jq -r '.id'`
CAT4_ID=`curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/categories -s -d @cat4.json | ./jq -r '.id'`
CAT5_ID=`curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/categories -s -d @cat5.json | ./jq -r '.id'`

echo $CAT1_ID
rm -rf /tmp/videos
cp -r ./videos /tmp/videos
sed -i "s/{{ID}}/$CAT1_ID/g" /tmp/videos/*.json

curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/videos -s -d @/tmp/videos/video1.json 
curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/videos -s -d @/tmp/videos/video2.json 
curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/videos -s -d @/tmp/videos/video3.json 


echo $CAT2_ID
rm -rf /tmp/videos
cp -r ./videos2 /tmp/videos
sed -i "s/{{ID}}/$CAT2_ID/g" /tmp/videos/*.json

curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/videos -s -d @/tmp/videos/video1.json 
curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/videos -s -d @/tmp/videos/video2.json 
curl -XPOST http://127.0.0.1:81/clients/$CLIENT_ID/videos -s -d @/tmp/videos/video3.json 
