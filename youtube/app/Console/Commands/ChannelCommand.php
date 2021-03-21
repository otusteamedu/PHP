<?php

namespace App\Console\Commands;

use App\Models\Channel;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class ChannelCommand extends Command
{
    private Client $elasticsearch;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->elasticsearch = ClientBuilder::create()->build();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Channel::cursor() as $article)
        {
            $this->elasticsearch->index([
                'index' => $article->getSearchIndex(),
                'type' => $article->getSearchType(),
                'id' => $article->getKey(),
                'body' => $article->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->info('\\nDone!');
    }
}
