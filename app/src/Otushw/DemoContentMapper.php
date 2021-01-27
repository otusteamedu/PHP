<?php


namespace Otushw;

use Otushw\Storage\MapperInterface;

class DemoContentMapper
{

    /**
     * @var MapperInterface
     */
    private MapperInterface $mapper;

    /**
     * @param MapperInterface $mapper
     */
    public function __construct(MapperInterface $mapper)
    {
        $this->mapper = $mapper;
        $this->demonstrate();
    }

    /**
     * @throws Exception\AppException
     */
    private function demonstrate(): void
    {
        $content = $this->adding();
        $this->updating($content[1]);
        $this->collection();
    }

    /**
     * @return array
     * @throws AppException
     */
    private function adding(): array
    {
        Message::showMessage('Demo: Insert');
        $buf = [];
        for ($i = 0; $i < 5; $i++) {
            $content = $this->mapper->insert(
                new ContentDTO(
                    'php_' . random_int(0, 1000),
                    random_int(1, 5),
                    random_int(1, 1000),
                    random_int(60, 120)
                )
            );
            Message::showMessage('Was insirted ID: ' . $content->getId());
            $buf[] = $content;
        }
        $this->isSameObjects($buf[0]);

        return $buf;
    }

    /**
     * @param Content $content
     *
     * @throws Exception\AppException
     */
    private function updating(Content $content): void
    {
        Message::showMessage('Demo: Update');
        $content->setName('php__' . rand(0, 10000));
        $this->mapper->update($content);
        $this->isSameObjects($content);
    }

    /**
     * @throws Exception\AppException
     */
    private function collection(): void
    {
        Message::showMessage('Demo: work with Collection');
        $collection = $this->mapper->getBatch();
        foreach ($collection as $key => $item) {
            $this->isSameObjects($item);
        }
    }

    /**
     * @param Content $content
     */
    private function isSameObjects(Content $content): void
    {
        $id = $content->getId();
        $checkedContent = $this->mapper->findById($id);
        $result = $content === $checkedContent;

        $msg = 'The object is the same. ID: ' . $id;
        if (!$result) {
            $msg = 'These are different objects. ID: ' . $id . ', found Object ID: ' . $checkedContent->getId();
        }
        Message::showMessage($msg);
    }
}