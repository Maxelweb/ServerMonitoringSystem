#!/user/bin/env python

# Libs

import serial


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


class SMS_Protocol :

	def __init__(self, privateApiKey):
		self.privateApiKey = privateApiKey
		self.usb = serial.Serial("/dev/ttyUSB1", 9600, timeout = 2)
		self.usb.flushInput()
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

monitor.startConnection()

while True :
	if monitor.connected == True :
	# while True :
		monitor.requireData()
		monitor.getData()
monitor.closeConnection()