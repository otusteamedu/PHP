<?php

namespace TimGa\FillDb;

class DataGenerator
{
    public function generateMovie(): string
    {
        $randA = ['на', 'ну', 'но', 'ны', 'ни', 'не', 'ня', 'нё', 'ню', 'нэ', 'нь', 'ма', 'му', 'мо', 'мы', 'ми', 'ме', 'мя', 'мё', 'мю', 'мэ', 'мь', 'та', 'ту', 'то', 'ты', 'ти', 'те', 'тя', 'тё', 'тю', 'тэ', 'ть', 'ка', 'ку', 'ко', 'ки', 'ке', 'кё', 'кэ', 'кь', 'ха', 'ху', 'хо', 'хи', 'хе', 'хэ', 'хь', 'ба', 'бу', 'бо', 'бы', 'би', 'бе', 'бя', 'бё', 'бю', 'бэ', 'бь', 'ва', 'ву', 'во', 'вы', 'ви', 'ве', 'вя', 'вё', 'вю', 'вэ', 'вь', 'га', 'гу', 'го', 'ги', 'ге', 'гё', 'гэ', 'гь', 'да', 'ду', 'до', 'ды', 'ди', 'де', 'дя', 'дё', 'дю', 'дэ', 'дь', 'жа', 'жу', 'жо', 'жи', 'же', 'жё', 'жь', 'за', 'зу', 'зо', 'зы', 'зи', 'зе', 'зя', 'зё', 'зю', 'зэ', 'зь', 'ла', 'лу', 'ло', 'лы', 'ли', 'ле', 'ля', 'лё', 'лю', 'лэ', 'ль', 'па', 'пу', 'по', 'пы', 'пи', 'пе', 'пя', 'пё', 'пю', 'пэ', 'пь', 'ра', 'ру', 'ро', 'ры', 'ри', 'ре', 'ря', 'рё', 'рю', 'рэ', 'рь', 'са', 'су', 'со', 'сы', 'си', 'се', 'ся', 'сё', 'сю', 'сэ', 'сь', 'фа', 'фу', 'фо', 'фы', 'фи', 'фе', 'фя', 'фё', 'фю', 'фэ', 'фь', 'ца', 'цу', 'цо', 'цы', 'ци', 'це', 'ча', 'чу', 'чо', 'чи', 'че', 'чё', 'чь', 'ша', 'шу', 'шо', 'ши', 'ше', 'шё', 'шь', 'ща', 'щу', 'що', 'щи', 'ще', 'щё', 'щь', 'йа', 'йо', 'йи', 'йе', 'йю'];
        $randB = ['й', 'ль', 'р', 'к', 'с'];
        return $randA[array_rand($randA)] . $randA[array_rand($randA)] . $randB[array_rand($randB)];
    }

    public function generateMovieId(int $numOfMovies): int
    {
        return random_int(1, $numOfMovies);
    }

    public function generateHallId(int $maxHallId): int
    {
        return random_int(1, $maxHallId);
    }

    public function generateTicketStatusId($ticketsBoughtPercent): int
    {
        $result = 1;
        if (random_int(1, 100) <= $ticketsBoughtPercent) {
            $result = 2;
        }
        return $result;
    }

    public function generatePrice(int $hourOfDay): int
    {
        if ($hourOfDay < 13) {
            return 150;
        }
        if ($hourOfDay < 18) {
            return 200;
        }
        return 250;
    }

    public function generateSeatIdMin(int $hallId): int
    {
        switch ($hallId) {
            case 1:
                return 1;
            case 2:
                return 26;
            case 3:
                return 76;
            default:
                throw new \Exception("Error generating seatIdMin, unknown hallId");
        }
    }

    public function generateSeatIdMax(int $hallId): int
    {
        switch ($hallId) {
            case 1:
                return 25;
            case 2:
                return 75;
            case 3:
                return 175;
            default:
                throw new \Exception("Error generating seatIdMax, unknown hallId");
        }
    }
}
