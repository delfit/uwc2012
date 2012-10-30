SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `uwc2012` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `uwc2012` ;

-- -----------------------------------------------------
-- Table `uwc2012`.`Brand`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`Brand` (
  `BrandID` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`BrandID`) ,
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC) )
ENGINE = InnoDB
COMMENT = 'таблица брендов (производителей) (без переводов)';


-- -----------------------------------------------------
-- Table `uwc2012`.`Category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`Category` (
  `CategoryID` INT NOT NULL AUTO_INCREMENT ,
  `ParentCategoryID` INT NULL ,
  PRIMARY KEY (`CategoryID`) ,
  INDEX `FK_CategoryHasParentCategory_idx` (`ParentCategoryID` ASC) ,
  CONSTRAINT `FK_CategoryHasParentCategory`
    FOREIGN KEY (`ParentCategoryID` )
    REFERENCES `uwc2012`.`Category` (`CategoryID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'таблица категорий';


-- -----------------------------------------------------
-- Table `uwc2012`.`Feature`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`Feature` (
  `FeatureID` INT NOT NULL AUTO_INCREMENT ,
  `CategoryID` INT NOT NULL ,
  PRIMARY KEY (`FeatureID`) ,
  INDEX `FK_FeatureHasCategory_idx` (`CategoryID` ASC) ,
  CONSTRAINT `FK_FeatureHasCategory`
    FOREIGN KEY (`CategoryID` )
    REFERENCES `uwc2012`.`Category` (`CategoryID` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'таблица характеристик ';


-- -----------------------------------------------------
-- Table `uwc2012`.`Language`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`Language` (
  `LanguageID` SMALLINT NOT NULL AUTO_INCREMENT ,
  `Code` VARCHAR(3) NOT NULL COMMENT 'код языка (например, en, ru, ua)' ,
  `Name` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`LanguageID`) ,
  UNIQUE INDEX `Code_UNIQUE` (`Code` ASC) ,
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC) )
ENGINE = InnoDB
COMMENT = 'таблица языков';


