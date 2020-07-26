<?php


namespace App\Services\Export\Diagrams;


/**
 * @property integer $filePath
 * @property integer $height
 * @property integer $width
 * Class DiagramResponse
 */
class DiagramResponse extends BaseDiagram
{

    public $filePath;
    public $height;
    public $width;

    public static function build(DiagramResponseBuilder $builder)
    {
        $self = new self();
        $self->filePath = $builder->getFilePath();
        $self->height = $builder->getHeight();
        $self->width = $builder->getWidth();

        return $self;
    }
}
