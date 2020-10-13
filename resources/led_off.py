#!/usr/bin/env python3
import board
import neopixel
from time import sleep

pixels = neopixel.NeoPixel(board.D18, 132, brightness=1)
pixels.fill((0, 0, 0))


