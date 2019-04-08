<?php

namespace HW7_1;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use function file_get_contents;
use function realpath;
use function tmpfile;

class PSR7UploadFile extends PSR7Base
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $result = [];
        /** @var UploadedFileInterface $uploadedFile */
        foreach ($request->getUploadedFiles() as $uploadedFile) {
            if ($tmp = tmpfile()) {
                fclose($tmp);
                $targetPath = realpath($tmp);
                $uploadedFile->moveTo($targetPath);
                if ($content = file_get_contents($targetPath)) {
                    $emails = explode("\n", $content);
                    $result[$uploadedFile->getClientFilename()] = $this->validation->validateArray($emails);
                }
            }
        }
        return $this->createResponse($response, $result);
    }
}
