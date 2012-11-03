-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: uwc2012
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Brand`
--

DROP TABLE IF EXISTS `Brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Brand` (
  `BrandID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`BrandID`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='таблица брендов (производителей) (без переводов)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Brand`
--

LOCK TABLES `Brand` WRITE;
/*!40000 ALTER TABLE `Brand` DISABLE KEYS */;
INSERT INTO `Brand` (`BrandID`, `Name`) VALUES (11,'Amazon'),(1,'Apple'),(3,'Asus'),(2,'Dell'),(6,'HP'),(5,'HTC'),(10,'Indesit'),(8,'Lenovo'),(9,'LG'),(4,'Samsung'),(7,'Zelmer');
/*!40000 ALTER TABLE `Brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Category`
--

DROP TABLE IF EXISTS `Category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Category` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentCategoryID` int(11) DEFAULT NULL,
  PRIMARY KEY (`CategoryID`),
  KEY `FK_CategoryHasParentCategory_idx` (`ParentCategoryID`),
  CONSTRAINT `FK_CategoryHasParentCategory` FOREIGN KEY (`ParentCategoryID`) REFERENCES `Category` (`CategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='таблица категорий';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Category`
--

LOCK TABLES `Category` WRITE;
/*!40000 ALTER TABLE `Category` DISABLE KEYS */;
INSERT INTO `Category` (`CategoryID`, `ParentCategoryID`) VALUES (1,NULL),(10,NULL),(2,1),(6,1),(3,2),(4,2),(5,2),(7,6),(8,6),(9,6),(11,10),(13,10),(12,11),(14,13),(15,13);
/*!40000 ALTER TABLE `Category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CategoryTranslation`
--

DROP TABLE IF EXISTS `CategoryTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CategoryTranslation` (
  `CategoryID` int(11) NOT NULL,
  `LanguageID` smallint(6) NOT NULL,
  `SingularName` varchar(100) NOT NULL COMMENT 'название в единственном числе',
  `PluralName` varchar(100) NOT NULL COMMENT 'название во множественном числе',
  KEY `fk_CategoryTranslation_1_idx` (`CategoryID`),
  KEY `fk_CategoryTranslation_1_idx1` (`LanguageID`),
  CONSTRAINT `FK_CategoryTranslationHasCategory` FOREIGN KEY (`CategoryID`) REFERENCES `Category` (`CategoryID`) ON DELETE CASCADE,
  CONSTRAINT `FK_CategoryTranslationHasLanguage` FOREIGN KEY (`LanguageID`) REFERENCES `Language` (`LanguageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица переводов для категорий';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CategoryTranslation`
--

LOCK TABLES `CategoryTranslation` WRITE;
/*!40000 ALTER TABLE `CategoryTranslation` DISABLE KEYS */;
INSERT INTO `CategoryTranslation` (`CategoryID`, `LanguageID`, `SingularName`, `PluralName`) VALUES (1,2,'Компьютеры и ноутбуки','Компьютеры и ноутбуки'),(2,2,'Ноутбуки','Ноутбуки'),(3,2,'Ноутбук','Ноутбуки'),(4,2,'Планшет','Планшеты'),(5,2,'Сумка для ноутбука','Сумки для ноутбуков'),(6,2,'Комплектующие','Комплектующие'),(7,2,'Процессор','Процессоры'),(8,2,'Материнская плата','Материнские платы'),(9,2,'Видеокарта','Видеокарты'),(10,2,'ТВ, фото- и видео','ТВ, фото- и видео'),(11,2,'ТВ-техника','ТВ-техника'),(12,2,'ЖК-телевизор','ЖК-телевизоры'),(13,2,'Фото и видео','Фото и видео'),(14,2,'Фотоаппарат','Фотоаппараты'),(15,2,'Видеокамер','Видеокамеры'),(1,3,'Computers and notebooks','Computers and notebooks'),(10,3,'TV, Photo and Video','TV, Photo and Video'),(2,3,'Notebooks','Notebooks'),(6,3,'Components','Components'),(11,3,'TV','TV'),(13,3,'Photo and Video','Photo and Video'),(3,3,'Notebook','Notebooks'),(4,3,'Tablet','Tablets'),(5,3,'Laptop Bag','Laptop Bags'),(7,3,'Processor','Processors'),(8,3,'Motherboard','Motherboards'),(9,3,'Video Card','Video Cards'),(12,3,'LCD TV','LCD TVs'),(14,3,'Camera','Cameras'),(15,3,'Camcorder','Camcorders'),(1,1,'Комп\'ютери та ноутбуки','Комп\'ютери та ноутбуки'),(10,1,'ТВ, фото-та відео','ТВ, фото-та відео'),(2,1,'Ноутбуки','Ноутбуки'),(11,1,'ТВ-техніка','ТВ-техніка'),(3,1,'Ноутбук','Ноутбуки'),(4,1,'Планшет','Планшети'),(5,1,'Сумка для ноутбука','Сумки для ноутбуків'),(12,1,'РК-телевізор','РК-телевізори'),(14,1,'Фотоапарат','Фотоапарати'),(15,1,'Відеокамера','Відеокамери'),(7,1,'Процесор','Процесори'),(8,1,'Материнська плата','Материнські плати'),(9,1,'Відеокарта','Відеокарти'),(6,1,'Комплектуючі','Комплектуючі');
/*!40000 ALTER TABLE `CategoryTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Feature`
--

DROP TABLE IF EXISTS `Feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Feature` (
  `FeatureID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryID` int(11) NOT NULL,
  PRIMARY KEY (`FeatureID`),
  KEY `FK_FeatureHasCategory_idx` (`CategoryID`),
  CONSTRAINT `FK_FeatureHasCategory` FOREIGN KEY (`CategoryID`) REFERENCES `Category` (`CategoryID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='таблица характеристик ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Feature`
--

LOCK TABLES `Feature` WRITE;
/*!40000 ALTER TABLE `Feature` DISABLE KEYS */;
INSERT INTO `Feature` (`FeatureID`, `CategoryID`) VALUES (1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,4),(8,4),(9,4),(10,4),(11,4);
/*!40000 ALTER TABLE `Feature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FeatureTranslation`
--

DROP TABLE IF EXISTS `FeatureTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FeatureTranslation` (
  `FeatureID` int(11) NOT NULL,
  `LanguageID` smallint(6) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text,
  KEY `FK_FeatureTranslationHasFeature_idx` (`FeatureID`),
  KEY `fk_FeatureTranslation_1_idx` (`LanguageID`),
  CONSTRAINT `FK_FeatureTranslationHasFeature` FOREIGN KEY (`FeatureID`) REFERENCES `Feature` (`FeatureID`) ON DELETE CASCADE,
  CONSTRAINT `FK_FeatureTranslationHasLanguage` FOREIGN KEY (`LanguageID`) REFERENCES `Language` (`LanguageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица переводов для характеристик';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FeatureTranslation`
--

LOCK TABLES `FeatureTranslation` WRITE;
/*!40000 ALTER TABLE `FeatureTranslation` DISABLE KEYS */;
INSERT INTO `FeatureTranslation` (`FeatureID`, `LanguageID`, `Name`, `Description`) VALUES (1,2,'Экран',NULL),(2,2,'Процессор',NULL),(3,2,'Объем оперативной памяти',NULL),(4,2,'Тип оперативной памяти',NULL),(5,2,'Чипсет',NULL),(6,2,'Жесткий диск',NULL),(7,2,'Диагональ экрана',NULL),(8,2,'Разрешение экрана',NULL),(9,2,'Вид экрана',NULL),(10,2,'Тип экрана',NULL),(11,2,'Операционная система',NULL),(1,3,'Screen',NULL),(2,3,'Processor',NULL),(3,3,'Memory amount',NULL),(4,3,'Memory type',NULL),(5,3,'Chipset',NULL),(6,3,'Hard disk',NULL),(1,1,'Екран',NULL),(2,1,'Процесор',NULL),(3,1,'Об\'єм оперативної пам\'яті',NULL),(4,1,'Тип оперативної пам\'яті',NULL),(5,1,'Чіпсет',NULL),(6,1,'Жорсткий диск',NULL),(7,1,'Діагональ екрану',NULL),(8,1,'Роздільна здатність ',NULL),(9,1,'Вид екрану',NULL),(10,1,'Тип екрану',NULL),(11,1,'Операційна система',NULL),(11,3,'Operating system',NULL),(7,3,'Screen size',NULL),(8,3,'Screen resolution',NULL),(9,3,'Screen',NULL),(10,3,'Screen type',NULL);
/*!40000 ALTER TABLE `FeatureTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Language`
--

DROP TABLE IF EXISTS `Language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Language` (
  `LanguageID` smallint(6) NOT NULL AUTO_INCREMENT,
  `Code` varchar(3) NOT NULL COMMENT 'код языка (например, en, ru, ua)',
  `Name` varchar(20) NOT NULL,
  PRIMARY KEY (`LanguageID`),
  UNIQUE KEY `Code_UNIQUE` (`Code`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='таблица языков';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Language`
--

LOCK TABLES `Language` WRITE;
/*!40000 ALTER TABLE `Language` DISABLE KEYS */;
INSERT INTO `Language` (`LanguageID`, `Code`, `Name`) VALUES (1,'uk','Українська'),(2,'ru','Русский'),(3,'en','English');
/*!40000 ALTER TABLE `Language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryID` int(11) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `IsDraft` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ProductID`),
  KEY `FK_ProductHasCategory_idx` (`CategoryID`),
  KEY `fk_Product_1_idx` (`BrandID`),
  CONSTRAINT `FK_ProductHasCategory` FOREIGN KEY (`CategoryID`) REFERENCES `Category` (`CategoryID`),
  CONSTRAINT `FK_ProductHasBrand` FOREIGN KEY (`BrandID`) REFERENCES `Brand` (`BrandID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='таблица товаров';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` (`ProductID`, `CategoryID`, `BrandID`, `Name`, `IsDraft`) VALUES (1,3,3,'U31SD (U31SD-RX130R) Silver',0),(2,3,6,'ProBook 4540s (B6N43EA)',0),(3,4,11,'Kindle Fire HD',1),(4,4,3,'PadFone A66 32GB (A66-1A088WWE)',1),(5,4,4,'Galaxy Tab 2 10.1 3G (GT-P5100ZWASEK)',1);
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductHasFeatures`
--

DROP TABLE IF EXISTS `ProductHasFeatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductHasFeatures` (
  `ProductHasFeatureID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `FeatureID` int(11) NOT NULL,
  `Index` smallint(6) NOT NULL COMMENT 'порядковый номер',
  `Value` tinytext NOT NULL,
  PRIMARY KEY (`ProductHasFeatureID`),
  KEY `fk_ProductHasFeatures_1_idx` (`ProductID`),
  KEY `FK_Feature_idx` (`FeatureID`),
  CONSTRAINT `FK_ProductProductHasFeatures` FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`) ON DELETE CASCADE,
  CONSTRAINT `FK_ProductFeatureHasFeature` FOREIGN KEY (`FeatureID`) REFERENCES `Feature` (`FeatureID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='таблица сопоставления товара с характеристиками';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductHasFeatures`
--

LOCK TABLES `ProductHasFeatures` WRITE;
/*!40000 ALTER TABLE `ProductHasFeatures` DISABLE KEYS */;
INSERT INTO `ProductHasFeatures` (`ProductHasFeatureID`, `ProductID`, `FeatureID`, `Index`, `Value`) VALUES (1,1,1,127,'13.3\" (1366x768) WXGA HD'),(2,1,2,128,'Intel Core i3-2310M (2.1 GHz)'),(3,1,3,129,'4 GB'),(4,1,4,130,'DDR3-1333'),(5,1,5,131,'Intel HM65'),(6,1,6,132,'500 GB'),(7,2,1,55,'15.6\" (1366x768) WXGA HD'),(8,2,2,56,'Intel Core i5-2450M (2.5 GHz)'),(9,2,3,57,'6 GB'),(10,2,4,58,'DDR3-1333'),(11,2,5,59,'Intel HM76 Express'),(12,2,6,60,'750 GB'),(13,3,7,31,'7\"'),(14,3,8,32,'1280x800'),(15,3,9,33,'Емкостный'),(16,3,10,34,'IPS'),(17,3,11,35,'Android 4.0'),(18,4,7,31,'10.1\"'),(19,4,8,32,'1280x800'),(20,4,9,33,'Емкостный'),(21,4,10,34,'Super AMOLED'),(22,4,11,35,'Android 4.0'),(23,5,7,36,'10.1\"'),(24,5,8,37,'1280x800'),(25,5,9,38,'Емкостный'),(26,5,10,39,'PLS'),(27,5,11,40,'Android 4.0');
/*!40000 ALTER TABLE `ProductHasFeatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductHasImages`
--

DROP TABLE IF EXISTS `ProductHasImages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductHasImages` (
  `ProductHasImagesID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `Index` smallint(6) NOT NULL,
  `FileName` tinytext NOT NULL,
  PRIMARY KEY (`ProductHasImagesID`),
  KEY `FK_Product_idx` (`ProductID`),
  CONSTRAINT `FK_ProductImageHasProduct` FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='таблица сопоставления товара и изображений';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductHasImages`
--

LOCK TABLES `ProductHasImages` WRITE;
/*!40000 ALTER TABLE `ProductHasImages` DISABLE KEYS */;
INSERT INTO `ProductHasImages` (`ProductHasImagesID`, `ProductID`, `Index`, `FileName`) VALUES (3,1,2,'U31SD__U31SD_RX130R__Silver_1_2.jpg'),(4,1,1,'U31SD__U31SD_RX130R__Silver_1_3.jpg'),(5,1,0,'U31SD__U31SD_RX130R__Silver_1_4.jpg'),(6,1,3,'U31SD__U31SD_RX130R__Silver_1_5.jpg'),(9,1,4,'U31SD__U31SD_RX130R__Silver_1_8.jpg'),(10,2,2,'ProBook_4540s__B6N43EA__2_1.jpg'),(11,2,3,'ProBook_4540s__B6N43EA__2_10.jpg'),(12,2,1,'ProBook_4540s__B6N43EA__2_11.jpg'),(13,2,0,'ProBook_4540s__B6N43EA__2_12.jpg'),(14,3,0,'Kindle_Fire_HD_3_1.jpg'),(15,3,1,'Kindle_Fire_HD_3_14.jpg'),(16,3,2,'Kindle_Fire_HD_3_15.jpg'),(17,3,3,'Kindle_Fire_HD_3_16.jpg'),(18,4,0,'PadFone_A66_32GB__A66_1A088WWE__4_1.jpg'),(19,4,1,'PadFone_A66_32GB__A66_1A088WWE__4_18.jpg'),(21,4,2,'PadFone_A66_32GB__A66_1A088WWE__4_19.jpg'),(22,5,0,'Galaxy_Tab_2_10_1_3G__GT_P5100ZWASEK__5_1.jpg'),(23,5,1,'Galaxy_Tab_2_10_1_3G__GT_P5100ZWASEK__5_22.jpg'),(24,5,2,'Galaxy_Tab_2_10_1_3G__GT_P5100ZWASEK__5_23.jpg'),(25,5,3,'Galaxy_Tab_2_10_1_3G__GT_P5100ZWASEK__5_24.jpg'),(26,5,4,'Galaxy_Tab_2_10_1_3G__GT_P5100ZWASEK__5_25.jpg');
/*!40000 ALTER TABLE `ProductHasImages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductTranslation`
--

DROP TABLE IF EXISTS `ProductTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductTranslation` (
  `ProductID` int(11) NOT NULL,
  `LanguageID` smallint(6) NOT NULL,
  `Description` text,
  KEY `FK_ProductTranslationHasProduct_idx` (`ProductID`),
  KEY `FK_ProductTranslationHasLanguage_idx` (`LanguageID`),
  CONSTRAINT `FK_ProductTranslationHasProduct` FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`) ON DELETE CASCADE,
  CONSTRAINT `FK_ProductTranslationHasLanguage` FOREIGN KEY (`LanguageID`) REFERENCES `Language` (`LanguageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица переводов для товаров';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductTranslation`
--

LOCK TABLES `ProductTranslation` WRITE;
/*!40000 ALTER TABLE `ProductTranslation` DISABLE KEYS */;
INSERT INTO `ProductTranslation` (`ProductID`, `LanguageID`, `Description`) VALUES (1,2,'<p><p>Реализованная в&nbsp;<b>U31SD</b>&nbsp;технология Super Hybrid Engine при выполнении сложных задач автоматически увеличивает производительность системы вплоть до 15%. Но возможности этой технологии не ограничиваются разгоном центрального процессора: Super Hybrid Engine настраивает системные параметры таким образом, чтобы оптимизировать как производительность, так и энергопотребление ноутбука, и работает для этого в связке с новейшим процессором Intel Core i3.</p><p>Технология обеспечивает прирост производительности только при запуске программ, интенсивно использующих ресурсы процессор, таких как игры и видео высокой четкости, гарантируя стабильность работы всей системы.</p><p>Современному деловому человеку, много времени проводящему в разъездах, очень важно иметь под рукой функциональный ноутбук с возможностью как можно дольше работать без подзарядки.</p><p>Чтобы увеличить время работы от батареи, при выполнении простых задач&nbsp;<b>U31SD</b>&nbsp;переводится в режим экономии потребления энергии. Технология Asus Super Hybrid Engine гарантирует работу ноутбука в автономном режиме до 10 часов, поэтому пользователю больше не нужно беспокоиться о подзарядке устройства во время поездки.</p><p>Кроме высокой производительности и хорошей автономности, ноутбук U31SD отличается элегантным и эргономичным дизайном. Толщина этого компактного ноутбука не превышает одного дюйма, поэтому он без труда поместится в рюкзаке или небольшой сумке.</p><p>Сочетание изысканного дизайна и технических инноваций делает этот мощный ультрапортативный ноутбук отличной покупкой.<br></p></p>'),(2,2,'<p><p>Стильный ноутбук&nbsp;<b>HP ProBook 4540s</b>&nbsp;станет вашим незаменимым помощником в работе. Он оснащен матовым дисплеем HD диагональю 39.6 см (15.6\") с LED-подсветкой, клавиатурой и цифровой клавишной панелью с защитой от попадания жидкости и средствами беспроводной связи. Это идеальный выбор для профессиональных пользователей, часто находящихся в разъездах.</p><p><b>Защита изнутри и снаружи</b></p><ul><li>Корпус из алюминия обеспечивает повышенную долговечность при использовании в пути. Стойкое к загрязнению и износу покрытие HP DuraFinish сохраняет первоначальное идеальное состояние полированного серого металла.</li><li>Водостойкая клавиатура защищает чувствительную электронику и ключевые компоненты от попадания небольшого количества жидкости благодаря тонкой майларовой пленке под клавишами.</li><li>Бывают происшествия, которые нельзя предотвратить. HP 3D DriveGuard защитит жесткий диск вашего ноутбука от ударов, толчков и падений, что укрепит защиту ваших данных.</li><li>Простые, но надежные средства безопасности защитят ваши данные от неправомочного доступа.</li></ul><br><p><b>Правильные инструменты для бизнеса — залог вашего успеха</b></p><ul><li>Используйте дискретную графическую карту для создания блестящих изображений, и ваш компьютер будет автоматически переходить в режим экономии аккумулятора при использовании типовых приложений. Динамическая переключаемая графическая карта AMD сделает это сама, не отвлекая вас от дела.</li><li>Выделите сильные стороны своих презентаций. Воспроизводите, редактируйте и создавайте видео- и аудиофайлы с пакетом ArcSoft TotalMedia Suite.</li></ul><br><p><b>Сочетайте бизнес и досуг</b></p><ul><li>Смотрите учебные видеоролики на работе и наслаждайтесь любимыми фильмами дома – все это благодаря программам для мультимедиа, уже загруженным на компьютер.</li><li>После трудного рабочего дня расслабьтесь и послушайте любимую музыку прямо из своего рабочего ноутбука, оснащенного звуковой системой SRS Premium Sound.<br></li></ul></p>'),(2,3,'<div class=\"record-description\"><div class=\"shorten\"><div id=\"short_description\" class=\"box-hide\"><p><div><div><div><div><div><div><p>Stylish Laptop&nbsp;<b>HP ProBook 4540s</b>&nbsp;will be your indispensable assistant in the work.&nbsp;It is equipped with HD matte display diagonal 39.6 cm (15.6 \") LED-backlit display, a keyboard and numeric keypad with protection against ingress of liquids and wireless communication. This is an ideal solution for professional users, often on the move.</p><p><b>Protection inside and out</b></p><ul><li>Aluminum casing provides increased durability when used on the road.Resistant to dirt and wear HP DuraFinish coating retains its original perfect condition polished gray metal.</li><li>Spill-proof keyboard protects sensitive electronics and key components from getting a small amount of fluid through a thin Mylar film under the keys.</li><li>There are incidents that can not be prevented.&nbsp;HP 3D DriveGuard protects the hard drive of your laptop from shocks, bumps and drops that will enhance the protection of your data.</li><li>Simple but robust security will protect your data from unauthorized access.</li></ul><br><p><b>The right tools for business - your success</b></p><ul><li>Use a discrete graphics card to create brilliant images, and your computer will automatically switch to battery saver mode when using sample applications.&nbsp;Dynamic switchable AMD graphics card to do it myself, without distracting you from the case.</li><li>Highlight the strengths of their presentations.&nbsp;Reproduce, edit and create video and audio files with Service ArcSoft TotalMedia Suite.</li></ul><br><p><b>Combine business and leisure</b></p><ul><li>Watch training videos at work and enjoy your favorite movies at home - it\'s all thanks to multimedia programs already loaded on your computer.</li><li>After a hard day, relax and listen to your favorite music directly from your desktop laptop, equipped with a sound system SRS Premium Sound.</li></ul></div></div></div></div></div></div><div></div></p></div><p class=\"skyblue-links hidden\"> <span onmouseover=\"_tipon(this)\" onmouseout=\"_tipoff()\"><span class=\"google-src-text\" style=\"direction: ltr; text-align: left\"><a href=\"http://translate.googleusercontent.com/translate_c?depth=1&amp;hl=ru&amp;rurl=translate.google.com.ua&amp;sl=ru&amp;tl=en&amp;twu=1&amp;u=http://rozetka.com.ua/hp_probook_4540s_b6n43ea/p230070/&amp;usg=ALkJrhgMYBHnZZr0P4BE3qLgR_ZIL5xHDg#\" id=\"full_description\" class=\"xhr\">Читать полностью</a></span> <a href=\"http://translate.googleusercontent.com/translate_c?depth=1&amp;hl=ru&amp;rurl=translate.google.com.ua&amp;sl=ru&amp;tl=en&amp;twu=1&amp;u=http://rozetka.com.ua/hp_probook_4540s_b6n43ea/p230070/&amp;usg=ALkJrhgMYBHnZZr0P4BE3qLgR_ZIL5xHDg#\" id=\"full_description\" class=\"xhr\">Read more</a></span> </p></div></div>'),(1,3,'<p><div><div><div><div><div><div><p>Realized in&nbsp;<b>U31SD</b>&nbsp;Super Hybrid Engine technology for complex tasks automatically increases performance up to 15%.&nbsp;But the potential of this technology is not limited to overclocking CPU: Super Hybrid Engine adjusts system parameters so as to optimize both the performance and power consumption of a laptop, and it works for this in conjunction with the latest processor Intel Core i3.</p><p>The technology provides a performance gain only when running programs, CPU-intensive, such as games and high-definition video, ensuring the stability of the entire system.</p><p>Modern businessman who spend long hours on the road, it is important to have on hand a functional laptop with the ability to work as long as possible between charges.</p><p>To increase battery life, performing simple tasks&nbsp;<b>U31SD</b>&nbsp;is put on energy savings.&nbsp;Technology Asus Super Hybrid Engine ensures the work laptop off-line to 10 hours, so you\'ll never need to worry about charging the device during travel.</p><p>In addition to high performance and good autonomy, laptop U31SD elegant and ergonomic design.&nbsp;The thickness of this compact notebook is less than one inch thick, so it fits easily in a backpack or small bag.</p><p>The combination of elegant design and technological innovation makes this a powerful ultraportable excellent purchase.</p></div></div></div></div></div><div></div></div></p>'),(1,1,'<p><div><div><div><div><div><div><p>Реалізована в&nbsp;<b>U31SD</b>&nbsp;технологія Super Hybrid Engine при виконанні складних завдань автоматично збільшує продуктивність системи аж до 15%.&nbsp;Але можливості цієї технології не обмежуються розгоном центрального процесора: Super Hybrid Engine налаштовує системні параметри таким чином, щоб оптимізувати як продуктивність, так і енергоспоживання ноутбука, і працює для цього у зв\'язці з новітнім процесором Intel Core i3.</p><p>Технологія забезпечує приріст продуктивності тільки при запуску програм, що інтенсивно використовують ресурси процесор, таких як ігри і відео високої чіткості, гарантуючи стабільність роботи всієї системи.</p><p>Сучасній діловій людині, багато часу проводить у роз\'їздах, дуже важливо мати під рукою функціональний ноутбук з можливістю якомога довше працювати без підзарядки.</p><p>Щоб збільшити час роботи від батареї, при виконанні простих завдань&nbsp;<b>U31SD</b>&nbsp;переводиться в режим економії споживання енергії.Технологія Asus Super Hybrid Engine гарантує роботу ноутбука в автономному режимі до 10 годин, тому користувачеві більше не потрібно турбуватися про підзарядку пристрою під час поїздки.</p><p>Крім високої продуктивності та хорошої автономності, ноутбук U31SD відрізняється елегантним і ергономічним дизайном.Товщина цього компактного ноутбука не перевищує одного дюйма, тому він без зусиль поміститься в рюкзаку або невеликій сумці.</p><p>Поєднання вишуканого дизайну і технічних інновацій робить цей потужний ультрапортативний ноутбук відмінною покупкою.</p></div></div></div></div></div><div></div></div></p>'),(2,1,'<p><div><div><div><div><div><div><p>Стильний ноутбук&nbsp;<b>HP ProBook 4540s</b>&nbsp;стане вашим незамінним помічником у роботі.&nbsp;Він оснащений матовим дисплеєм HD діагоналлю 39.6 см (15.6 \") з LED-підсвічуванням, клавіатурою і цифровою клавішною панеллю з захистом від попадання рідини і засобами бездротового зв\'язку. Це ідеальний вибір для професійних користувачів, котрі перебувають у роз\'їздах.</p><p><b>Захист зсередини і зовні</b></p><ul><li>Корпус з алюмінію забезпечує підвищену довговічність при використанні в дорозі.&nbsp;Стійке до забруднення і зносу покриття HP DuraFinish зберігає первісне ідеальний стан полірованого сірого металу.</li><li>Водостійка клавіатура захищає чутливу електроніку і ключові компоненти від потрапляння невеликої кількості рідини завдяки тонкій майларовой плівці під клавішами.</li><li>Бувають події, які не можна запобігти.&nbsp;HP 3D DriveGuard захистить жорсткий диск вашого ноутбука від ударів, поштовхів і падінь, що зміцнить захист ваших даних.</li><li>Прості, але надійні засоби безпеки захистять ваші дані від неправомірного доступу.</li></ul><br><p><b>Правильні інструменти для бізнесу - запорука вашого успіху</b></p><ul><li>Використовуйте дискретну графічну карту для створення блискучих зображень, і ваш комп\'ютер буде автоматично переходити в режим економії акумулятора при використанні типових додатків.&nbsp;Динамічна перемикається графічна карта AMD зробить це сама, не відволікаючи вас від справи.</li><li>Виділіть сильні сторони своїх презентацій.&nbsp;Відтворюйте, редагуйте та створюйте відео-та аудіофайли з пакетом ArcSoft TotalMedia Suite.</li></ul><br><p><b>Поєднуйте бізнес і дозвілля</b></p><ul><li>Дивіться навчальні відеоролики на роботі і насолоджуйтеся улюбленими фільмами будинку - все це завдяки програмам для мультимедіа, уже завантаженим на комп\'ютер.</li><li>Після важкого робочого дня розслабтеся і послухайте улюблену музику прямо зі свого робочого ноутбука, оснащеного звуковою системою SRS Premium Sound.</li></ul></div></div></div></div></div></div><div></div></p>'),(3,2,'<p>Новый планшет Amazin Kindle Fire HD оборудован 7-дюймовым сенсорным IPS-экраном с разрешением 1280х800 пикселей, поляризационным фильтром Advanced True Wide. Экран поддерживает технологию мультитач и распознает до 10 касаний одновременно, по сравнению с 2 касаниями у оригинального Kindle Fire.<br>\r\n<b>Цветной сенсорный экран.&nbsp;</b><br>\r\nФильмы, журналы и детские книги оживают на 7\" ярком дисплее, отображающем 16 млн.&nbsp;цветов в высоком разрешении. Amazon Kindle Fire HD использует IPS матрицу, подобную технологию используют на iPad, которая значительно расширяет углы обзора и позволяет использовать планшет совместно нескольким людям.&nbsp;<br>\r\n<b>Фильтр Advanced True Wide</b><br>\r\nДополнительной особенностью дисплея является наличие поляризационного фильтра Advanced True Wide, который предотвращает появление бликов на экране, и ламинированный датчик касания для более четкого и контрастного изображения.<br>\r\n<b>Красивый, простой и удобный&nbsp;</b><br>\r\nРазработанный с нуля, простой, интуитивный интерфейс Amazon Kindle Fire HD позволяет управлять вашим контентом простыми движениями пальцев.&nbsp;<br>\r\n<b>Быстрый двуядерный процессор&nbsp;</b><br>\r\nKindle Fire HD оснащен двуядерным процессором обеспечивающим отличную производительность. Вы сможете легко слушать потоковою музыку и одновременно работать в интернете или читать книги во время скачивания видео.<br>\r\n<b>Насыщеный, объемный звук</b><br>\r\nВ планшете установлено два стереодинамика с поддержкой Dolby Digital Plus. Эта технология автоматически подстраивает громкость, в зависимости от того, чем Вы в данный момент занмаетесь, например: смотрите кино, слушаете музыку через динамики или наушники, либо разговариваете по Skype.<br>\r\n</p>\r\n\r\n<p align=\"center\"><iframe width=\"640\" height=\"390\" src=\"http://www.youtube.com/embed/Lxzh-F-Yz2k\" frameborder=\"0\" allowfullscreen=\"\"></iframe><br>\r\n</p>'),(3,1,'<p><div><div><div><div><div><div><p>Новий планшет Amazin Kindle Fire HD обладнаний 7-дюймовим сенсорним IPS-екраном з роздільною здатністю 1280х800 пікселів, поляризаційним фільтром Advanced True Wide.&nbsp;Екран підтримує технологію мультитач і розпізнає до 10 торкань одночасно, в порівнянні з 2 торканнями в оригінального Kindle Fire.&nbsp;<br><b>Кольоровий сенсорний екран.</b>&nbsp;<br>Фільми, журнали та дитячі книги оживають на 7 \"яскравому дисплеї, що відображає 16 млн. квітів у високому дозволі. Amazon Kindle FireHD використовує IPS матрицю, подібну технологію використовують на iPad, яка значно розширює кути огляду і дозволяє використовувати планшет спільно кільком людям.&nbsp;<br><b>Фільтр Advanced True Wide</b>&nbsp;<br>Додатковою особливістю дисплея є наявність поляризаційного фільтра Advanced True Wide, який запобігає появі відблисків на екрані, і ламінований датчик дотику для більш чіткого і контрастного зображення.&nbsp;<br><b>Красивий, простий і зручний</b>&nbsp;<br>Розроблений з нуля, простий, інтуїтивний інтерфейс Amazon Kindle Fire HD дозволяє керувати вашим контентом простими рухами пальців.&nbsp;<br><b>Швидкий двоядерний процесор</b>&nbsp;<br>Kindle Fire HD оснащений двоядерним процесором забезпечує відмінну продуктивність.&nbsp;Ви зможете легко слухати потокової музики і одночасно працювати в інтернеті або читати книги під час скачування відео.&nbsp;<br><b>Насичений, об\'ємний звук</b>&nbsp;<br>У планшеті встановлено два стереодинаміки з підтримкою Dolby Digital Plus.&nbsp;Ця технологія автоматично підлаштовує гучність, залежно від того, чим Ви в даний момент занмаетесь, наприклад: дивіться кіно, слухаєте музику через динаміки або навушники, або розмовляєте по Skype.</p></div></div></div></div></div></div><div></div></p>'),(3,3,'<p><div><div><div><div><div><div><p>The new tablet Amazin Kindle Fire HD is equipped with 7-inch touch-IPS-display with a resolution of 1280x800 pixels, a polarizing filter Advanced True Wide.&nbsp;The screen supports multi-touch and recognize up to 10 simultaneous touches, compared with two touches in the original Kindle Fire.&nbsp;<br><b>Color touch screen.</b>&nbsp;<br>Movies, magazines and children\'s books come alive on 7 \"bright display that displays 16 million colors in high resolution. Amazon Kindle Fire HD IPS uses a matrix similar to the technology used in the iPad, which greatly enhances the viewing angle and allows you to use the tablet together several people.&nbsp;<br><b>Filter Advanced True Wide</b>&nbsp;<br>An additional feature of the display is the presence of a polarizing filter Advanced True Wide, which prevents glare, and laminate the touch sensor for a clear and sharp image.&nbsp;<br><b>A beautiful, simple and convenient</b>&nbsp;<br>Designed from the ground, a simple, intuitive interface of Amazon Kindle Fire HD allows you to manage your content with simple finger movements.&nbsp;<br><b>Fast dual-core processor</b>&nbsp;<br>Kindle Fire HD is equipped with a dual-core processor delivers excellent performance.&nbsp;You can easily stream music while working on the Internet or read books while downloading videos.&nbsp;<br><b>Saturated, surround sound</b>&nbsp;<br>In the tablet has two stereo speakers with support for Dolby Digital Plus.This technology automatically adjusts the volume, depending on what you are currently zanmaetes, such as watching movies, listening to music through speakers or headphones, or talking on Skype.</p></div></div></div></div></div></div><div><div><div><div></div></div></div></div></p>'),(4,2,'<p><p><b>Asus PadFone</b>&nbsp;— новое многофункциональное устройство от признанного мирового производителя.</p><ul><li>Одна SIM-карта на два мобильных устройства</li><li>Быстрое переключение с 4.3-дюймового экрана PadFone на 10.1-дюймовый экран PadFone Station</li><li>Увеличенное время автономной работы с PadFone Station или док-станцией</li></ul><br><p>Особенности&nbsp;<b>Asus PadFone</b>:</p><p><b>Быстрое переключение между двумя устройствами</b><br>Функция динамического переключения дисплея автоматически изменяет настройки приложений, чтобы обеспечить их оптимальное отображение на используемом в данный момент устройстве. Вам даже не придется заново запускать игру или другую программу при переходе с PadFone на PadFone Station и обратно!</p><p><b>Качественная цифровая камера</b><br>PadFone оснащен 8-мегапиксельной камерой с большой диафрагмой (F/2.2), которая позволяет получать четкие снимки и записывать видео в формате 1080p даже в условиях плохой освещенности.</p><p><b>Увеличенное время автономной работы</b><br>Встроенный в PadFone Station аккумулятор увеличивает время автономной работы PadFone в пять раз — до 63 часов, а если этого мало – пристыкуйте смартфон к док-станции, и времяавтономной работы увеличиться в девять раз — до 102 часов!</p><p><b>Одна SIM-карта на два устройства</b><br>Поскольку PadFone Station может использовать для подключения к интернету 3G-модуль смартфона PadFone, вам не придется покупать для него отдельную SIM-карту и оплачивать второй тарифный план.</p><p><b>Превосходный звук</b><br>Высококачественные компоненты и интеллектуальные алгоритмы обработки аудиосигнала наделяют PadFone отличным звучанием.</p><p><b>Современный дизайн</b><br>Философия «дзен-дизайна», впервые примененная специалистами Asus при разработке ультрабука Zenbook, получила свое продолжение в оригинальном облике PadFone и PadFone Station. Элегантность сочетается в этих устройствах с практичностью. Держать их в руках – одно удовольствие.</p><p><b>Высокая производительность</b><br>PadFone оснащается двухъядерным процессором Qualcomm Snapdragon S4 с частотой 1.5 ГГц и графическим процессором Adreno 225, которые обеспечивают высокую скорость в самых разных мобильных приложениях.</p><p><b>Удобные аксессуары</b><br>В дополнение к PadFone предлагаются удобные аксессуары. Одним из них является клавиатурная док-станция, превращающая PadFone в ультрапортативный ноутбук с дополнительным USB-портом, кард-ридером и аккумулятором. Также стоит отметить PadFone Stylus Headset – удобный стилус, совмещенный с Bluetooth-гарнитурой.</p><p><b>Экономьте время!</b><br>При использовании обычного смартфона и планшета вам постоянно приходится запускать процесс синхронизации, чтобы на обоих устройствах была актуальная информация. PadFone и PadFone Station лишены этой проблемы, ведь с ними все данные всегда хранятся в одном месте, а работать с ними можно либо на PadFone, либо на PadFone Station!</p><p><b>Множество предустановленных приложений</b><br>PadFone поставляется с множеством предустановленных приложений, включая эксклюзивные программы Asus для работы с мультимедийным контентом. Он также обеспечивает доступ к «облачному» хранилищу файлов объемом 8 гигабайт.<br></p><p style=\"text-align: center;\"><iframe width=\"640\" height=\"390\" src=\"http://www.youtube.com/embed/qLyGjWqmg3Q\" frameborder=\"0\" allowfullscreen=\"\"></iframe><br></p></p>'),(4,3,'<p><div><div><div><div><p><b>Asus PadFone</b>&nbsp;- new multifunctional device from world recognized manufacturers.</p><ul><li>A SIM-card on two mobile devices</li><li>Fast switching with 4.3-inch screen PadFone on a 10.1-inch screen PadFone Station</li><li>The increased battery life with PadFone Station or Docking Station</li></ul><br><p>Features&nbsp;<b>Asus PadFone:</b></p><p><b>Fast switching between the two devices</b>&nbsp;<br>Dynamic switching the display automatically changes the settings of applications to ensure their optimal display for the currently used device.You do not even have to re-run the game or other program in the transition from PadFone on PadFone Station and back!</p><p><b>High-quality digital camera</b>&nbsp;<br>PadFone equipped with an 8-megapixel camera with a large aperture (F/2.2), which allows for clearer pictures and record video in 1080p, even in low light conditions.</p><p><b>The increased battery life</b>&nbsp;<br>The built-in battery PadFone Station increased battery life PadFone five times - up to 63 hours, and if that\'s not enough - Put a smartphone to the docking station, and battery life increase by nine times - up to 102 hours!</p><p><b>A SIM-card for two devices</b>&nbsp;<br>Since PadFone Station can be used to connect to the Internet 3G-module smartphone PadFone, you do not have to buy it for a separate SIM-card and pay the second plan.</p><p><b>Superb Sound</b>&nbsp;<br>High-quality components and intelligent audio processing algorithms give PadFone excellent sound.</p><p><b>Modern design</b>&nbsp;<br>The philosophy of \"Zen design\", first used by specialists in the development of Asus ultrabook Zenbook, was continued in its original form and PadFone PadFone Station.&nbsp;Elegance is combined with the practicality of these devices.&nbsp;Hold them in their hands - a pleasure.</p><p><b>High performance</b>&nbsp;<br>PadFone is equipped with dual-core Qualcomm Snapdragon S4 with a frequency of 1.5 GHz and the GPU Adreno 225, which provide high speed in a variety of mobile applications.</p><p><b>Handy accessories</b>&nbsp;<br>In addition to the PadFone offers convenient accessories.&nbsp;One of them is a keyboard dock that turns PadFone in ultraportable with extra USB-port, card reader and battery.&nbsp;Also worth noting PadFone Stylus Headset - comfortable stylus combined with a Bluetooth-headset.</p><p><b>Save time!</b>&nbsp;<br>When using a regular smartphone and tablet you always have to start the synchronization process that both devices have been to date information.PadFone and PadFone Station deprived of this problem, because with all of the data is always stored in one place, and to work with them you can either PadFone, or the PadFone Station!</p><p><b>The set of pre-installed applications</b>&nbsp;<br>PadFone comes with many pre-installed applications, including exclusive programs Asus to work with multimedia content.&nbsp;It also provides access to the \"cloud\" file storage capacity of 8 GB.</p></div></div></div></div><div></div></p>'),(4,1,'<p><div><div><div><div><p><b>Asus PadFone</b>&nbsp;- новий багатофункціональний пристрій від визнаного світового виробника.</p><ul><li>Одна SIM-карта на два мобільні пристрої</li><li>Швидке переключення з 4.3-дюймового екрану PadFone на 10.1-дюймовий екран PadFone Station</li><li>Збільшений час автономної роботи з PadFone Station або док-станцією</li></ul><br><p>Особливості&nbsp;<b>Asus PadFone:</b></p><p><b>Швидке перемикання між двома пристроями</b>&nbsp;<br>Функція динамічного перемикання дисплея автоматично змінює налаштування додатків, щоб забезпечити їх оптимальне відображення на використовуваному в даний момент пристрої.&nbsp;Вам навіть не доведеться заново запускати гру або іншу програму при переході з PadFone на PadFone Station і назад!</p><p><b>Якісна цифрова камера</b>&nbsp;<br>PadFone оснащений 8-мегапіксельною камерою з великою діафрагмою (F/2.2), яка дозволяє отримувати чіткі знімки і записувати відео у форматі 1080p навіть в умовах поганої освітленості.</p><p><b>Збільшений час автономної роботи</b>&nbsp;<br>Вбудований в PadFone Station акумулятор збільшує час автономної роботи PadFone в п\'ять разів - до 63 годин, а якщо цього мало - пристикують смартфон до док-станції, і час автономної роботи збільшитися в дев\'ять разів - до 102 годин!</p><p><b>Одна SIM-карта на два пристрої</b>&nbsp;<br>Оскільки PadFone Station може використовувати для підключення до інтернету 3G-модуль смартфона PadFone, вам не доведеться купувати для нього окрему SIM-карту і оплачують другу тарифний план.</p><p><b>Чудовий звук</b>&nbsp;<br>Високоякісні компоненти та інтелектуальні алгоритми обробки аудіосигналу наділяють PadFone відмінним звучанням.</p><p><b>Сучасний дизайн</b>&nbsp;<br>Філософія «дзен-дизайну», вперше застосована фахівцями Asus при розробці ультрабука Zenbook, отримала своє продовження в оригінальному вигляді PadFone і PadFone Station.&nbsp;Елегантність поєднується в цих пристроях з практичністю.&nbsp;Тримати їх в руках - одне задоволення.</p><p><b>Висока продуктивність</b>&nbsp;<br>PadFone оснащується двоядерним процесором Qualcomm Snapdragon S4 з частотою 1.5 ГГц і графічним процесором Adreno 225, які забезпечують високу швидкість в самих різних мобільних додатках.</p><p><b>Зручні аксесуари</b>&nbsp;<br>На додаток до PadFone пропонуються зручні аксесуари.&nbsp;Одним з них є клавіатурна док-станція, що перетворює PadFone в ультрапортативний ноутбук з додатковим USB-портом, кард-рідером і акумулятором.&nbsp;Також варто відзначити PadFone Stylus Headset - зручний стилус, суміщений з Bluetooth-гарнітурою.</p><p><b>Економте час!</b>&nbsp;<br>При використанні звичайного смартфона і планшета вам постійно доводиться запускати процес синхронізації, щоб на обох пристроях була актуальна інформація.&nbsp;PadFone і PadFone Station позбавлені цієї проблеми, адже з ними всі дані завжди зберігаються в одному місці, а працювати з ними можна або на PadFone, або на PadFone Station!</p><p><b>Безліч передвстановлених додатків</b>&nbsp;<br>PadFone поставляється з безліччю встановлених додатків, включаючи ексклюзивні програми Asus для роботи з мультимедійним контентом.&nbsp;Він також забезпечує доступ до «хмарному» сховища файлів об\'ємом 8 гігабайт.</p></div></div></div></div><div></div></p>'),(5,2,'<p><p><b>Мультимедиа</b><br><b>Galaxy Tab 2 10.1</b>&nbsp;переполнен развлекательными приложениями для всей семьи. Наполненный богатым выбором мультимедийного контента, который подходит для любого возраста, Samsung Hubs (Reader, Music, Game and Video Hub) легко запускаются с рабочего стола.&nbsp;<br>S Suggest и Play Market также всегда доступны с помощью виджетов, которые более чем удовлетворят запросы на новые приложения и игры.&nbsp;<br>AllShare Play — лучшее приложение для обмена контентом между устройствами для всех Ваших DLNA подключенных устройств, включая телефон, ПК и ноутбук. Также, подключайтесь к телевизору для удобного просмотра, включая дистанционно контролируемые воспроизведение и звук, просмотр многочисленных TВ шоу на Twin View, или используйте дублирование с помощью Clone View, чтобы продолжать просмотр, пока Вы свободно передвигаетесь по дому. Загружайте медиа на облачные хранилища, чтобы сохранить их для последующего просмотра.</p><p><b>*&nbsp;</b>Video hub and AllShare Play будут доступны в апреле<br><b>*&nbsp;</b>Video hub будет доступен для ограниченного количества стран</p><p><b>Увлекательное и простое общение</b><br>Всегда удобно иметь в доме еще одну линию связи и Ваш&nbsp;<b>Galaxy Tab 2 10.1</b>. Ваши близкие живут далеко, и собрать всех на семейную встречу тяжело? Google+ Hangouts устроит групповую видео конференцию прямо в Вашей гостиной. Бесплатный и уникальный сервис ChatON улучшает коммуникацию, объединяя в себе мультимедийный обмен сообщениями, простой обмен контентом, комнаты для группового чата, и даже Ваши собственные микро сообщества друзей -- все это отлично подходит для совместного общения с друзьями и родственниками, которые находятся далеко.</p><p><b>Самая новая платформа Android 4.0</b><br>Всем нравится Ice Cream Sandwich — наиновейшая операционная система от Android, которая \"подсластит\" Ваш&nbsp;<b>Galaxy Tab 2 10.1</b>современным, интуитивно разработанным интерфейсом пользователя, в котором переход между всеми приложениями, которые используются Вашей семьей, осуществляется без каких-либо проблем. Инновационные характеристики, удобные для пользователя, включают улучшенные приложения Gallery, проверку орфографии и переход между экранами. Более доступный и простой запуск преустановленных приложений Google Mobile, включая YouTube, Google Search, Maps и другие необходимые сервисы от Google, которые выступают источниками информации для всей семьи.</p><p><b>Высокая производительность</b><br>Никто не любит ожидание. Мощный двухядерный процессор с частотой 1 ГГц поддерживает точное соответствие доставки именно того мультимедиа контента, на который был дан запрос определенным пользователем, включая более быстрые загрузки, безупречное воспроизведение и просмотр интернета.&nbsp;<b>Galaxy Tab 2 10.1</b>&nbsp;соединяет превосходную тонкость с легкостью, но имеет прочную конструкцию, которая достаточно устойчива и крепка для повседневного использования. Постоянно растущий запас цифрового контента Вашей семьи можно сохранять при помощи разъема для карты microSD, емкостью до 32 ГБ. Возьмите свой<b>Galaxy Tab 2 10.1&nbsp;</b>и начните развлекаться.<br></p><p style=\"text-align: center;\"><iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/ii99vE9-Sj8?feature=player_detailpage\" frameborder=\"0\" allowfullscreen=\"\"></iframe><br></p></p>'),(5,1,'<p><div><div><div><div><p><b>Мультимедіа</b>&nbsp;<br><b>Galaxy Tab 2 10.1</b>&nbsp;переповнений розважальними додатками для всієї родини.&nbsp;Наповнений багатим вибором мультимедійного контенту, який підходить для будь-якого віку, Samsung Hubs (Reader, Music, Game and Video Hub) легко запускаються з робочого столу.&nbsp;<br>S Suggest і Play Market також завжди доступні за допомогою віджетів, які більш ніж задовольнять запити на нові програми та ігри.&nbsp;<br>AllShare Play - краще додаток для обміну контентом між пристроями для всіх Ваших DLNA підключених пристроїв, включаючи телефон, ПК та ноутбук.&nbsp;Також, підключайтесь до телевізора для зручного перегляду, включаючи дистанційно контрольовані відтворення і звук, перегляд численних ТБ шоу на Twin View, або використовуйте дублювання за допомогою Clone View, щоб продовжувати перегляд, поки Ви вільно пересуваєтеся по будинку.&nbsp;Завантажуйте медіа на хмарні сховища, щоб зберегти їх для подальшого перегляду.</p><p><b>*</b>&nbsp;Video hub and AllShare Play будуть доступні в квітні&nbsp;<br><b>*</b>&nbsp;Video hub буде доступний для обмеженої кількості країн</p><p><b>Захоплююче і просте спілкування</b>&nbsp;<br>Завжди зручно мати в будинку ще одну лінію зв\'язку і Ваш&nbsp;<b>Galaxy Tab 2 10.1.</b>&nbsp;Ваші близькі живуть далеко, і зібрати всіх на сімейну зустріч важко?&nbsp;Google+ Hangouts влаштує групову відео конференцію прямо у Вашій вітальні.&nbsp;Безкоштовний і унікальний сервіс ChatON покращує комунікацію, об\'єднуючи в собі мультимедійний обмін повідомленнями, простий обмін контентом, кімнати для групового чату, і навіть Ваші власні мікро спільноти друзів - все це відмінно підходить для спільного спілкування з друзями і родичами, які перебувають далеко.</p><p><b>Сама нова платформа Android 4.0</b>&nbsp;<br>Всім подобається Ice Cream Sandwich - найновітнішу операційна система від Android, яка \"підсолодить\" Ваш&nbsp;<b>Galaxy Tab 2 10.1</b>сучасним, інтуїтивно розробленим інтерфейсом користувача, в якому перехід між всіма додатками, які використовуються Вашою родиною, здійснюється без будь-яких проблем.&nbsp;Інноваційні характеристики, зручні для користувача, включають покращені додатка Gallery, перевірку орфографії та перехід між екранами.Більш доступний і простий запуск преустановленних додатків Google Mobile, включаючи YouTube, Google Search, Maps та інші необхідні сервіси від Google, які виступають джерелами інформації для всієї родини.</p><p><b>Висока продуктивність</b>&nbsp;<br>Ніхто не любить очікування.&nbsp;Потужний двоядерний процесор з частотою 1 ГГц підтримує точну відповідність доставки саме того мультимедіа контенту, на який був даний запит певним користувачем, включаючи більш швидкі завантаження, бездоганне відтворення та перегляд інтернету.&nbsp;<b>Galaxy Tab 2 10.1</b>&nbsp;з\'єднує чудову тонкість з легкістю, але має міцну конструкцію, яка досить стійка і міцна для повсякденного використання.&nbsp;Постійно зростаючий запас цифрового контента Вашої родини можна зберігати за допомогою роз\'єму для карти microSD, ємністю до 32 ГБ.&nbsp;Візьміть свій&nbsp;<b>Galaxy Tab 2 10.1</b>&nbsp;і почніть розважатися.</p></div></div></div></div><div></div></p>'),(5,3,'<p><div><div><div><div><p><b>Multimedia</b>&nbsp;<br><b>Galaxy Tab 2 10.1</b>&nbsp;crowded entertainment applications for the whole family.&nbsp;Filled with a rich selection of multimedia content that is appropriate for all age groups, Samsung Hubs (Reader, Music, Game and Video Hub) easily run from your desktop.&nbsp;<br>S Suggest Play Market and also always available with widgets that will more than satisfy the needs of new applications and games.&nbsp;<br>AllShare Play - best application for sharing content between devices for all your DLNA connected devices, including phones, PCs and laptops.Also, connect to a TV for easy viewing, including remotely controlled playback and sound, watching the many TV shows on Twin View, duplication or use by Clone View, to continue scanning until you move freely around the house.&nbsp;Load media in the cloud storage to save them for later viewing.</p><p><b>*</b>&nbsp;Video hub and AllShare Play will be available in April&nbsp;<br><b>*</b>&nbsp;Video hub will be available for a limited number of countries</p><p><b>Fascinating and simple communication</b>&nbsp;<br>Always handy to have in the house one more link and your&nbsp;<b>Galaxy Tab 2 10.1.</b>&nbsp;Your loved ones live far away and collect all a family reunion hard?Google+ Hangouts will arrange a group video conference right in your living room.&nbsp;Free and unique service ChatON improves the communication, combining multimedia messaging, easy content sharing, group chat rooms, and even your own micro community of friends - all great for sharing communication with friends and relatives who are far away.</p><p><b>The latest Android 4.0 platform</b>&nbsp;<br>Everyone likes Ice Cream Sandwich - nainoveyshaya operating system from Android, which is \"sweeten\" your&nbsp;<b>Galaxy Tab 2 10.1-date,</b>&nbsp;user-designed user interface, in which the transition between all the applications that are used by your family, is carried out without any problems.&nbsp;Innovative features, user-friendly, include improved application Gallery, spell checking and switching between screens.&nbsp;More accessible and easy starts preustanovlennyh applications Google Mobile, including YouTube, Google Search, Maps, and other necessary services from Google, which is the source of information for the whole family.</p><p><b>High performance</b>&nbsp;<br>Nobody likes to wait.&nbsp;The powerful dual-core processor with 1 GHz supports exact match is to deliver multimedia content, which was given to a request by a specific user, including faster downloads, flawless playback and Internet browsing.&nbsp;<b>Galaxy Tab 2 10.1</b>&nbsp;combines subtlety with perfect ease, but is robust, which is quite stable and strong for everyday use.&nbsp;Growing supply of digital content of your family, you can save with slots for cards microSD, up to 32GB.&nbsp;Take your&nbsp;<b>Galaxy Tab 10.1</b>&nbsp;and the&nbsp;<b>two</b>&nbsp;start to have fun.</p><p style=\"text-align: center;\"><iframe width=\"640\" height=\"360\" src=\"http://www.youtube.com/embed/Utxv2IrC2pg?feature=player_detailpage\" frameborder=\"0\" allowfullscreen=\"\"></iframe><br></p></div></div></div></div></p>');
/*!40000 ALTER TABLE `ProductTranslation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-03 14:45:22
