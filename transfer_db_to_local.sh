
echo "⚙️ Creating dump.sql in container"
docker exec library-catalog-db sh -c 'mysqldump -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} > /tmp/dump.sql'
echo "✅ Dump.sql created in container"
echo "⚙️ Copying dump.sql to local machine"
docker cp library-catalog-db:/tmp/dump.sql /Users/yodarango/Desktop/repos/library-catalog/dump.sql
echo "✅ Dump.sql copied to local machine"