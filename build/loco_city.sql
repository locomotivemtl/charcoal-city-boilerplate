# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.6.33)
# Base de données: loco_city_news
# Temps de génération: 2017-04-03 18:09:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table charcoal_admin_acl_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `charcoal_admin_acl_roles`;

CREATE TABLE `charcoal_admin_acl_roles` (
  `ident` varchar(255) NOT NULL DEFAULT '',
  `parent` varchar(255) DEFAULT NULL,
  `allowed` text,
  `denied` text,
  `superuser` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  PRIMARY KEY (`ident`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `charcoal_admin_acl_roles` WRITE;
/*!40000 ALTER TABLE `charcoal_admin_acl_roles` DISABLE KEYS */;

INSERT INTO `charcoal_admin_acl_roles` (`ident`, `parent`, `allowed`, `denied`, `superuser`, `position`)
VALUES
	('admin',NULL,NULL,NULL,1,NULL);

/*!40000 ALTER TABLE `charcoal_admin_acl_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table charcoal_admin_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `charcoal_admin_users`;

CREATE TABLE `charcoal_admin_users` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` text,
  `last_login_date` datetime DEFAULT NULL,
  `last_login_ip` varchar(15) DEFAULT NULL,
  `last_password_date` datetime DEFAULT NULL,
  `last_password_ip` varchar(15) DEFAULT NULL,
  `login_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table charcoal_attachment_joins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `charcoal_attachment_joins`;

CREATE TABLE `charcoal_attachment_joins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `object_type` varchar(255) DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `attachment_id` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `position` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table charcoal_attachments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `charcoal_attachments`;

CREATE TABLE `charcoal_attachments` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `required_acl_permissions` text,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` char(13) NOT NULL DEFAULT '',
  `title_fr` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `show_title` tinyint(1) unsigned DEFAULT NULL,
  `categories` text,
  `subtitle_fr` varchar(255) DEFAULT NULL,
  `subtitle_en` varchar(255) DEFAULT NULL,
  `description_fr` text,
  `description_en` text,
  `keywords_fr` text,
  `keywords_en` text,
  `type` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `embed` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table charcoal_cms_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `charcoal_cms_tags`;

CREATE TABLE `charcoal_cms_tags` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `color` char(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_contacts`;

CREATE TABLE `city_contacts` (
  `ip` varchar(15) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `ts` datetime DEFAULT NULL,
  `origin` text,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `citizen_number` varchar(255) DEFAULT NULL,
  `message` text,
  `contact-category` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_contacts_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_contacts_categories`;

CREATE TABLE `city_contacts_categories` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `default_to` text,
  `default_cc` text,
  `default_from_name` varchar(255) DEFAULT NULL,
  `default_from_email` varchar(255) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_districts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_districts`;

CREATE TABLE `city_districts` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `description_en` text,
  `description_fr` text,
  `geometry` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_events_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_events_categories`;

CREATE TABLE `city_events_categories` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `city_events_categories` WRITE;
/*!40000 ALTER TABLE `city_events_categories` DISABLE KEYS */;

INSERT INTO `city_events_categories` (`active`, `position`, `created`, `created_by`, `last_modified`, `last_modified_by`, `id`, `name_en`, `name_fr`)
VALUES
	(1,'0','2016-11-02 14:19:54','jalphonso','2016-11-02 14:19:54','jalphonso',1,'Category 1','Catégorie 1'),
	(1,'0','2016-11-02 14:20:08','jalphonso','2016-11-02 14:20:08','jalphonso',2,'Category 2','Catégorie 2'),
	(1,'0','2016-11-02 14:20:21','jalphonso','2016-11-02 14:20:21','jalphonso',3,'Category 3','Catégorie 3');

/*!40000 ALTER TABLE `city_events_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table city_locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_locations`;

CREATE TABLE `city_locations` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `categories` text,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `description_en` text,
  `description_fr` text,
  `address_en` varchar(255) DEFAULT NULL,
  `address_fr` varchar(255) DEFAULT NULL,
  `address2_en` varchar(255) DEFAULT NULL,
  `address2_fr` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `accessible` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_locations_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_locations_categories`;

CREATE TABLE `city_locations_categories` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `ident` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_news_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_news_categories`;

CREATE TABLE `city_news_categories` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `city_news_categories` WRITE;
/*!40000 ALTER TABLE `city_news_categories` DISABLE KEYS */;

INSERT INTO `city_news_categories` (`active`, `position`, `created`, `created_by`, `last_modified`, `last_modified_by`, `id`, `name_en`, `name_fr`)
VALUES
	(1,'0','2016-11-02 14:18:47','jalphonso','2016-11-02 14:18:47','jalphonso',1,'Category 1','Catégorie 1'),
	(1,'0','2016-11-02 14:19:09','jalphonso','2016-11-02 14:19:09','jalphonso',2,'Category 2','Catégory 2'),
	(1,'0','2016-11-02 14:19:30','jalphonso','2016-11-02 14:19:30','jalphonso',3,'Category 3','Catégorie 3');

/*!40000 ALTER TABLE `city_news_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table city_newsletter_subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_newsletter_subscriptions`;

CREATE TABLE `city_newsletter_subscriptions` (
  `ip` varchar(15) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `ts` datetime DEFAULT NULL,
  `origin` text,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_team_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_team_categories`;

CREATE TABLE `city_team_categories` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_team_members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_team_members`;

CREATE TABLE `city_team_members` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `category` int(10) unsigned DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `district` int(10) unsigned DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `description_en` text,
  `description_fr` text,
  `thumbnail` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_templates`;

CREATE TABLE `city_templates` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` varchar(255) NOT NULL DEFAULT '',
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_users`;

CREATE TABLE `city_users` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `required_acl_permissions` text,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_fr` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `link_fr` varchar(255) DEFAULT NULL,
  `link_en` varchar(255) DEFAULT NULL,
  `role` text,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table cms_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cms_config`;

CREATE TABLE `cms_config` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `required_acl_permissions` text,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `social_medias` longtext,
  `default_from_email` varchar(255) DEFAULT NULL,
  `default_meta_title_fr` varchar(255) DEFAULT NULL,
  `default_meta_title_en` varchar(255) DEFAULT NULL,
  `default_meta_description_fr` varchar(255) DEFAULT NULL,
  `default_meta_description_en` varchar(255) DEFAULT NULL,
  `default_meta_image` varchar(255) DEFAULT NULL,
  `default_meta_url_fr` varchar(255) DEFAULT NULL,
  `default_meta_url_en` varchar(255) DEFAULT NULL,
  `city_fr` varchar(255) DEFAULT NULL,
  `city_en` varchar(255) DEFAULT NULL,
  `state_fr` varchar(255) DEFAULT NULL,
  `state_en` varchar(255) DEFAULT NULL,
  `country_fr` varchar(255) DEFAULT NULL,
  `country_en` varchar(255) DEFAULT NULL,
  `home_news` text,
  `home_events` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table cms_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cms_events`;

CREATE TABLE `cms_events` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `category` int(10) unsigned DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `subtitle_en` text,
  `subtitle_fr` text,
  `summary_en` text,
  `summary_fr` text,
  `content_en` text,
  `content_fr` text,
  `image_en` varchar(255) DEFAULT NULL,
  `image_fr` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `info_url_en` varchar(255) DEFAULT NULL,
  `info_url_fr` varchar(255) DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_title_fr` varchar(255) DEFAULT NULL,
  `meta_description_en` text,
  `meta_description_fr` text,
  `meta_image_en` varchar(255) DEFAULT NULL,
  `meta_image_fr` varchar(255) DEFAULT NULL,
  `meta_author_en` varchar(255) DEFAULT NULL,
  `meta_author_fr` varchar(255) DEFAULT NULL,
  `publish_date` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `publish_status` varchar(255) DEFAULT NULL,
  `slug_en` varchar(255) DEFAULT NULL,
  `slug_fr` varchar(255) DEFAULT NULL,
  `template_options` longtext,
  `template_ident` varchar(255) DEFAULT NULL,
  `hours_en` varchar(255) DEFAULT NULL,
  `hours_fr` varchar(255) DEFAULT NULL,
  `location_name_en` varchar(255) DEFAULT NULL,
  `location_name_fr` varchar(255) DEFAULT NULL,
  `address_en` varchar(255) DEFAULT NULL,
  `address_fr` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `city_en` varchar(255) DEFAULT NULL,
  `city_fr` varchar(255) DEFAULT NULL,
  `state_en` varchar(255) DEFAULT NULL,
  `state_fr` varchar(255) DEFAULT NULL,
  `country_en` varchar(255) DEFAULT NULL,
  `country_fr` varchar(255) DEFAULT NULL,
  `external_url_en` varchar(255) DEFAULT NULL,
  `external_url_fr` varchar(255) DEFAULT NULL,
  `keywords` text,
  `author` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cms_events` WRITE;
/*!40000 ALTER TABLE `cms_events` DISABLE KEYS */;

INSERT INTO `cms_events` (`active`, `position`, `created`, `created_by`, `last_modified`, `last_modified_by`, `category`, `id`, `title_en`, `title_fr`, `subtitle_en`, `subtitle_fr`, `summary_en`, `summary_fr`, `content_en`, `content_fr`, `image_en`, `image_fr`, `start_date`, `end_date`, `info_url_en`, `info_url_fr`, `meta_title_en`, `meta_title_fr`, `meta_description_en`, `meta_description_fr`, `meta_image_en`, `meta_image_fr`, `meta_author_en`, `meta_author_fr`, `publish_date`, `expiry_date`, `publish_status`, `slug_en`, `slug_fr`, `template_options`, `template_ident`, `hours_en`, `hours_fr`, `location_name_en`, `location_name_fr`, `address_en`, `address_fr`, `postal_code`, `city_en`, `city_fr`, `state_en`, `state_fr`, `country_en`, `country_fr`, `external_url_en`, `external_url_fr`, `keywords`, `author`)
VALUES
	(1,0,'2016-11-02 14:22:55','jalphonso','2016-11-02 14:22:55','jalphonso',1,1,'Event 1','Événement 1',NULL,NULL,'This is the event 1','Ceci est l\'événement 1',NULL,NULL,NULL,NULL,'2016-11-02 14:22:55','2016-11-02 14:22:55',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-02 14:22:55',NULL,'published','/en/events/event-1','/fr/evenements/evenement-1','[]','event-entry',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,'','','','',NULL,NULL,'',0),
	(1,0,'2016-11-02 14:23:12','jalphonso','2016-11-02 14:23:12','jalphonso',2,2,'Event 2','Événement 2',NULL,NULL,'This is the event 2','Ceci est l\'événement 2',NULL,NULL,NULL,NULL,'2016-11-02 14:22:55','2016-11-02 14:22:55',NULL,NULL,'Event 1','Événement 1',NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-02 14:22:55',NULL,'published','/en/events/event-2','/fr/evenements/evenement-2','[]','event-entry',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,'','','','',NULL,NULL,'',0),
	(1,0,'2016-11-02 14:23:30','jalphonso','2016-11-02 14:23:30','jalphonso',3,3,'Event 3','Événement 3',NULL,NULL,'This is the event 3','Ceci est l\'événement 3',NULL,NULL,NULL,NULL,'2016-11-02 14:22:55','2016-11-02 14:22:55',NULL,NULL,'Event 1','Événement 1',NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-02 14:22:55',NULL,'published','/en/events/event-3','/fr/evenements/evenement-3','[]','event-entry',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,'','','','',NULL,NULL,'',0);

/*!40000 ALTER TABLE `cms_events` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table cms_news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cms_news`;

CREATE TABLE `cms_news` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `category` int(10) unsigned DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_title_fr` varchar(255) DEFAULT NULL,
  `meta_description_en` text,
  `meta_description_fr` text,
  `meta_image_en` varchar(255) DEFAULT NULL,
  `meta_image_fr` varchar(255) DEFAULT NULL,
  `meta_author_en` varchar(255) DEFAULT NULL,
  `meta_author_fr` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `subtitle_en` text,
  `subtitle_fr` text,
  `summary_en` text,
  `summary_fr` text,
  `content_en` text,
  `content_fr` text,
  `image_en` varchar(255) DEFAULT NULL,
  `image_fr` varchar(255) DEFAULT NULL,
  `news_date` datetime DEFAULT NULL,
  `info_url_en` varchar(255) DEFAULT NULL,
  `info_url_fr` varchar(255) DEFAULT NULL,
  `publish_date` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `publish_status` varchar(255) DEFAULT NULL,
  `slug_en` varchar(255) DEFAULT NULL,
  `slug_fr` varchar(255) DEFAULT NULL,
  `template_options` longtext,
  `template_ident` varchar(255) DEFAULT NULL,
  `alert` tinyint(1) unsigned DEFAULT NULL,
  `keywords` text,
  `author` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cms_news` WRITE;
/*!40000 ALTER TABLE `cms_news` DISABLE KEYS */;

INSERT INTO `cms_news` (`active`, `position`, `created`, `created_by`, `last_modified`, `last_modified_by`, `category`, `meta_title_en`, `meta_title_fr`, `meta_description_en`, `meta_description_fr`, `meta_image_en`, `meta_image_fr`, `meta_author_en`, `meta_author_fr`, `id`, `title_en`, `title_fr`, `subtitle_en`, `subtitle_fr`, `summary_en`, `summary_fr`, `content_en`, `content_fr`, `image_en`, `image_fr`, `news_date`, `info_url_en`, `info_url_fr`, `publish_date`, `expiry_date`, `publish_status`, `slug_en`, `slug_fr`, `template_options`, `template_ident`, `alert`, `keywords`, `author`)
VALUES
	(1,0,'2016-11-02 14:20:59','jalphonso','2016-11-02 14:21:14','jalphonso',1,NULL,'Nouvelle 1',NULL,NULL,NULL,NULL,NULL,NULL,1,'News 1','Nouvelle 1',NULL,NULL,'This is the news 1','Ceci est la nouvelle 1',NULL,NULL,NULL,NULL,'2016-11-02 14:20:59',NULL,NULL,'2016-11-02 14:20:59','2017-01-02 14:20:59','published','/en/news/news-1','/fr/actualites/nouvelle-1','[]','news-entry',0,'',0),
	(1,0,'2016-11-02 14:21:45','jalphonso','2016-11-02 14:21:45','jalphonso',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,'News 2','Nouvelle 2',NULL,NULL,'This is the news 2','Ceci est la nouvelle 2',NULL,NULL,NULL,NULL,'2016-11-02 14:21:45',NULL,NULL,'2016-11-02 14:21:45','2017-01-02 14:21:45','published','/en/news/news-2','/fr/actualites/nouvelle-2','[]','news-entry',0,'',0),
	(1,0,'2016-11-02 14:22:14','jalphonso','2016-11-02 14:22:14','jalphonso',3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,'News 3','Nouvelle 3',NULL,NULL,'This is the news 3','Ceci est la nouvelle 3',NULL,NULL,NULL,NULL,'2016-11-02 14:22:14',NULL,NULL,'2016-11-02 14:22:14','2017-01-02 14:22:14','published','/en/news/news-3','/fr/actualites/nouvelle-3','[]','news-entry',0,'',0);

/*!40000 ALTER TABLE `cms_news` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table cms_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cms_sections`;

CREATE TABLE `cms_sections` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `required_acl_permissions` text,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `template_options` longtext,
  `template_ident` varchar(255) NOT NULL,
  `controller_ident` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locked` tinyint(1) unsigned DEFAULT NULL,
  `section_type` varchar(255) NOT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `subtitle_fr` text,
  `subtitle_en` text,
  `summary_fr` text,
  `summary_en` text,
  `content_fr` text,
  `content_en` text,
  `image_fr` varchar(255) DEFAULT NULL,
  `image_en` varchar(255) DEFAULT NULL,
  `master` int(10) unsigned DEFAULT NULL,
  `external_url_fr` varchar(255) DEFAULT NULL,
  `external_url_en` varchar(255) DEFAULT NULL,
  `in_menu` tinyint(1) unsigned DEFAULT NULL,
  `meta_title_fr` varchar(255) DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_description_fr` text,
  `meta_description_en` text,
  `meta_image_fr` varchar(255) DEFAULT NULL,
  `meta_image_en` varchar(255) DEFAULT NULL,
  `keywords` text,
  `slug_fr` varchar(255) DEFAULT NULL,
  `slug_en` varchar(255) DEFAULT NULL,
  `meta_author_fr` varchar(255) DEFAULT NULL,
  `meta_author_en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cms_sections` WRITE;
/*!40000 ALTER TABLE `cms_sections` DISABLE KEYS */;

INSERT INTO `cms_sections` (`active`, `required_acl_permissions`, `position`, `created`, `created_by`, `last_modified`, `last_modified_by`, `template_options`, `template_ident`, `controller_ident`, `id`, `locked`, `section_type`, `title_fr`, `title_en`, `subtitle_fr`, `subtitle_en`, `summary_fr`, `summary_en`, `content_fr`, `content_en`, `image_fr`, `image_en`, `master`, `external_url_fr`, `external_url_en`, `in_menu`, `meta_title_fr`, `meta_title_en`, `meta_description_fr`, `meta_description_en`, `meta_image_fr`, `meta_image_en`, `keywords`, `slug_fr`, `slug_en`, `meta_author_fr`, `meta_author_en`)
VALUES
	(1,NULL,0,'2017-03-28 15:43:21','jalphonso','2017-03-28 15:44:46','jalphonso','[]','home',NULL,1,NULL,'charcoal/cms/section/content-section','accueil','home',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'','/fr/accueil','/en/home',NULL,NULL),
	(1,NULL,0,'2016-11-01 14:59:23','jalphonso','2017-03-28 12:00:35','jalphonso','[]','generic',NULL,2,NULL,'charcoal/cms/section/content','Page exemple','Exemple page',NULL,NULL,'Ceci est un exemple de page générique','This is an exemple of a generic page.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'Page exemple','Page exemple',NULL,NULL,NULL,NULL,'','/fr/page-exemple','/en/exemple-page',NULL,NULL),
	(1,NULL,0,'2016-11-01 15:04:03','jalphonso','2016-11-01 15:05:40','jalphonso','[]','news-list',NULL,3,NULL,'charcoal/cms/section/content','Actualité','News',NULL,NULL,'Ceci est la liste des actualités','This is the news list',NULL,NULL,NULL,NULL,NULL,'','',0,'Actualité','News',NULL,NULL,NULL,NULL,'','/fr/actualite','/en/news',NULL,NULL),
	(1,NULL,0,'2016-11-01 15:08:28','jalphonso','2016-11-01 15:08:28','jalphonso','[]','event-list',NULL,4,NULL,'charcoal/cms/section/content','Événements','Events',NULL,NULL,'Ceci est la liste des événements','This the event\'s list.',NULL,NULL,NULL,NULL,NULL,'','',0,NULL,NULL,NULL,NULL,NULL,NULL,'','/fr/evenements','/en/events',NULL,NULL);

/*!40000 ALTER TABLE `cms_sections` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table object_revisions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `object_revisions`;

CREATE TABLE `object_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `target_type` varchar(255) DEFAULT NULL,
  `target_id` varchar(255) DEFAULT NULL,
  `rev_num` double DEFAULT NULL,
  `rev_ts` datetime DEFAULT NULL,
  `rev_user` varchar(255) DEFAULT NULL,
  `data_prev` longtext,
  `data_obj` longtext,
  `data_diff` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `object_revisions` WRITE;
/*!40000 ALTER TABLE `object_revisions` DISABLE KEYS */;

INSERT INTO `object_revisions` (`id`, `target_type`, `target_id`, `rev_num`, `rev_ts`, `rev_user`, `data_prev`, `data_obj`, `data_diff`)
VALUES
	(1,'charcoal/admin/user','jalphonso',1,'2016-11-01 14:57:50',NULL,'[]','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:57:42-04:00\",\"created_by\":null,\"last_modified\":\"2016-11-01T14:57:42-04:00\",\"last_modified_by\":null,\"username\":\"jalphonso\",\"email\":\"joel@locomotive.ca\",\"roles\":[\"admin\"],\"password\":\"$2y$10$sieTOT6Ny2mFw8gJKvxiwuHFukLPYkhSvpIizLanRp49ckpjsmc7.\",\"last_login_date\":\"2016-11-01T14:57:50-04:00\",\"last_login_ip\":\"127.0.0.1\",\"last_password_date\":\"2016-11-01T14:57:42-04:00\",\"last_password_ip\":\"0.0.0.0\",\"login_token\":null}','{\"1\":{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:57:42-04:00\",\"created_by\":null,\"last_modified\":\"2016-11-01T14:57:42-04:00\",\"last_modified_by\":null,\"username\":\"jalphonso\",\"email\":\"joel@locomotive.ca\",\"roles\":[\"admin\"],\"password\":\"$2y$10$sieTOT6Ny2mFw8gJKvxiwuHFukLPYkhSvpIizLanRp49ckpjsmc7.\",\"last_login_date\":\"2016-11-01T14:57:50-04:00\",\"last_login_ip\":\"127.0.0.1\",\"last_password_date\":\"2016-11-01T14:57:42-04:00\",\"last_password_ip\":\"0.0.0.0\",\"login_token\":null}}'),
	(2,'boilerplate/object/section','1',1,'2016-11-01 15:03:02','jalphonso','[]','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:58:36-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T14:58:36-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"home\",\"controller_ident\":null,\"id\":\"1\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Accueil\",\"en\":\"Home\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/accueil\",\"en\":\"\\/en\\/home\"},\"meta_title\":{\"fr\":\"Accueuil\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est la page d\'accueuil\",\"en\":\"This is the home page\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}','{\"1\":{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:58:36-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T14:58:36-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"home\",\"controller_ident\":null,\"id\":\"1\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Accueil\",\"en\":\"Home\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/accueil\",\"en\":\"\\/en\\/home\"},\"meta_title\":{\"fr\":\"Accueuil\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est la page d\'accueuil\",\"en\":\"This is the home page\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}}'),
	(3,'boilerplate/object/section','2',1,'2016-11-01 15:03:29','jalphonso','[]','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:59:23-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T14:59:23-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"generic\",\"controller_ident\":null,\"id\":\"2\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Page exemple\",\"en\":\"Exemple page\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/page-exemple\",\"en\":\"\\/en\\/exemple-page\"},\"meta_title\":{\"fr\":\"Page exemple\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est une page générique d\'exemple.\",\"en\":\"This is an exemple of a generic page\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}','{\"1\":{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:59:23-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T14:59:23-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"generic\",\"controller_ident\":null,\"id\":\"2\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Page exemple\",\"en\":\"Exemple page\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/page-exemple\",\"en\":\"\\/en\\/exemple-page\"},\"meta_title\":{\"fr\":\"Page exemple\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est une page générique d\'exemple.\",\"en\":\"This is an exemple of a generic page\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}}'),
	(4,'boilerplate/object/section','3',1,'2016-11-01 15:05:40','jalphonso','[]','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T15:04:03-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T15:04:03-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"news-list\",\"controller_ident\":null,\"id\":\"3\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Actualité\",\"en\":\"News\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/actualite\",\"en\":\"\\/en\\/news\"},\"meta_title\":{\"fr\":\"Actualité\",\"en\":\"News\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est la liste des actualités\",\"en\":\"This is the news list\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}','{\"1\":{\"active\":true,\"position\":0,\"created\":\"2016-11-01T15:04:03-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T15:04:03-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"news-list\",\"controller_ident\":null,\"id\":\"3\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Actualité\",\"en\":\"News\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/actualite\",\"en\":\"\\/en\\/news\"},\"meta_title\":{\"fr\":\"Actualité\",\"en\":\"News\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est la liste des actualités\",\"en\":\"This is the news list\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}}'),
	(5,'boilerplate/object/section','1',2,'2016-11-01 15:06:21','jalphonso','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:58:36-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T14:58:36-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"home\",\"controller_ident\":null,\"id\":\"1\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Accueil\",\"en\":\"Home\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/accueil\",\"en\":\"\\/en\\/home\"},\"meta_title\":{\"fr\":\"Accueuil\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est la page d\'accueuil\",\"en\":\"This is the home page\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:58:36-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T15:03:02-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"home\",\"controller_ident\":null,\"id\":\"1\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Accueil\",\"en\":\"Home\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/accueil\",\"en\":\"\\/en\\/home\"},\"meta_title\":{\"fr\":\"Accueuil\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est la page d\'accueil\",\"en\":\"This is the home page\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}','[{\"last_modified\":\"2016-11-01T14:58:36-04:00\",\"summary\":{\"fr\":\"Ceci est la page d\'accueuil\"}},{\"last_modified\":\"2016-11-01T15:03:02-04:00\",\"summary\":{\"fr\":\"Ceci est la page d\'accueil\"}}]'),
	(6,'boilerplate/object/section','2',2,'2016-11-01 15:06:55','jalphonso','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:59:23-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T14:59:23-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"generic\",\"controller_ident\":null,\"id\":\"2\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Page exemple\",\"en\":\"Exemple page\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/page-exemple\",\"en\":\"\\/en\\/exemple-page\"},\"meta_title\":{\"fr\":\"Page exemple\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est une page générique d\'exemple.\",\"en\":\"This is an exemple of a generic page\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}','{\"active\":true,\"position\":0,\"created\":\"2016-11-01T14:59:23-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-01T15:03:29-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"generic\",\"controller_ident\":null,\"id\":\"2\",\"section_type\":\"charcoal\\/cms\\/section\\/content\",\"title\":{\"fr\":\"Page exemple\",\"en\":\"Exemple page\"},\"subtitle\":null,\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"slug\":{\"fr\":\"\\/fr\\/page-exemple\",\"en\":\"\\/en\\/exemple-page\"},\"meta_title\":{\"fr\":\"Page exemple\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"master\":null,\"locked\":null,\"summary\":{\"fr\":\"Ceci est un exemple de page générique\",\"en\":\"This is an exemple of a generic page.\"},\"keywords\":[],\"external_url\":{\"fr\":\"\",\"en\":\"\"},\"main_menu\":\"0\"}','[{\"last_modified\":\"2016-11-01T14:59:23-04:00\",\"summary\":{\"fr\":\"Ceci est une page générique d\'exemple.\",\"en\":\"This is an exemple of a generic page\"}},{\"last_modified\":\"2016-11-01T15:03:29-04:00\",\"summary\":{\"fr\":\"Ceci est un exemple de page générique\",\"en\":\"This is an exemple of a generic page.\"}}]'),
	(7,'boilerplate/object/news','1',1,'2016-11-02 14:21:14','jalphonso','[]','{\"active\":true,\"position\":0,\"created\":\"2016-11-02T14:20:59-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-02T14:20:59-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"news-entry\",\"controller_ident\":null,\"slug\":{\"fr\":\"\\/fr\\/actualites\\/nouvelle-1\",\"en\":\"\\/en\\/news\\/nouvelle-1\"},\"publish_date\":\"2016-11-02T14:20:59-04:00\",\"expiry_date\":\"2017-01-02T14:20:59-05:00\",\"publish_status\":\"published\",\"id\":\"1\",\"title\":{\"fr\":\"Nouvelle 1\",\"en\":\"News 1\"},\"subtitle\":null,\"summary\":{\"fr\":\"Ceci est la nouvelle 1\",\"en\":\"This is the news 1\"},\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"news_date\":\"2016-11-02T14:20:59-04:00\",\"info_url\":null,\"meta_title\":{\"fr\":\"Nouvelle 1\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"category\":\"1\",\"alert\":false,\"keywords\":[],\"author\":null}','{\"1\":{\"active\":true,\"position\":0,\"created\":\"2016-11-02T14:20:59-04:00\",\"created_by\":\"jalphonso\",\"last_modified\":\"2016-11-02T14:20:59-04:00\",\"last_modified_by\":\"jalphonso\",\"template_options\":[],\"template_ident\":\"news-entry\",\"controller_ident\":null,\"slug\":{\"fr\":\"\\/fr\\/actualites\\/nouvelle-1\",\"en\":\"\\/en\\/news\\/nouvelle-1\"},\"publish_date\":\"2016-11-02T14:20:59-04:00\",\"expiry_date\":\"2017-01-02T14:20:59-05:00\",\"publish_status\":\"published\",\"id\":\"1\",\"title\":{\"fr\":\"Nouvelle 1\",\"en\":\"News 1\"},\"subtitle\":null,\"summary\":{\"fr\":\"Ceci est la nouvelle 1\",\"en\":\"This is the news 1\"},\"content\":null,\"image\":{\"fr\":\"\",\"en\":\"\"},\"news_date\":\"2016-11-02T14:20:59-04:00\",\"info_url\":null,\"meta_title\":{\"fr\":\"Nouvelle 1\",\"en\":\"\"},\"meta_description\":{\"fr\":\"\",\"en\":\"\"},\"meta_image\":{\"fr\":\"\",\"en\":\"\"},\"meta_author\":null,\"category\":\"1\",\"alert\":false,\"keywords\":[],\"author\":null}}');

/*!40000 ALTER TABLE `object_revisions` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table object_routes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `object_routes`;

CREATE TABLE `object_routes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `last_modification_date` datetime DEFAULT NULL,
  `lang` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `route_obj_type` varchar(255) DEFAULT NULL,
  `route_obj_id` varchar(255) DEFAULT NULL,
  `route_template` varchar(255) DEFAULT NULL,
  `route_options` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `object_routes` WRITE;
/*!40000 ALTER TABLE `object_routes` DISABLE KEYS */;

INSERT INTO `object_routes` (`id`, `active`, `creation_date`, `last_modification_date`, `lang`, `slug`, `route_obj_type`, `route_obj_id`, `route_template`, `route_options`)
VALUES
	(3,1,'2016-11-01 14:59:23','2016-11-01 14:59:23','fr','/fr/page-exemple','boilerplate/object/section','2','generic',NULL),
	(4,1,'2016-11-01 14:59:23','2016-11-01 14:59:23','en','/en/page-exemple','boilerplate/object/section','2','generic',NULL),
	(5,1,'2016-11-01 15:03:02','2016-11-01 15:03:02','fr','/fr/accueil','boilerplate/object/section','1','home',NULL),
	(6,1,'2016-11-01 15:03:02','2016-11-01 15:03:02','en','/en/home','boilerplate/object/section','1','home',NULL),
	(7,1,'2016-11-01 15:03:29','2016-11-01 15:03:29','en','/en/exemple-page','boilerplate/object/section','2','generic',NULL),
	(8,1,'2016-11-01 15:04:03','2016-11-01 15:04:03','fr','/fr/actualite','boilerplate/object/section','3','news-list',NULL),
	(9,1,'2016-11-01 15:04:03','2016-11-01 15:04:03','en','/en/news','boilerplate/object/section','3','news-list',NULL),
	(10,1,'2016-11-01 15:08:28','2016-11-01 15:08:28','fr','/fr/evenements','boilerplate/object/section','4','event-list',NULL),
	(11,1,'2016-11-01 15:08:28','2016-11-01 15:08:28','en','/en/events','boilerplate/object/section','4','event-list',NULL),
	(14,1,'2016-11-02 14:20:59','2016-11-02 14:20:59','fr','/fr/actualites/nouvelle-1','boilerplate/object/news','1','news-entry',NULL),
	(15,1,'2016-11-02 14:20:59','2016-11-02 14:20:59','en','/en/news/news-1','boilerplate/object/news','1','news-entry',NULL),
	(16,1,'2016-11-02 14:21:45','2016-11-02 14:21:45','fr','/fr/actualites/nouvelle-2','boilerplate/object/news','2','news-entry',NULL),
	(17,1,'2016-11-02 14:21:45','2016-11-02 14:21:45','en','/en/news/news-2','boilerplate/object/news','2','news-entry',NULL),
	(18,1,'2016-11-02 14:22:14','2016-11-02 14:22:14','fr','/fr/actualites/nouvelle-3','boilerplate/object/news','3','news-entry',NULL),
	(19,1,'2016-11-02 14:22:14','2016-11-02 14:22:14','en','/en/news/news-3','boilerplate/object/news','3','news-entry',NULL),
	(20,1,'2016-11-02 14:22:55','2016-11-02 14:22:55','fr','/fr/evenements/evenement-1','boilerplate/object/event','1','event-entry',NULL),
	(21,1,'2016-11-02 14:22:55','2016-11-02 14:22:55','en','/en/events/event-1','boilerplate/object/event','1','event-entry',NULL),
	(22,1,'2016-11-02 14:23:12','2016-11-02 14:23:12','fr','/fr/evenements/evenement-2','boilerplate/object/event','2','event-entry',NULL),
	(23,1,'2016-11-02 14:23:12','2016-11-02 14:23:12','en','/en/events/event-2','boilerplate/object/event','2','event-entry',NULL),
	(24,1,'2016-11-02 14:23:30','2016-11-02 14:23:30','fr','/fr/evenements/evenement-3','boilerplate/object/event','3','event-entry',NULL),
	(25,1,'2016-11-02 14:23:30','2016-11-02 14:23:30','en','/en/events/event-3','boilerplate/object/event','3','event-entry',NULL),
	(26,1,'2016-11-01 15:03:02','2016-11-01 15:03:02','fr','/','boilerplate/object/section','1','home',NULL);

/*!40000 ALTER TABLE `object_routes` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
