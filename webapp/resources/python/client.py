#!/user/bin/env python3

import zmq
import sys

if len(sys.argv) != 2 or sys.argv[1] not in ("get_data", "alarm", "close", "ping") :
	print("ERROR")
else : 
	try :
		context = zmq.Context()
		socket = context.socket(zmq.REQ)
		socket.setsockopt(zmq.CONNECT_TIMEOUT, 2000)
		socket.connect("tcp://localhost:2500")
		socket.setsockopt(zmq.RCVTIMEO, 4000)

		socket.send_string(sys.argv[1])

		print(socket.recv_string())

	except Exception as e :
		print(e)