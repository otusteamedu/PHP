CREATE TABLE IF NOT EXISTS `otus_cinema`.`seat` (
  `id` TINYINT NOT NULL AUTO_INCREMENT,
  `seat_type` VARCHAR(45) NULL COMMENT 'название типа места (кресло простое, кресло кожанное элитное, диван и т.д.)',
  `cost_factor` DECIMAL(2,1) NULL COMMENT 'коэффициент на стоимсоть',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB