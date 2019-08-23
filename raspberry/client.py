#!/user/bin/env python3

import zmq

context = zmq.Context()
socket = context.socket(zmq.SUB)
socket.connect("tcp://localhost:2500")
socket.setsockopt_string(zmq.SUBSCRIBE, "100")

mex = socket.recv_string()
topic, data = mex.split()
print(data)
