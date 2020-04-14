<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Console;

use App\App;
use App\YouTube;
use JsonSchema\Validator;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SearchAndFill extends Command
{
    // @todo для значений больше 50 нужно реализовать постраничную итерацию
    private const LIMIT = 50;

    protected static $defaultName = 'app:fill';

    protected function configure(): void
    {
        $this
            ->setDescription(
                'Ищет в YouTube видео и сохраняет в базу информацию о видео и каналах (сортировка по релевантности на русском).'
            )
            ->addArgument('query', InputArgument::OPTIONAL, 'Строка для поиска', 'php')
            ->setAliases(['fill']);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = (string) $input->getArgument('query');

        $app = new App();
        $res = YouTube::search($query, self::LIMIT);

        $videos = [];
        $channels = [];
        foreach ($res->items as $video) {
            $videos[$video->id->videoId] = $video->id->videoId;
            $channels[$video->snippet->channelId] = $video->snippet->channelId;
        }
        unset($res);

        foreach ($channels as $id) {
            if ($data = YouTube::getChannel($id)) {
                self::validateSchema($data, 'channel');
                $app->db->save($data, 'channel');
            }
        }

        foreach ($videos as $id) {
            if ($data = YouTube::getVideo($id)) {
                self::validateSchema($data, 'video');
                $app->db->save($data, 'video');
            }
        }

        return 0;
    }

    private static function validateSchema(&$obj, string $type): void
    {
        $validator = new Validator;
        $validator->validate($obj, (object)['$ref' => "file:///app/schema/$type.schema.json"]);
        if (!$validator->isValid()) {
            $msg = 'JSON does not validate. Violations:';
            foreach ($validator->getErrors() as $error) {
                $msg .= sprintf(' [%s] %s', $error['property'], $error['message']);
            }
            throw new RuntimeException($msg);
        }
    }
}
