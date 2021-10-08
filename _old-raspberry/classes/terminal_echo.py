#!/user/bin/env python3

"""
	Mex and Colors for terminal
	Colors coded copied from stack overflow
	--------------------------
"""

from datetime import datetime

class Col:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'

def echo(type, text) :
	stmp = datetime.now().strftime("%Y-%m-%d  %H:%M:%S")
	if type == 0 :
		print(Col.WARNING + "[" + str(stmp) + "] " + Col.ENDC + text)
	elif type == -1 :
		print(Col.WARNING + "[" +  str(stmp) + "] " + Col.ENDC + "[" + Col.FAIL + "FAIL" + Col.ENDC + "] " + text)
	elif type == 1 :
		print(Col.WARNING + "[" +  str(stmp) + "] " + Col.ENDC + "[" + Col.OKGREEN + "DONE" + Col.ENDC + "] " + text)
