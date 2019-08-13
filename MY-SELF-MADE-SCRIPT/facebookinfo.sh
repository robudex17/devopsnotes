#!/bin/bash

grep 'facebook' /root/facebookinfo

GETEXITSTAT=$?
echo $GETEXITSTAT

if  [ $GETEXITSTAT -eq 0 ]
then
mail -s "FACEBOOK IP HAS CHANGE UPDATE FIREWALL" rog6336@sbtjapan.com < /root/facebookinfo
     
fi

