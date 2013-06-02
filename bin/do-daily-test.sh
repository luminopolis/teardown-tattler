#!/bin/sh


#
# Find out where we are running from
#  Go there
#  Hop over to the WP directory
#
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../cms

WPDIR=`pwd`

cd ../testdata

DATADIR=`pwd`

cd ../sql

# mysql -u root teardown_wpV9w48 < new-tables.sql

cd $WPDIR

php extract-311.php \
	-f=311_Data_for_At_Risk_Buildings-2013-05-24.xls \
	-d=$DATADIR


php notify-maillist.php

php extract-311.php \
	-f=311_Data_for_At_Risk_Buildings-2013-05-31.xls \
	-d=$DATADIR

php notify-maillist.php

