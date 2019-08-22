#!/user/bin/env python3

import zmq
import sys

cmds = ("get_data", "ping", "close")

def main() :

	if sys.argv[1] not in cmds :
		print(0)
		return
	
	context = zmq.Context()
	socket = context.socket(zmq.REQ)
	socket.connect("tcp://localhost:2500")

	socket.send_string(sys.argv[1])

	mex = socket.recv_string()

	if mex != "idk" :
		print(mex) 
	else : 
		print(0)

	return

if __name__ == "__main__" :
	main()