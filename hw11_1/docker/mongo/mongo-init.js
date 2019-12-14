db.createUser(
    {
        user: "admin",
        pwd: "secret",
        roles: [
            {
                role: "readWrite",
                db: "db"
            }
        ]
    }
);
db.createCollection("youtube_channels_stat");