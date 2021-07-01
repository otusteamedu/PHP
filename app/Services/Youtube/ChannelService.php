<?php


namespace App\Services\Youtube;


use App\Models\Channel;
use App\Services\Youtube\Repositories\SearchChannelRepository;
use App\Services\Youtube\Repositories\Statistics\ViewChannelRepository;
use App\Services\Youtube\Repositories\WriteChannelRepository;
use Illuminate\Support\Collection;

class ChannelService
{
    /**
     * Хранит Объект класса SearchChannelRepository
     * Значение устанавливается в конструкторе
     * @var SearchChannelRepository
     */
    private SearchChannelRepository $searchChannelRepository;

    /**
     * Хранит Объект класса WriteChannelRepository
     * Значение устанавливается в конструкторе
     * @var WriteChannelRepository
     */
    private WriteChannelRepository $writeChannelRepository;

    /**
     * Хранит Объект класса ViewChannelRepository
     * Значение устанавливается в конструкторе
     * @var ViewChannelRepository
     */
    private ViewChannelRepository $viewChannelRepository;

    /**
     * ChannelService constructor.
     *
     * Значения $channelRepository, $writeChannelRepository, и $viewChannelRepository
     * Laravel подставляет в виде новых объектов с набором свойств и методов этих классов,
     * которые прописаны в соответствующих интерфейсах и имлементированы в данные классы.
     * Они необходимы, чтобы ChannelService, используемый как класс, реализующий набор методов для
     * доступа к данным не зависил от реализации базы данных. И скажем для интерфейса SearchChannelRepository
     * существует два реальных класса ElasticsearchSearchChannelRepository и EloquentSearchChannelRepository
     * @param SearchChannelRepository $channelRepository
     * @param WriteChannelRepository $writeChannelRepository
     * @param ViewChannelRepository $viewChannelRepository
     */
    public function __construct(
        SearchChannelRepository $channelRepository,
        WriteChannelRepository $writeChannelRepository,
        ViewChannelRepository $viewChannelRepository
    )
    {
        $this->searchChannelRepository = $channelRepository;
        $this->writeChannelRepository = $writeChannelRepository;
        $this->viewChannelRepository = $viewChannelRepository;
    }

    /**
     * Возвращает результат поиска в виде коллекции из объектов Channel
     *
     * @param string $q
     * @param int $limit
     * @param int $offset
     * @return Collection
     */
    public function search(string $q, int $limit, int $offset): Collection
    {
        return $this->searchChannelRepository->search($q, $limit, $offset);
    }

    /**
     * Возвращает объект Channel по Id канала = $channelId
     * @param int $channelId
     * @return Channel
     */
    public function getChannelsById(int $channelId): Channel
    {
        return $this->searchChannelRepository->getChannelById($channelId);
    }

    /**
     * Возвращает суммарное количество лайков для канала с id = $channelId
     *
     * @param int $channelId
     * @return int
     */
    public function getLikesCountForChannel(int $channelId): int
    {
        return $this->viewChannelRepository->getLikesCount($channelId);
    }

    /**
     * Возвращает суммарное количество дизлайков для канала с id = $channelId
     *
     * @param int $channelId
     * @return int
     */
    public function getDislikesCountForChannel(int $channelId): int
    {
        return $this->viewChannelRepository->getDislikesCount($channelId);
    }

    public function getCommentsCountForChannel(int $channelId): int
    {
        return $this->viewChannelRepository->getCommentsCount($channelId);
    }

    public function getViewsCountForChannel(int $channelId): int
    {
        return $this->viewChannelRepository->getViewsCount($channelId);
    }

    /**
     * Создает новый канал в базе данных и возвращает его id
     * Дла методов 'create', 'update' и 'delete' используется интерфейс WriteChannelRepository,
     * у которого нет реализации для Эластики, т.к. основная база данных это MySql. Запись в эластику происходит
     * через события обрабатываемые в ChannelObserve, в котором реализовано добавление в индекс или изменение данных
     * в индексе Elasticsearch
     *
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        return $this->writeChannelRepository->create($data);
    }

    /**
     * Изменяет данные канала с id=$id в базе данных
     *
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data): void
    {
        $this->writeChannelRepository->update($id, $data);
    }

    /**
     * Удаляет канал с id=$id из базы данных
     * @param int $id
     * @return int
     */
    public function delete(int $id)    : int
    {
        return $this->writeChannelRepository->delete($id);
    }

}
