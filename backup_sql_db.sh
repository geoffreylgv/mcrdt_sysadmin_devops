#!/bin/bash
#

dumpdir="/data/backups"
timestamp=`date +"%Y-%m-%d_%H:%M"`


skip=(mysql information_schema performance_schema template0)

## MySQL
for db in `mysql -e "SHOW DATABASES;" | tr -d "| " | grep -v Database`
do
	# Skip some databases
	for skipped in "${skip[@]}"; do
		if [[ "$skipped" == "$db" ]]
		then
			continue 2
		fi
	done

	# Dump DB, run through gzip, save to file
	mysqldump -eq -h localhost ${db} | gzip -c - > "${dumpdir}/mysql/${db}_${timestamp}.sql.gz"
	
done

## Postgres
for db in `psql -l | grep en_US | cut -d "|" -f 1`
do
	# Skip some databases
	for skipped in "${skip[@]}"; do
		if [[ "$skipped" == "$db" ]]
		then
			continue 2
		fi
	done
	
	# Dump DB, run through gzip, save to file
        pg_dump ${db} | gzip -c - > "${dumpdir}/postgres/${db}_${timestamp}.sql.gz"
	
done

## Clean out old dumps
find ${dumpdir}/mysql/ -type f -mtime +14 -exec rm {} \;
find ${dumpdir}/postgres/ -type f -mtime +14 -exec rm {} \;

unset dumpdir timestamp db skip skipped