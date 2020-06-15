FILE_DIST="settings.conf"
cp deploy/config.conf $FILE_DIST
sed "s|%SERVER_NAME%|$1|g" $FILE_DIST | tee $FILE_DIST