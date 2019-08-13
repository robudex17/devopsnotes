#!/bin/bash

RADIUS_20MBS_IP=146.88.71.100
RADIUS_10MBS_GW=103.5.6.100
PLDT_20MBS_IP=210.1.86.240


check_isp_line() {
	SUCCESS_COUNT=0
	FAILURE_COUNT=0
	ANSWERED="/root/ADMIN_NOTIFIED_FOR.$2.DOWN"
	for  (( count=0; count<20; count++ ))
		do 
		  #` touch /root/ADMIN_NOTIFIED_FOR.$2.DOWN`
			ping $1 -c 1 > /dev/null
			STATUS=`echo $?`
			if [ $STATUS = 0 ]
			then
				((SUCCESS_COUNT++))
				# echo $SUCCESS_COUNT
				`/bin/sleep 1`
			elif [ $STATUS != 0 ] 
			then
				((FAILURE_COUNT++))
			
			fi
			
			if [  $FAILURE_COUNT = 1 ]
			then
				if [ -f "$ANSWERED" ]
				then
					exit
				else
					/usr/bin/php /root/call_admin.php $2
				fi
			break
			elif [ $SUCCESS_COUNT = 20 ] 
			then
			    echo "SUCCESS"
				if [ -f "$ANSWERED" ]
				   echo "FILE EXIST"
				then
					`rm -f "$ANSWERED"`
					exit
				else
					exit
				fi
			fi		
		done
}


function maketest () {
	echo "test"
}

maketest()
#check_isp_line $RADIUS_20MBS_IP radius20mbps
#check_isp_line $RADIUS_10MBS_GW radius10mbps
#check_isp_line $PLDT_20MBS_IP pldt20mbps


