# Requirements

* Docker CE
* docker-compose

# Install

### 1. Run docker-compose
```
docker-compose up -d --build
```

### 2. Connect to the PHP container 
```
cd $APP_PATH
composer intall
```

### 3. Import data via Youtube API or via JSON file

From Youtube API
```
cd $APP_PATH/import
php from_youtube_api.php
```
Note: Don't forget to put to the import folder secret.json with Youtube API credentials file from Google Developers Console

From JSON file with test data:
```
cd $APP_PATH/import
php from_file.php
```

#Usage
```
cd $APP_PATH
php app.php
```

