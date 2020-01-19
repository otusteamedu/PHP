mongo_restore:
	docker-compose exec mongodb mongorestore --db youtubedb --username=root --password password --authenticationDatabase=admin /backup/youtubedb/channels.bson
	docker-compose exec mongodb mongorestore --db youtubedb --username=root --password password --authenticationDatabase=admin /backup/youtubedb/videos.bson