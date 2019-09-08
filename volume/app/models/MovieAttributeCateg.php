<?php

namespace hw13\models;

use ActiveRecord\Model as ActiveRecord;

class MovieAttributeCateg extends ActiveRecord
{
    const IMPORTANT_DATES = 1;
    const INCOME = 2;
    const REWARDS = 3;
    const REVIEW = 4;

    const ALL_CATEGS = [
        MovieAttributeCateg::IMPORTANT_DATES => 'Важные даты',
        MovieAttributeCateg::INCOME => 'Кассовые сборы',
        MovieAttributeCateg::REWARDS => 'Награды',
        MovieAttributeCateg::REVIEW => 'Рецензии',
    ];

    static $table_name = "movie_attribute_categ";
}
