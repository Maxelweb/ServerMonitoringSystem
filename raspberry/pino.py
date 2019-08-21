#!/user/bin/env python

# Libs

import serial
import time

from time import sleep

start = time.time()


# Config

#port = "/dev/ttyUSB0"
#baudrate = 9600
#connected = False
#usb = serial.Serial(port, baudrate, timeout = 5)
#usb.flushInput()

class col:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'


# To do: try catch for multiple usb ports

class SMS_Protocol :

	def __init__(self, privateApiKey):
		self.privateApiKey = privateApiKey
		self.usb = serial.Serial("/dev/ttyACM1", 9600, 
			bytesize=serial.EIGHTBITS,
	        parity=serial.PARITY_NONE,
	        stopbits=serial.STOPBITS_ONE,
	        timeout=1,
	        xonxoff=0,
	        rtscts=0
	    )
		#self.usb.flushInput()
		
		# Toggle DTR to reset Arduino
		self.usb.setDTR(False)
		sleep(3)
		# toss any data already received, see
		# http://pyserial.sourceforge.net/pyserial_api.html#serial.Serial.flushInput
		self.usb.flushInput()
		self.usb.setDTR(True)

		self.connected = False
		self.lastData = "none"
		self.c = col()

	def __del__(self) :
		self.usb.close()

	def response(self) :
		output = self.usb.readline()
		return output.rstrip()

	def send(self, command) :
		self.usb.write(command.encode())

	def echo(self, type, text) :
		if type == 0 :
			print(self.c.HEADER + text + self.c.ENDC)
		elif type == -1 :
			print(self.c.FAIL + text + self.c.ENDC)
		elif type == 1 :
			print(self.c.OKGREEN + text + self.c.ENDC)

	def startConnection(self) :

		self.echo(0, "Connecting to arduino..")

		self.send("plz")

		if self.response() == 'y' :

			self.echo(1, "Accepted. Sending private api key...")
			
			self.send(self.privateApiKey)

			if self.response() == 'y' :
				self.connected = True
				self.echo(1, "Connected to Arduino (serial connection)")
				return True
			else :
				self.echo(-1, "Connection error: invalid API key")
		
		else :
			self.echo(-1,"Connection to Arduino FAILED")

		return False

	def closeConnection(self) :
		self.send("bye");
		if self.response() == "bye" :
			self.connected = False
			self.echo(1, "Connection closed")
			return True
		else :
			self.echo(-1, "Connection error: unable to close connection")
			return False

	def requireData(self) :
		if self.connected == False :
			self.echo(-1, "Error: not connected")
			return False
		else :
			self.send("plz data")
			self.lastData = self.response()
			return True

	def getData(self) :
		print("[JSON_DATA] " + self.lastData)
		

# Main

monitor = SMS_Protocol("1")

if monitor.startConnection() == True :

	monitor.requireData()
	monitor.getData()
	monitor.closeConnection()

end = time.time()
print(end - start)