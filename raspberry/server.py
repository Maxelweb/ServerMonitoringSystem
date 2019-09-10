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


try:
	context = zmq.Context()
	socket = context.socket(zmq.REP)
	socket.bind("tcp://*:2500")
	socket.setsockopt(zmq.RCVTIMEO, 2000) # timeout 2 seconds

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
		echo(0, "Unable to connect to Arduino..")

	while monitor.connected == True : 
	    
	    # Data update
	    monitor.requireData()

	    # Message handler
	    try :
	    	msg = socket.recv_string()
	    except Exception as err :
	    	continue; 


	    if msg == "get_data" :
	    	socket.send_string(monitor.lastData)

	    elif msg == "ping" :
	    	socket.send_string("pong")

	    elif msg == "alarm_on" :
	    	monitor.setAlarm(1)

	    elif msg == "alarm_off" :
	    	monitor.setAlarm(0)

	    elif msg == "alarm" : 
	    	socket.send_string(monitor.getAlarmStatus())

	    elif msg == "close" :
	    	if monitor.closeConnection() == True :
	    		echo(0, "Preparing to shutdown server..")
	    else : 
	    	socket.send_string("idk")

except Exception as e:
	echo(-1, "Unable to start server due to exception: " + str(e))

finally:
	echo(0, "Closing..")
	#socket.close()
	#context.term()
	#raise SystemExit