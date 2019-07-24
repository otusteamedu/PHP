# MongoDB

* JSON schemas:
    * `channelSchema.json` 
    * `videoSchema.json`
    
* Working with data:
    * Add/Remove data to/from collections example: `examples/index.php`
 
* Statistics:
    * method `getLikesCountForChannel(string $channelName)` returns likes amount
    * method `getDislikesCountForChannel(string $channelName)` returns dislikes amount
    * method `getTopChannels(void)` returns channels sorted by likes/dislikes ratio