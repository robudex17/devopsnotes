#!/usr/bin/python

import os
import os.path
import sys

iax = sys.argv[1]
csdphfilename = "/root/SCRIPTS/csdphinboundextensions.txt"

csdphfile = open(csdphfilename ,'r')
csdphextensions_list = csdphfile.read()
csdphfile.close()
csdphextensions_list = csdphextensions_list.split()

if(len(csdphextensions_list) == 0):
	inboundfile.write ( " ")
	print('No extension in the inboundgroup')
else:
	inbound_dialplan =''
	#print(len(csdphextensions_list))
	#inbound_dialplan = iax+"/" + "&"+iax+"/".join(str(extent) for extent in csdphextensions_list )
	#print(csdphextensions_list)
	for i in range(0,len(csdphextensions_list),1):
		if(i==(len(csdphextensions_list)-1)):
			inbound_dialplan = inbound_dialplan + iax + '/' + csdphextensions_list[i]
		else:
			inbound_dialplan = inbound_dialplan + iax  +'/' + csdphextensions_list[i]+'&'

	print (inbound_dialplan)
	print (len(inbound_dialplan))
	inbound_dialplan2 = inbound_dialplan.strip()
	print(len(inbound_dialplan2))