#!/bin/bash

RADIUS_20MBS_GW=146.88.71.89
RADIUS_10MBS_GW=103.5.6.2
PLDT_20MBS_GW=210.1.86.209
RADIUS_20MBS_GW_INT=eth3
RADIUS_10MBS_GW_INT=eth2
PLDT_20MBS_GW_INT=eth1

##Add route if no route from other ISP
CHECKROUTE_RADIUS20MBS=`route | grep  146.88.71.89 | wc -l` 
if [ $CHECKROUTE_RADIUS20MBS == 0 ]
then
	`/sbin/route add 146.88.71.89/32 gw 192.168.70.1 dev eth3`
	echo "Route added"
fi

CHECKROUTE_PLDT20MBS=`/sbin/route | grep  210.1.86.209 | wc -l`
if [ $CHECKROUTE_PLDT20MBS == 0  ]
then
	`/sbin/route add 210.1.86.209/32 gw 10.74.40.2 dev eth1`
	echo "route is added"
fi



check_isp_line() {
	SUCCESS_COUNT=0
	FAILURE_COUNT=0
	ANSWERED="/root/ADMIN_NOTIFIED_FOR.$2.DOWN"
	for  (( count=0; count<20; count++ ))
		do 
		  #` touch /root/ADMIN_NOTIFIED_FOR.$2.DOWN`
			ping $1 -I $2 -c 1 > /dev/null
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
			
			if [  $FAILURE_COUNT == 1 ]
			then
				#MAKE  ISP IF NOT DIRECTORY IF NOT EXIST
				#THIS DIRECTOYR IS THE PLACE HOLDER OF NOT-ANSWERED NOTIFICATION 
				if [ ! -d "/root/$3" ] 
				then
					`mkdir /root/$3`
				fi
                #DONT CALL IF ALREADY ANSWERED OR THE CALL THRESHOLD REACH SPECIFIED COUNT
				if [  `ls /root/$3/CALLATTEMPTED* | wc -l` == 5 ] || [ `ls /root/$3/ANSWERED* | wc -l` == 1 ]
				then
					break
				else
					touch /root/$3/CALLATTEMPTED-`date +%s`
					/usr/bin/php /root/SCRIPTS/call_admin.php $3
				fi
		    break
			elif [ $SUCCESS_COUNT = 20 ] 
			then
			    echo "SUCCESS"
				if [ -d "/root/$3" ]				   
				then
					`rm -f -r /root/$3`
				fi
				
			fi		
		done
}



check_isp_line $RADIUS_20MBS_GW $RADIUS_20MBS_GW_INT radius20mbps
check_isp_line $RADIUS_10MBS_GW $RADIUS_10MBS_GW_INT radius10mbps
check_isp_line $PLDT_20MBS_GW $PLDT_20MBS_GW_INT pldt20mbps


