# Spacetrack loader

## Fetching data from space-track
Set up lines of code in linux-tool Cron 
(fetching wednesday 16:40, please change this to another random timestamp)

Fetch all new data from spacetrack since last fileno and save to data.json:
```
40 16 * * 3 FILENO=$(cat "fileno.txt") && curl https://www.space-track.org/ajaxauth/login -d 'identity=XXXX&password=XXXX&query=https://www.space-track.org/basicspacedata/query/class/tle_latest/ORDINAL/1/FILE/\%3E'$FILENO'/distinct/true/predicates/NORAD_CAT_ID,TLE_LINE0,TLE_LINE1,TLE_LINE2,DECAYED,OBJECT_NAME,OBJECT_TYPE,OBJECT_ID,FILE/orderby/FILE\%20desc/format/json' -o data.json
```

Fetch and save the newest fileno from space-track:
```
41 16 * * 3 curl https://www.space-track.org/ajaxauth/login -d 'identity=XXXX&password=XXXX&query=https://www.space-track.org/basicspacedata/query/class/tle_latest/ORDINAL/1/orderby/FILE\%20desc/limit/1/distinct/true/predicates/FILE/format/csv' | grep -w "" | tr -d '"' > fileno.txt
```

Run update file:
```
41 14 * * 2 python updatedata.py
```

## Fetching data from the server set up
Visit: [Dinaro's docs at folk.ntnu.no (http://folk.ntnu.no/dinaro/docs.html)](http://folk.ntnu.no/dinaro/docs.html)

public_html/sat/index.php answers requests at http://folk.ntnu.no/dinaro/sat

## Linked projects
Stufftracker app: https://github.com/einarmo/stufftracker

Analysis program: https://github.com/nilspj/Objects-Above
