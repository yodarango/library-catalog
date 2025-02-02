
echo "⚙️ Creating dump.sql in container"
docker exec stwc_db sh -c 'mysqldump -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} > /tmp/dump.sql'
echo "✅ dump.sql created in container"
echo "⚙️ Copying dump.sql to local machine"
docker cp stwc_db:/tmp/dump.sql /Users/yodarango/Desktop/repos/library-catalog/dump.sql
echo "✅ Dump.sql copied to local machine"