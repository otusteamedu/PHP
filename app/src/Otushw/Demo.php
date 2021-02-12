<?php


namespace Otushw;

use Otushw\Adapter\HTMLNewsAdapter;
use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Observer\LoggerObserver;
use Otushw\Proxy\HTMLRenderProxy;
use Otushw\Visitor\SeparatorNews;

class Demo
{

    const LENGTH_RANDOM_STRING = 5;

    public function __construct()
    {
        $articles = [];
        // Генерируем 5 статей, 5 обзоров в форматах XML и HTML
        foreach (['XML', 'HTML'] as $format) {
            $article = new Article($format);
            // Добавляем логгер-наблюдатель в каждую фабрику, который пишет в лог.
            $article->attach(new LoggerObserver());
            for ($i = 0; $i < 5; $i++) {
                // Процесс генерации статей
                $articles[] = $article->create($this->getRandomNews());
                $articles[] = $article->create($this->getRandomReviews());
            }
        }
        // Нужно отсортировать статьи, оставить только новости.
        // Создаем для этого посетителя.
        $separotor = new SeparatorNews($articles);
        foreach ($articles as $article) {
            // Статья вызывает Посетителя, если это обзор, то удалить
            // статью из Посетителя.
            $article->accept($separotor);
        }
        // Забрать все оставшиеся статьи из Посетителя.
        // Массив $allNews содержит в новости в разных форматах(XML, HTML).
        $allNews = $separotor->getNews();

        // Закэшруем HTML-render для новостей.
        $proxy = new HTMLRenderProxy('news');
        foreach ($allNews as $item) {
            // Будет возвращать из кэша HTML-render.
            // Я понимаю, что можно было вынести из цикла $proxy->getRender(),
            // но другой пример для Proxy не приходит в голову.
            $render = $proxy->getRender();
            // Проходим по всему массиму $allNews, изменяя render на HTML-render.
            $adaptedHTMLNews = new HTMLNewsAdapter($item, $render);
            // Теперь все статьи могут выводиться в HTML.
            // Вывод статей.
            $adaptedHTMLNews->render();
        }
    }

    private function getRandomNews(): NewsDTO
    {
        return new NewsDTO(
            $this->generateRandomProperty('title'),
            $this->generateRandomProperty('body'),
            time(),
            $this->generateRandomProperty('event')
        );
    }

    private function getRandomReviews(): ReviewsDTO
    {
        return new ReviewsDTO(
            $this->generateRandomProperty('title'),
            $this->generateRandomProperty('body'),
            time(),
            $this->generateRandomProperty('nameProduct')
        );
    }

    private function generateRandomProperty(string $property): string
    {
        return $property . '_' . bin2hex(random_bytes(self::LENGTH_RANDOM_STRING));
    }

}
