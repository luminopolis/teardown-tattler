#!/bin/sh

FILENAME="daily.xls"
#
# Find out where we are running from
#  Go there
#  Hop over to the WP directory
#
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../cms

WPDIR=`pwd`

cd ../data

DATADIR=`pwd`

curl -k -o $FILENAME  https://data.kcmo.org/311/311-Data-for-At-Risk-Buildings/p2je-p96s

cd $WPDIR

php extract-311.php \
	-f $FILENAME \
	-d $DATADIR

echo "did not send data";
exit;

php notify-maillist.php

