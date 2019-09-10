#!/user/bin/env python3

import serial
from time import sleep
from .terminal_echo import echo


"""
	SMS Protocol to get data from the Arduino
	-----------------------------------------
"""

class SMS_Protocol :

	def __init__(self, privateApiKey, portpath):
		self.privateApiKey = privateApiKey
		self.usb = serial.Serial(portpath, 9600, timeout = 2)
		self.usb.flushInput()
		self.connected = False
		self.lastData = "none"


	def response(self) :
		output = self.usb.readline().decode('utf-8').rstrip()
		return output


	def send(self, command) :
		self.usb.write(command.encode())


	def startConnection(self) :

		echo(0, "Connecting to arduino..")

		self.send("plz")
		sleep(0.2)

		if self.response() == 'y' :

			echo(1, "Accepted. Sending private api key...")
			
			self.send(self.privateApiKey)

			if self.response() == 'y' :
				self.connected = True
				echo(1, "Connected to Arduino (serial connection)")
				#print(str(time.time() - start))
				return True
			else :
				echo(-1, "Connection error: invalid API key")
		
		else :
			echo(-1,"Connection to Arduino FAILED")

		return False


	def closeConnection(self) :
		self.send("bye");
		if self.response() == "bye" :
			self.connected = False
			echo(1, "Connection closed")
			return True
		else :
			echo(-1, "Connection error: unable to close connection")
			return False


	def requireData(self) :
		if self.connected == False :
			echo(-1, "Error: not connected")
			return False
		else :
			self.send("plz data")
			self.lastData = self.response()
			return True

	def setAlarm(self, mode) :
		if mode == 1 : 
			self.send("plz alarm on")
		else :
			self.send("plz alarm off")

	def getAlarmStatus(self) :
		self.send("plz alarm")
		return self.response()



