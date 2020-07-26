<?php


namespace App\Services\Export\Diagrams;


use Illuminate\Support\Facades\Storage;
use Imagick;
use SVG\SVG;

class DiagramExporterImpl implements DiagramExporter
{

    public function exportToSvg(SVG $svg, string $title)
    {
        $path = $this->getPath($title, 'svg');
        file_put_contents($path, $svg->toXMLString());
        return $path;
    }

    public function exportToPng(SVG $svg, string $title)
    {
        $path = $this->getPath($title, 'png');

        $im = new Imagick();
        /** @noinspection PhpUnhandledExceptionInspection */
        $im->readImageBlob($svg->toXMLString());
        $im->setImageFormat('png32');
        /** @noinspection PhpUnhandledExceptionInspection */
        $im->writeImage($path);
        /** @noinspection PhpUnhandledExceptionInspection */
        $im->clear();
        /** @noinspection PhpUnhandledExceptionInspection */
        $im->destroy();

        return $path;
    }

    private function getPath($title, $extension) {
        /** @noinspection PhpUndefinedMethodInspection */
        $publicPath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        return $publicPath . $title . '.' . $extension;
    }
}
