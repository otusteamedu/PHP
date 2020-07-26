<?php


namespace App\Services\Export\Diagrams;


use App\Services\AdvCampaigns\ActivityStatistic\SharesReportPart;
use App\Services\AdvCampaigns\ActivityStatistic\SimpleReportPart;
use Illuminate\Support\Collection;
use Translit;


abstract class BaseDiagram
{
    protected function getColor(\ArrayIterator $arrayIterator)
    {
        if (!$arrayIterator->valid()) {
            $arrayIterator->rewind();
        }
        $result = $arrayIterator->current();
        $arrayIterator->next();
        return $result;
    }

    //TODO изменить логику получения данных ActivityStatisticServiceImpl, после удалить данный метод
    protected function getMapFormattedCollection(Collection $collection)
    {

        /** @var SimpleReportPart $part */
        $filteredCollection = $collection->filter(static function (SimpleReportPart $part) {
            $regionCode = $part->getCode();
            return $regionCode !== 'kavkaz' && $regionCode !== 'south';
        });

        /** @var SimpleReportPart $kavkaz */
        $kavkaz = $collection->firstWhere('code', 'kavkaz');
        /** @var SimpleReportPart $south */
        $south = $collection->firstWhere('code', 'south');

        $newSouth = new SimpleReportPart(
            $south->getTitle(),
            $south->getValue() + $kavkaz->getValue(),
            $south->getCode(),
            $south->getShare()
        );

        $filteredCollection->add($newSouth);

        return $filteredCollection->sortByDesc(static function (SimpleReportPart $part) {
            return (int)$part->getValue();
        });
    }

    //TODO изменить логику получения данных ActivityStatisticServiceImpl, после удалить данный метод
    protected function getValuesMapFormattedCollection(Collection $collection)
    {

        /** @var SimpleReportPart $part */
        $filteredCollection = $collection->filter(static function (SharesReportPart $part) {
            $regionCode = $part->getCode();
            return $regionCode !== 'kavkaz';
        });

        /** @var SimpleReportPart $part */
        $formattedCollection = $filteredCollection->map(static function (SharesReportPart $part) use ($collection) {
            $regionCode = $part->getCode();
            if ($regionCode === 'south') {

                /** @var SharesReportPart $kavkaz */
                $kavkaz = $collection->firstWhere('code', 'kavkaz');

                $kavkazSharesCollection = $kavkaz->getShares();

                if ($kavkazSharesCollection->count() < 1) {
                    return $part;
                }

                $southSharesCollection = $part->getShares();
                $newSouthItemsCollection = $southSharesCollection->map(static function (SimpleReportPart $southPart) use ($kavkazSharesCollection) {

                    $kavkazItem = $kavkazSharesCollection->first(static function (SimpleReportPart $item) use ($southPart) {
                        return $southPart->getTitle() === $item->getTitle();
                    });

                    $value = $southPart->getValue();
                    if ($kavkazItem->getValue()) {
                        $value += $kavkazItem->getValue();
                    }
                    return new SimpleReportPart(
                        $southPart->getTitle(),
                        $value,
                        $southPart->getCode(),
                        $southPart->getShare()
                    );
                });
                $shareReportPart = new SharesReportPart($part->getTitle(), $part->getCode(), $newSouthItemsCollection->sum('value'));

                $newSouthItemsCollection->each(static function (SimpleReportPart $simpleReportPart) use ($shareReportPart) {
                    return $shareReportPart->addShares($simpleReportPart);
                });

                return $shareReportPart;
            }

            return $part;
        });

        return $formattedCollection;
    }

    protected function getFileName(string $title)
    {
        return md5($title);
    }
}
