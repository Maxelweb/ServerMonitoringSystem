#!/user/bin/env python3


SECRET_CODE = "SECRET"


# DO NOT CHANGE UNDER THIS LINE
# ============================================
# Libs
# Required pyzmq lib 

import zmq 
import time
import sys
from time import sleep
from classes.sms_protocol import SMS_Protocol
from classes.terminal_echo import echo

# kill process -9 pkill 
# find /sys/bus/usb/devices/usb*/ -name dev
# To do: try catch for multiple usb ports


# Main

echo(0, "Server starting...")

context = zmq.Context()
socket = context.socket(zmq.PUB)
socket.bind("tcp://*:2500")

echo(1, "Server started on localhost:2500")
echo(0, "Enstablishing connection with arduino on Serial port..")

monitor = SMS_Protocol(SECRET_CODE)

i = 1
echo(0, "Attempt #"+str(i)+" ...")

while i < 6 and monitor.startConnection() == False :
	sleep(0.2)
	i = i+1
	echo(0, "Attempt #"+str(i)+" ...")

if monitor.connected == False :
	echo(0, "Closing..")
	sys.exit()


while monitor.connected == True : 
    
    monitor.requireData()
    socket.send_string("%d %s" % (100, monitor.lastData))
    sleep(5)


echo(1, "Closing..")

sys.exit()