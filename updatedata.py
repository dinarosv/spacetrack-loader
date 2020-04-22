import json
import datetime

satellitesfile = open("public_html/satellitedata.json", "r")
updatesfile = open("data.json", "r")

data = satellitesfile.read()
satellites_json = json.loads(data)
updatedata = updatesfile.read()
update_json = json.loads(updatedata)

satellitesfile.close()
updatesfile.close()

u = dict()
new = dict()

for n in update_json:
    u[n["NORAD_CAT_ID"]] = n

for i, NORAD_CAT_ID in enumerate(satellites_json):
    if NORAD_CAT_ID in u:
        new[NORAD_CAT_ID] = u[NORAD_CAT_ID]
    else:
        new[NORAD_CAT_ID] = satellites_json[NORAD_CAT_ID]

with open("public_html/satellitedata.json", "w") as outfile:
    json.dump(new, outfile)

with open("lastupdated.txt", "w") as outfile:
    outfile.write(str(datetime.datetime.now()))
