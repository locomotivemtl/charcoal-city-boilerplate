
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
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `categories` text,
  `subtitle_en` varchar(255) DEFAULT NULL,
  `subtitle_fr` varchar(255) DEFAULT NULL,
  `description_en` text,
  `description_fr` text,
  `keywords_en` text,
  `keywords_fr` text,
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



# Affichage de la table city_authors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_authors`;

CREATE TABLE `city_authors` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `link_en` varchar(255) DEFAULT NULL,
  `link_fr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table city_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_config`;

CREATE TABLE `city_config` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `default_from_email` varchar(255) DEFAULT NULL,
  `default_meta_title` varchar(255) DEFAULT NULL,
  `default_meta_description_en` varchar(255) DEFAULT NULL,
  `default_meta_description_fr` varchar(255) DEFAULT NULL,
  `default_meta_image` varchar(255) DEFAULT NULL,
  `default_meta_url` varchar(255) DEFAULT NULL,
  `home_news` text,
  `home_events` text,
  `default_meta_title_en` varchar(255) DEFAULT NULL,
  `default_meta_title_fr` varchar(255) DEFAULT NULL,
  `default_meta_url_en` varchar(255) DEFAULT NULL,
  `default_meta_url_fr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `city_config` WRITE;
/*!40000 ALTER TABLE `city_config` DISABLE KEYS */;

INSERT INTO `city_config` (`active`, `position`, `created`, `created_by`, `last_modified`, `last_modified_by`, `id`, `default_from_email`, `default_meta_title`, `default_meta_description_en`, `default_meta_description_fr`, `default_meta_image`, `default_meta_url`, `home_news`, `home_events`, `default_meta_title_en`, `default_meta_title_fr`, `default_meta_url_en`, `default_meta_url_fr`)
VALUES
	(1,0,'2016-09-19 15:33:20',NULL,'2016-09-19 18:39:02','jalphonso',1,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `city_config` ENABLE KEYS */;
UNLOCK TABLES;


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



# Affichage de la table city_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_events`;

CREATE TABLE `city_events` (
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



# Affichage de la table city_news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_news`;

CREATE TABLE `city_news` (
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



# Affichage de la table city_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_sections`;

CREATE TABLE `city_sections` (
  `active` tinyint(1) unsigned DEFAULT NULL,
  `position` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `master` int(10) unsigned DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_title_fr` varchar(255) DEFAULT NULL,
  `meta_description_en` text,
  `meta_description_fr` text,
  `meta_image_en` varchar(255) DEFAULT NULL,
  `meta_image_fr` varchar(255) DEFAULT NULL,
  `meta_author_en` varchar(255) DEFAULT NULL,
  `meta_author_fr` varchar(255) DEFAULT NULL,
  `slug_en` varchar(255) DEFAULT NULL,
  `slug_fr` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section_type` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `subtitle_en` text,
  `subtitle_fr` text,
  `content_en` text,
  `content_fr` text,
  `image_en` varchar(255) DEFAULT NULL,
  `image_fr` varchar(255) DEFAULT NULL,
  `template_options` longtext,
  `template_ident` varchar(255) NOT NULL,
  `locked` tinyint(1) unsigned DEFAULT NULL,
  `summary` text,
  `external_url_en` varchar(255) DEFAULT NULL,
  `external_url_fr` varchar(255) DEFAULT NULL,
  `main_menu` tinyint(1) unsigned DEFAULT NULL,
  `nav_menu` text,
  `keywords` text,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
