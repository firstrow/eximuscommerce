# Create full copy of dev DB and insert it to test DB
USER="root"
PASSWORD="mysqlpass"

mysqldump --force --opt --user=$USER --password=$PASSWORD my_db > "./temp.sql"
mysql -u$USER -p$PASSWORD my_db_test < "./temp.sql"
rm "./temp.sql"
