cd /var/www/mysite

pathToFileReleaseNumber=./current/previous-release-number.txt

if [ ! -f $pathToFileReleaseNumber ]
then
    echo "Не удалось получить номер предыдущего релиза"
    exit 1
fi

previousReleaseDir=$(cat $pathToFileReleaseNumber)

if [ ! -d $previousReleaseDir ]
then
    echo "Директория $previousReleaseDir не найдена"
    exit 1
fi

sudo cp -f ./$previousReleaseDir/supervisor.conf /etc/supervisor/conf.d/mysite.conf

sudo ln -sfn ./$previousReleaseDir ./current

sudo service php7.4-fpm reload
sudo supervisorctl update all