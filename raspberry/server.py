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

sys.stdout = open('sms-logs.txt', 'w')

# Main

echo(0, "Server starting...")

context = zmq.Context()
socket = context.socket(zmq.PUB)

try:
	socket.bind("tcp://*:2500")

	echo(1, "Server started on localhost:2500")
	echo(0, "Enstablishing connection with arduino on Serial port..")

	monitor = SMS_Protocol(SECRET_CODE, "/dev/ttyACM0")

	i = 1
	echo(0, "Attempt #"+str(i)+" ...")

	while i < 6 and monitor.startConnection() == False :
		sleep(0.2)
		i = i+1
		echo(0, "Attempt #"+str(i)+" ...")

	if monitor.connected == False :
		echo(0, "Closing..")
		sys.exit()

	update = 0

	while monitor.connected == True : 
	    
	    if update >= 10 : 
	    	monitor.requireData()
	    	update = 0
	    else : 
	    	update = update + 0.5

	    socket.send_string("%d %s" % (100, monitor.lastData))
	    sleep(0.4)

except Exception as e:
	echo(-1, "Unable to start server due to exception: " + str(e))
finally:
	echo(0, "Closing..")
	socket.close()
	context.term()
	raise SystemExit