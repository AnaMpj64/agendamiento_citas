#!/bin/bash
DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="backup_$DATE.sql"

mysqldump --single-transaction --no-tablespaces --user=kp8udz7nhrmtjs73 --password=udjyiikf1y5xdpp9 \
--host=d9c88q3e09w6fdb2.cbetxkdyhwsb.us-east-1.rds.amazonaws.com \
dsrcluytm2cs8cfe > $BACKUP_FILE

echo "Backup completed: $BACKUP_FILE"