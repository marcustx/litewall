#!/usr/bin/env python3
import board
import neopixel
from time import sleep

pixels = neopixel.NeoPixel(board.D18, 132, brightness=1)
pixels.fill((0, 0, 0))
sleep(2)
pixels.fill((255, 0, 0))
pixels.show()

#pixels[0] = (255,0,0)
#pixels[1] = (0, 255, 0)
#pixels[2] = (0, 0, 255)


