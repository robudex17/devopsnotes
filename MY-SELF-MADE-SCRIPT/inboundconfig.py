#!/usr/bin/python

import os
import os.path
import sys

extension = sys.argv[1]
option = int(sys.argv[2])

csdphfilename = "/root/SCRIPTS/csdphinboundextensions.txt"

def check_if_file_exit(filename):
	if (os.path.isfile(filename)):
		open(filename ,'w')
		filename.close()

	
def add_or_remove_to_inbound(extension,option):  # option 1 add extension to inboundgroup 0 remove it.
	csdphfile = open (csdphfilename, 'r')
	csdphextensions_list = csdphfile.read()
	csdphfile.close()
	csdphextensions_list = csdphextensions_list.split()
	if(option == 1):
		if (len(csdphextensions_list) == 0):
			csdphextensions_list.append(extension)
		else:
			for exten in csdphextensions_list:
				if(exten == extension):
					print('Extension is already on the list')
					break
			else:
				print('Extension newly added')
				csdphextensions_list.append(extension)
	else:
		print (option)
		if (len(csdphextensions_list) != 0):
			for exten in csdphextensions_list:
				if(exten == extension):
					print(exten)
					csdphextensions_list.pop(csdphextensions_list.index(extension))
					print('Extension was removed on the list')
					break
	print(csdphextensions_list)
	csdphfile = open(csdphfilename,'w')
	for exten in csdphextensions_list:
		csdphfile.write( exten + '\n')
	csdphfile.close()	
    	   
           
add_or_remove_to_inbound(extension,option)
csdphfile = open(csdphfilename ,'r')
csdphextensions_list = csdphfile.read()
csdphfile.close()
csdphextensions_list = csdphextensions_list.split()


inboundfile = open('/var/www/sbtph/inbound.php' ,'w')
if(len(csdphextensions_list) == 0):
	inboundfile.write ( " ")
	print('No extension in the inboundgroup')
else:
	print(len(csdphextensions_list))
	inbound_dialplan = "${PH_IAX}/" + "&${PH_IAX}/".join(str(extent) for extent in csdphextensions_list ) 

	inboundfile.write( "<?php\n\n  $PH_IAX = trim($_GET['PHIAX']); \n\n")
	inboundfile.write( 'echo ' + '"'+ inbound_dialplan + '"'+';\n\n?>')
	inboundfile.close()
	print (inbound_dialplan)