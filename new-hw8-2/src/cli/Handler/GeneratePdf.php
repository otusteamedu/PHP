<?php


namespace AYakovlev\cli\Handler;


use AYakovlev\Log\Log;

class GeneratePdf
{
    public static function generatePdf(string $body): void {
        $data = json_decode($body, true);
        Log::getLog()->info("Generating PDF...");
        sleep(mt_rand(2, 5));
        Log::getLog()->info('...PDF generated');
        echo "Generate pdf from data:\n";
        print_r($data);
        echo "\n";
    }
}