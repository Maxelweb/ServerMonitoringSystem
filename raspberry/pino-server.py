#!/user/bin/env python3


SECRET_CODE = "SECRET"


# DO NOT CHANGE UNDER THIS LINE
# ============================================
# Libs
# Required pyzmq lib 

import zmq 
import time
from time import sleep
from classes.sms_protocol import SMS_Protocol
from classes.terminal_echo import echo

# Debugging
start = time.time()


# kill process -9 pkill 
# find /sys/bus/usb/devices/usb*/ -name dev
# To do: try catch for multiple usb ports


# Main

def main() :

	echo(0, "Server starting...")

	context = zmq.Context()
	socket = context.socket(zmq.REP)
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
		return 

	lastRequest = time.time()

	while monitor.connected == True : 
	    
	    msg = socket.recv_string()

	    if msg == "get_data" :
	    	lastRequest = time.time() - lastRequest
	    	monitor.requireData()
	    	socket.send_string(monitor.lastData)
	    
	    elif msg == "ping" :
	    	socket.send_string("ok")

	    elif msg == "close" :
	    	if monitor.closeConnection() == True :
	    		echo(0, "Preparing to shutdown server..")
	    else : 
	    	socket.send_string("idk")


	echo(1, "Closing..")
	
	# Debugging 
	echo(0, "Total runtime: " + str(time.time() - start))
	
	return 


if __name__ == "__main__" :
	main()