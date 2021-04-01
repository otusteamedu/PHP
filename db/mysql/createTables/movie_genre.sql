CREATE TABLE IF NOT EXISTS `otus_cinema`.`movie_genre` (
  `id` TINYINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25) NULL COMMENT 'Наименование жанра',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB