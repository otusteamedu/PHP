<?php

namespace App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer;

class PHPTemplateRenderer implements TemplateRendererInterface
{
    public function render(string $templateString, array $arguments = []): string
    {
        extract($arguments, EXTR_OVERWRITE);
        ob_start();
        eval(' ?>' . $templateString . '<?php ');
        return ob_get_clean();
    }
}