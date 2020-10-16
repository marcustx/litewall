#!/usr/bin/env python3
import time, board, neopixel, json, sys
from rpi_ws281x import *

delay = 700;

pixels = neopixel.NeoPixel(board.D18, 132, brightness=1);

json_array  = json.loads( sys.argv[1] )

for key, value in json_array.items():
    print(key, ":", value);
    #pixels[${key}] = value;
    pixels[ int(key) ] =  value ;
    time.sleep(delay/1000.0)
    #pixels[int(key)] = value

# light route
#pixels[9] = (255,0,0);
#pixels[10] = (0,255,0);
#pixels[11] = (0,0,255);
#pixels[12] = (255,0,0);
#pixels[13] = (0,255,0);
#pixels[14] = (0,0,255);
#pixels[15] = (0,0,255);

#route = [1,2,3,4,5,6,7];

#time.sleep(delay/1000.0);

#i = 0

#while i < 7:
#    tempColor = pixels[route[i]];
#    pixels[route[i]] = (0,0,0);
#    time.sleep(delay/1000.0);
#    pixels[route[i]] = tempColor;
#    i += 1
