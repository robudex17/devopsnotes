#!/bin/bash
#THIS SCRIPT IS WILL FAILOVER TO SECONDARY LINK WHEN PRIMARY FAIL TO RESPONSE AND
#IT WILL AUTOMATICALLY SWITCH BACK TO PRIMARY LINK IF THE PRIMARY BACK ONLINE
#
#Date: 09/29/2018
#Author: ROGMER D. BULACLAC
#        SBT PHILIPPINES INC
#        IT DEPARTMENT 

PING_TARGET=103.5.6.1
PRIMARY_GATEWAY_IP=103.5.6.1
PRIMARY_INTERFACE=eth2
SECONDARY_GATEWAY_IP=192.168.70.2
SECONDARY_INTERFACE=eth3:1

SUCCESS_COUNT=0
FAILURE_COUNT=0
DATE_OF_DOWNLINK=`date +%D`
TIME_OF_DOWNLINK=`date +%T`
DATE_OF_UPLINK=`date +%D`
TIME_OF_UPLINK=`date +%T`
PRIMARY_INTERFACE_PHYSICAL_STATUS=`/sbin/ethtool eth2 | grep "Link detected" | awk '{print $3}'`
#echo "CHECKING PRIMARY LINK STATUS"
for  (( count=1; count<21; count++ ))


do 
	ping -I $PRIMARY_INTERFACE -c 1 $PING_TARGET > /dev/null
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
	
	if [  $FAILURE_COUNT = 3 ] || [ "$PRIMARY_INTERFACE_PHYSICAL_STATUS" = "no" ] 
	
	then
		CHECK_SECONDARY_ROUTE=`/sbin/route | grep default | /usr/bin/awk '{print $2}'`
		if [ $CHECK_SECONDARY_ROUTE = $SECONDARY_GATEWAY_IP ]
		then
			echo "SECONDARY LINK WAS ALREADY SET"
		else
			echo "FAILURE_COUNT IS REACHING $FAILURE_COUNT FAILOVER TO SECONDARY LINK" >> /root/PrimaryLinkFailureORSuccess.log
			echo "PRIMARY LINK FAILURE------------->DATE:$DATE_OF_DOWNLINK-------->TIME:$TIME_OF_DOWNLINK" >> /root/PrimaryLinkFailureORSuccess.log
			echo " "  >> /root/PrimaryLinkFailureORSuccess.log
			####### PUT SCRIPT FOR FAILOVER HERE.......########
			 /sbin/route delete default gw 103.5.6.1 eth2
			/sbin/route add default gw 192.168.70.2 eth3
			# service networking restart
			 `/usr/sbin/service asterisk restart`
		fi
	break
	elif [ $SUCCESS_COUNT = 20 ] 
	then
			
		CHECK_DEFAULT_ROUTE=`/sbin/route | grep default | /usr/bin/awk '{print $2}'`
		if [ $CHECK_DEFAULT_ROUTE = $PRIMARY_GATEWAY_IP ]
		then
			echo "PRIMARY LINK WAS ALREADY UP" >> /root/PrimaryLinkFailureORSuccess.log
		else
			
			echo "SUCCESS_COUNT IS $SUCCESS_COUNT THE PRIMARY LINK IS HEALTHY" >> /root/PrimaryLinkFailureORSuccess.log
			echo "PRIMARY LINK BACK ONLINE--------->DATE:$DATE_OF_UPLINK-------->TIME:$TIME_OF_UPLINK" >> /root/PrimaryLinkFailureORSuccess.log
			echo " "  >> /root/PrimaryLinkFailureORSuccess.log
			########PUT SCRIPT TO BACK TO PRIMARY LINK HERE....	############
			 `/usr/sbin/service networking restart`
			 `/usr/sbin/service asterisk restart`
		fi
	
	fi
       
done



