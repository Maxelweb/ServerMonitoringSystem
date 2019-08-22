#!/user/bin/env python3

import zmq
from classes.terminal_echo import echo
import time

start = time.time()

echo(0, "Connecting to server...")
context = zmq.Context()
socket = context.socket(zmq.REQ)
socket.connect("tcp://localhost:2500")

echo(1, "Connected to localhost:2500")

echo(0, "Requesting data..")
socket.send_string("get_data")

mex = socket.recv_string()

print(mex)


echo(1, str(time.time() - start))

echo(1,"Closing..")