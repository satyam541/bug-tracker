/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 9.1.0 : Database - bug_tracker
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bug_tracker` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `bug_tracker`;

/*Table structure for table `activity_logs` */

DROP TABLE IF EXISTS `activity_logs`;

CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `activity_logs` */

insert  into `activity_logs`(`id`,`user_id`,`action`,`description`,`subject_type`,`subject_id`,`created_at`,`updated_at`) values 
(1,1,'project_created','Project \'E-Commerce Platform\' was created.','App\\Models\\Project',1,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(2,1,'project_created','Project \'Student Management System\' was created.','App\\Models\\Project',2,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(3,4,'bug_created','Bug \'Login page crashes on mobile\' was created.','App\\Models\\Bug',1,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(4,1,'bug_assigned','Bug \'Login page crashes on mobile\' was assigned to John Developer.','App\\Models\\Bug',1,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(5,4,'bug_created','Bug \'Cart total not updating\' was created.','App\\Models\\Bug',2,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(6,2,'bug_status_changed','Bug \'Cart total not updating\' status changed to \'In Progress\'.','App\\Models\\Bug',2,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(7,2,'comment_added','Comment added on bug \'Login page crashes on mobile\'.','App\\Models\\Bug',1,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(8,1,'user_created','User \'John Developer\' was created.','App\\Models\\User',2,'2026-03-24 12:44:32','2026-03-24 12:44:32');

/*Table structure for table `bugs` */

DROP TABLE IF EXISTS `bugs`;

CREATE TABLE `bugs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` bigint unsigned NOT NULL,
  `reporter_id` bigint unsigned NOT NULL,
  `assigned_to` bigint unsigned DEFAULT NULL,
  `status` enum('open','in_progress','fixed','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `priority` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `severity` enum('minor','major','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'minor',
  `screenshot` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bugs_project_id_foreign` (`project_id`),
  KEY `bugs_reporter_id_foreign` (`reporter_id`),
  KEY `bugs_assigned_to_foreign` (`assigned_to`),
  KEY `bugs_status_index` (`status`),
  KEY `bugs_priority_index` (`priority`),
  KEY `bugs_severity_index` (`severity`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bugs` */

insert  into `bugs`(`id`,`title`,`description`,`project_id`,`reporter_id`,`assigned_to`,`status`,`priority`,`severity`,`screenshot`,`created_at`,`updated_at`) values 
(1,'Login page crashes on mobile','The login page throws a JavaScript error on mobile browsers. Form submission fails and shows a blank white screen.',1,4,2,'open','high','major',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(2,'Cart total not updating','When items are added or removed from the cart, the total amount does not update until page refresh.',1,5,2,'in_progress','critical','critical',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(3,'Payment gateway timeout','Payment processing times out after 30 seconds during peak hours. Customers see an error page.',1,4,3,'open','critical','critical',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(4,'Search results show deleted products','Products that have been marked as deleted still appear in search results.',1,5,3,'fixed','medium','minor',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(5,'Order confirmation email not sent','After successful checkout, users do not receive the order confirmation email.',1,4,2,'closed','high','major',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(6,'Student registration form validation missing','The registration form allows submission without required fields like name and email.',2,5,2,'open','medium','major',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(7,'Attendance report shows wrong dates','The attendance report displays dates one day ahead of the actual attendance date.',2,4,3,'in_progress','high','major',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(8,'Grade calculation error for weighted courses','Weighted average grades are calculated incorrectly when a student has courses with different credit hours.',2,5,2,'open','high','critical',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(9,'Profile picture upload fails for PNG','Students cannot upload PNG profile pictures. Only JPEG files are accepted.',2,4,NULL,'open','low','minor',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(10,'Course dropdown empty on enrollment page','The course selection dropdown on the enrollment page is empty. Students cannot enroll in any courses.',2,5,3,'fixed','critical','critical',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32');

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bug_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_bug_id_foreign` (`bug_id`),
  KEY `comments_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `comments` */

insert  into `comments`(`id`,`bug_id`,`user_id`,`body`,`created_at`,`updated_at`) values 
(1,1,2,'I can reproduce this issue. Looks like a CSS viewport issue. Working on a fix.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(2,1,4,'This happens on both Chrome and Safari mobile browsers.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(3,2,2,'Found the issue. The AJAX call is not refreshing the totals. Fixing now.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(4,3,3,'This seems to be a timeout configuration issue with the payment API.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(5,3,1,'This is critical. Please prioritize this fix.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(6,5,2,'Fixed the SMTP configuration. Emails are sending correctly now.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(7,6,2,'I will add proper validation rules to all required fields.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(8,7,3,'The timezone configuration was wrong. Fixing the date calculation.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(9,8,4,'Students are getting incorrect GPAs because of this issue.','2026-03-24 12:44:32','2026-03-24 12:44:32'),
(10,10,3,'The API endpoint for courses was returning empty. Fixed the query.','2026-03-24 12:44:32','2026-03-24 12:44:32');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'0001_01_01_000003_create_roles_table',1),
(5,'0001_01_01_000004_add_role_id_to_users_table',1),
(6,'0001_01_01_000005_create_projects_table',1),
(7,'0001_01_01_000006_create_project_user_table',1),
(8,'0001_01_01_000007_create_bugs_table',1),
(9,'0001_01_01_000008_create_comments_table',1),
(10,'0001_01_01_000009_create_activity_logs_table',1);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `project_user` */

DROP TABLE IF EXISTS `project_user`;

CREATE TABLE `project_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_user_project_id_user_id_unique` (`project_id`,`user_id`),
  KEY `project_user_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_user` */

insert  into `project_user`(`id`,`project_id`,`user_id`,`created_at`,`updated_at`) values 
(1,1,1,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(2,1,2,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(3,1,3,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(4,1,4,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(5,1,5,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(6,2,1,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(7,2,2,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(8,2,3,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(9,2,4,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(10,2,5,'2026-03-24 12:44:32','2026-03-24 12:44:32');

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `projects` */

insert  into `projects`(`id`,`name`,`description`,`status`,`created_by`,`created_at`,`updated_at`) values 
(1,'E-Commerce Platform','An online shopping platform with cart, checkout, payment integration, and order tracking.','active',1,'2026-03-24 12:44:32','2026-03-24 12:44:32'),
(2,'Student Management System','A system to manage student records, attendance, grades, and course registrations.','active',1,'2026-03-24 12:44:32','2026-03-24 12:44:32');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'admin','2026-03-24 12:44:31','2026-03-24 12:44:31'),
(2,'developer','2026-03-24 12:44:31','2026-03-24 12:44:31'),
(3,'tester','2026-03-24 12:44:31','2026-03-24 12:44:31');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('ehEIDpenEP8B4JiuzTu7jyyvlhI8teEDVjumDRid',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.112.0 Chrome/142.0.7444.265 Electron/39.8.0 Safari/537.36','eyJfdG9rZW4iOiJmd1F3cmNjbFdGY0NHMTJwY2Z3UmFKSXE1SUhva1pFRjY3d2NrSWhaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAxXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1774356443),
('aNERmjnCbYmXGiGnVpaHTxHWnreUZKaUJubwHDWh',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJidWFMbVNsbGg5SWl2emt4N3p4aUJhNGRxVDM2MGExWlVkbWdTTWlDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1774360965);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`role_id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,1,'Admin User','admin@bugtracker.com',NULL,'$2y$12$iEHZi0/DbMZ4sM7Fh7Ji7eRL69F5xqveh5X3m5EtLfOiM90sbeBmK',NULL,'2026-03-24 12:44:31','2026-03-24 12:44:31'),
(2,2,'John Developer','dev1@bugtracker.com',NULL,'$2y$12$UwAndH1sEFZ4ApfYinib8O/zHednCEvvJijY7BdsagjRNKdk7/kGO',NULL,'2026-03-24 12:44:31','2026-03-24 12:44:31'),
(3,2,'Jane Developer','dev2@bugtracker.com',NULL,'$2y$12$b4OhafrzDXxv18UM2BrH1OtIwOCaBKB14UX87Ht58AeQmL91uPluu',NULL,'2026-03-24 12:44:31','2026-03-24 12:44:31'),
(4,3,'Alice Tester','tester1@bugtracker.com',NULL,'$2y$12$WjKadiguLp8vcC/Nd3uyceB0vsEpTs75.qYu1Ox4e4csdRa97IF2q',NULL,'2026-03-24 12:44:31','2026-03-24 12:44:31'),
(5,3,'Bob Tester','tester2@bugtracker.com',NULL,'$2y$12$oyHhrRqHaDZGFsdFiBp3yuGX3INTbz.xVmjcg/1RnSmLcRN8K2iFa',NULL,'2026-03-24 12:44:32','2026-03-24 12:44:32');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
