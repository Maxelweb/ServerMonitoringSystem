#!/user/bin/env python3

import zmq

context = zmq.Context()
socket = context.socket(zmq.SUB)
socket.setsockopt(zmq.CONNECT_TIMEOUT, 5000)
socket.connect("tcp://localhost:2500")
socket.setsockopt_string(zmq.SUBSCRIBE, "100")
socket.setsockopt(zmq.RCVTIMEO, 4000)

try :
	mex = socket.recv_string()
	topic, data = mex.split()
	print(data)
except Exception as e :
	print("NULL")