#!/bin/bash

PRESS_NUMBER="$1"
FOLDER_ISP="$2"
EPOCH="$3"

if [ $PRESS_NUMBER == 1 ]
then 	
	touch /root/$FOLDER_ISP/ANSWERED-$EPOCH

fi