-- -----------------------------------------------------
-- Table `uwc2012`.`CategoryTranslation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`CategoryTranslation` (
  `CategoryID` INT NOT NULL ,
  `LanguageID` SMALLINT NOT NULL ,
  `SingularName` VARCHAR(100) NOT NULL COMMENT 'название в единственном числе' ,
  `PluralName` VARCHAR(100) NOT NULL COMMENT 'название во множественном числе' ,
  INDEX `fk_CategoryTranslation_1_idx` (`CategoryID` ASC) ,
  INDEX `fk_CategoryTranslation_1_idx1` (`LanguageID` ASC) ,
  CONSTRAINT `FK_CategoryTranslationHasCategory`
    FOREIGN KEY (`CategoryID` )
    REFERENCES `uwc2012`.`Category` (`CategoryID` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_CategoryTranslationHasLanguage`
    FOREIGN KEY (`LanguageID` )
    REFERENCES `uwc2012`.`Language` (`LanguageID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'таблица переводов для категорий';


-- -----------------------------------------------------
-- Table `uwc2012`.`FeatureTranslation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`FeatureTranslation` (
  `FeatureID` INT NOT NULL ,
  `LanguageID` SMALLINT NOT NULL ,
  `Name` VARCHAR(100) NOT NULL ,
  `Description` TEXT NULL ,
  INDEX `FK_FeatureTranslationHasFeature_idx` (`FeatureID` ASC) ,
  INDEX `fk_FeatureTranslation_1_idx` (`LanguageID` ASC) ,
  CONSTRAINT `FK_FeatureTranslationHasFeature`
    FOREIGN KEY (`FeatureID` )
    REFERENCES `uwc2012`.`Feature` (`FeatureID` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_FeatureTranslationHasLanguage`
    FOREIGN KEY (`LanguageID` )
    REFERENCES `uwc2012`.`Language` (`LanguageID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'таблица переводов для характеристик';


-- -----------------------------------------------------
-- Table `uwc2012`.`Product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`Product` (
  `ProductID` INT NOT NULL AUTO_INCREMENT ,
  `CategoryID` INT NOT NULL ,
  `BrandID` INT NOT NULL ,
  `Name` VARCHAR(100) NOT NULL ,
  `IsDraft` TINYINT(1) NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`ProductID`) ,
  INDEX `FK_ProductHasCategory_idx` (`CategoryID` ASC) ,
  INDEX `fk_Product_1_idx` (`BrandID` ASC) ,
  CONSTRAINT `FK_ProductHasCategory`
    FOREIGN KEY (`CategoryID` )
    REFERENCES `uwc2012`.`Category` (`CategoryID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_ProductHasBrand`
    FOREIGN KEY (`BrandID` )
    REFERENCES `uwc2012`.`Brand` (`BrandID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'таблица товаров';


-- -----------------------------------------------------
-- Table `uwc2012`.`ProductTranslation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`ProductTranslation` (
  `ProductID` INT NOT NULL ,
  `LanguageID` SMALLINT NOT NULL ,
  `Description` TEXT NULL ,
  INDEX `FK_ProductTranslationHasProduct_idx` (`ProductID` ASC) ,
  INDEX `FK_ProductTranslationHasLanguage_idx` (`LanguageID` ASC) ,
  CONSTRAINT `FK_ProductTranslationHasProduct`
    FOREIGN KEY (`ProductID` )
    REFERENCES `uwc2012`.`Product` (`ProductID` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_ProductTranslationHasLanguage`
    FOREIGN KEY (`LanguageID` )
    REFERENCES `uwc2012`.`Language` (`LanguageID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'таблица переводов для товаров';


-- -----------------------------------------------------
-- Table `uwc2012`.`ProductHasFeatures`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`ProductHasFeatures` (
  `ProductHasFeatureID` INT NOT NULL AUTO_INCREMENT ,
  `ProductID` INT NOT NULL ,
  `FeatureID` INT NOT NULL ,
  `Index` SMALLINT NOT NULL COMMENT 'порядковый номер' ,
  `Value` TINYTEXT NOT NULL ,
  INDEX `fk_ProductHasFeatures_1_idx` (`ProductID` ASC) ,
  INDEX `FK_Feature_idx` (`FeatureID` ASC) ,
  PRIMARY KEY (`ProductHasFeatureID`) ,
  CONSTRAINT `FK_ProductProductHasFeatures`
    FOREIGN KEY (`ProductID` )
    REFERENCES `uwc2012`.`Product` (`ProductID` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_ProductFeatureHasFeature`
    FOREIGN KEY (`FeatureID` )
    REFERENCES `uwc2012`.`Feature` (`FeatureID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'таблица сопоставления товара с характеристиками';


-- -----------------------------------------------------
-- Table `uwc2012`.`ProductHasImages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uwc2012`.`ProductHasImages` (
  `ProductHasImagesID` INT NOT NULL AUTO_INCREMENT ,
  `ProductID` INT NOT NULL ,
  `Index` SMALLINT NOT NULL ,
  `FileName` TINYTEXT NOT NULL ,
  INDEX `FK_Product_idx` (`ProductID` ASC) ,
  PRIMARY KEY (`ProductHasImagesID`) ,
  CONSTRAINT `FK_ProductImageHasProduct`
    FOREIGN KEY (`ProductID` )
    REFERENCES `uwc2012`.`Product` (`ProductID` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'таблица сопоставления товара и изображений';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`Brand`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'Apple');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'Dell');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'Asus');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'Samsung');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'HTC');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'HP');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'Zelmer');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'Lenovo');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'LG');
INSERT INTO `uwc2012`.`Brand` (`BrandID`, `Name`) VALUES (NULL, 'Indesit');

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`Category`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (1, NULL);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (2, 1);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (3, 2);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (4, 2);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (5, 2);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (6, 1);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (7, 6);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (8, 6);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (9, 6);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (10, NULL);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (11, 10);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (12, 11);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (13, 10);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (14, 13);
INSERT INTO `uwc2012`.`Category` (`CategoryID`, `ParentCategoryID`) VALUES (15, 13);

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`Feature`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (1, 3);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (2, 3);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (3, 3);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (4, 3);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (5, 3);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (6, 3);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (7, 4);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (8, 4);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (9, 4);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (10, 4);
INSERT INTO `uwc2012`.`Feature` (`FeatureID`, `CategoryID`) VALUES (11, 4);

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`Language`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`Language` (`LanguageID`, `Code`, `Name`) VALUES (1, 'ua', 'Українська');
INSERT INTO `uwc2012`.`Language` (`LanguageID`, `Code`, `Name`) VALUES (2, 'ru', 'Русский');
INSERT INTO `uwc2012`.`Language` (`LanguageID`, `Code`, `Name`) VALUES (3, 'en', 'English');

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`CategoryTranslation`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (1, 2, 'Компьютеры и ноутбуки', 'Компьютеры и ноутбуки');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (2, 2, 'Ноутбуки', 'Ноутбуки');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (3, 2, 'Ноутбук', 'Ноутбуки');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (4, 2, 'Планшет', 'Планшеты');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (5, 2, 'Сумка для ноутбука', 'Сумки для ноутбуков');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (6, 2, 'Комплектующие', 'Комплектующие');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (7, 2, 'Процессор', 'Процессоры');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (8, 2, 'Материнская плата', 'Материнские платы');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (9, 2, 'Видеокарта', 'Видеокарты');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (10, 2, 'ТВ, фото- и видео', 'ТВ, фото- и видео');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (11, 2, 'ТВ-техника', 'ТВ-техника');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (12, 2, 'ЖК-телевизор', 'ЖК-телевизоры');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (13, 2, 'Фото и видео', 'Фото и видео');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (14, 2, 'Фотоаппарат', 'Фотоаппараты');
INSERT INTO `uwc2012`.`CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (15, 2, 'Видеокамер', 'Видеокамеры');

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`FeatureTranslation`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (1, 2, 'Экран', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (2, 2, 'Процессор', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (3, 2, 'Объем оперативной памяти', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (4, 2, 'Тип оперативной памяти', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (5, 2, 'Чипсет', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (6, 2, 'Жесткий диск', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (7, 2, 'Диагональ экрана', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (8, 2, 'Разрешение экрана', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (9, 2, 'Вид экрана', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (10, 2, 'Тип экрана', NULL);
INSERT INTO `uwc2012`.`FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (11, 2, 'Операционная система', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`Product`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`Product` (`ProductID`, `CategoryID`, `BrandID`, `Name`, `IsDraft`) VALUES (1, 3, 3, 'U31SD (U31SD-RX130R) Silver', 0);
INSERT INTO `uwc2012`.`Product` (`ProductID`, `CategoryID`, `BrandID`, `Name`, `IsDraft`) VALUES (2, 3, 6, 'ProBook 4540s (B6N43EA)', 0);

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`ProductTranslation`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`ProductTranslation` (`ProductID`, `LanguageID`, `Description`) VALUES (1, 2, 'Реализованная в U31SD технология Super Hybrid Engine при выполнении сложных задач автоматически увеличивает производительность системы вплоть до 15%. Но возможности этой технологии не ограничиваются разгоном центрального процессора: Super Hybrid Engine настраивает системные параметры таким образом, чтобы оптимизировать как производительность, так и энергопотребление ноутбука, и работает для этого в связке с новейшим процессором Intel Core i3.\n\nТехнология обеспечивает прирост производительности только при запуске программ, интенсивно использующих ресурсы процессор, таких как игры и видео высокой четкости, гарантируя стабильность работы всей системы.\n\nСовременному деловому человеку, много времени проводящему в разъездах, очень важно иметь под рукой функциональный ноутбук с возможностью как можно дольше работать без подзарядки.\n\nЧтобы увеличить время работы от батареи, при выполнении простых задач U31SD переводится в режим экономии потребления энергии. Технология Asus Super Hybrid Engine гарантирует работу ноутбука в автономном режиме до 10 часов, поэтому пользователю больше не нужно беспокоиться о подзарядке устройства во время поездки.\n\nКроме высокой производительности и хорошей автономности, ноутбук U31SD отличается элегантным и эргономичным дизайном. Толщина этого компактного ноутбука не превышает одного дюйма, поэтому он без труда поместится в рюкзаке или небольшой сумке.\n\nСочетание изысканного дизайна и технических инноваций делает этот мощный ультрапортативный ноутбук отличной покупкой.');
INSERT INTO `uwc2012`.`ProductTranslation` (`ProductID`, `LanguageID`, `Description`) VALUES (2, 2, 'Стильный ноутбук HP ProBook 4540s станет вашим незаменимым помощником в работе. Он оснащен матовым дисплеем HD диагональю 39.6 см (15.6\") с LED-подсветкой, клавиатурой и цифровой клавишной панелью с защитой от попадания жидкости и средствами беспроводной связи. Это идеальный выбор для профессиональных пользователей, часто находящихся в разъездах.\n\nЗащита изнутри и снаружи\n\n    Корпус из алюминия обеспечивает повышенную долговечность при использовании в пути. Стойкое к загрязнению и износу покрытие HP DuraFinish сохраняет первоначальное идеальное состояние полированного серого металла.\n    Водостойкая клавиатура защищает чувствительную электронику и ключевые компоненты от попадания небольшого количества жидкости благодаря тонкой майларовой пленке под клавишами.\n    Бывают происшествия, которые нельзя предотвратить. HP 3D DriveGuard защитит жесткий диск вашего ноутбука от ударов, толчков и падений, что укрепит защиту ваших данных.\n    Простые, но надежные средства безопасности защитят ваши данные от неправомочного доступа.\n\n\nПравильные инструменты для бизнеса — залог вашего успеха\n\n    Используйте дискретную графическую карту для создания блестящих изображений, и ваш компьютер будет автоматически переходить в режим экономии аккумулятора при использовании типовых приложений. Динамическая переключаемая графическая карта AMD сделает это сама, не отвлекая вас от дела.\n    Выделите сильные стороны своих презентаций. Воспроизводите, редактируйте и создавайте видео- и аудиофайлы с пакетом ArcSoft TotalMedia Suite.\n\n\nСочетайте бизнес и досуг\n\n    Смотрите учебные видеоролики на работе и наслаждайтесь любимыми фильмами дома – все это благодаря программам для мультимедиа, уже загруженным на компьютер.\n    После трудного рабочего дня расслабьтесь и послушайте любимую музыку прямо из своего рабочего ноутбука, оснащенного звуковой системой SRS Premium Sound.');

COMMIT;

-- -----------------------------------------------------
-- Data for table `uwc2012`.`ProductHasFeatures`
-- -----------------------------------------------------
START TRANSACTION;
USE `uwc2012`;
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (1, 1, 1, '13.3\" (1366x768) WXGA HD');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (1, 2, 2, 'Intel Core i3-2310M (2.1 GHz)');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (1, 3, 3, '4 GB');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (1, 4, 4, 'DDR3-1333');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (1, 5, 5, 'Intel HM65');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (1, 6, 6, '500 GB');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (2, 1, 1, '15.6\" (1366x768) WXGA HD');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (2, 2, 2, 'Intel Core i5-2450M (2.5 GHz)');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (2, 3, 3, '6 GB');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (2, 4, 4, 'DDR3-1333');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (2, 5, 5, 'Intel HM76 Express');
INSERT INTO `uwc2012`.`ProductHasFeatures` (`ProductID`, `FeatureID`, `Index`, `Value`) VALUES (2, 6, 6, '750 GB');

COMMIT;
