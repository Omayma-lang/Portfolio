
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `issuer` varchar(255) DEFAULT NULL,
  `cert_date` varchar(100) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
INSERT INTO `certificates` VALUES (1,'Effective Business Websites','HP LIFE',NULL,'assets/certificates/effective-business-websites.pdf','2026-09-05 06:58:30');
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `project_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_project_images_project` (`project_id`),
  CONSTRAINT `fk_project_images_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `project_images` WRITE;
/*!40000 ALTER TABLE `project_images` DISABLE KEYS */;
INSERT INTO `project_images` VALUES (4,1,'assets/images/projects/bookstore-ecommerce-site/screenshot-1.jpg','Storefront',0,'2026-09-02 19:55:36'),(5,1,'assets/images/projects/bookstore-ecommerce-site/screenshot-2.jpg','Browsing catalog',1,'2026-09-02 19:55:36'),(6,1,'assets/images/projects/bookstore-ecommerce-site/screenshot-3.jpg','Product details',2,'2026-09-02 19:55:36'),(7,1,'assets/images/projects/bookstore-ecommerce-site/screenshot-4.jpg','Cart & orders',3,'2026-09-02 19:55:36'),(8,2,'assets/images/projects/the-great-picnic-rescue/cover.jpg','Book cover',0,'2026-09-02 20:01:43');
/*!40000 ALTER TABLE `project_images` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `full_description` longtext DEFAULT NULL,
  `tech_used` text DEFAULT NULL,
  `live_url` varchar(500) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Bookstore E-Commerce Site','bookstore-ecommerce-site','A complete online bookstore where customers can browse, search, and place orders â€” with a full admin side to manage stock, products, and orders.','The Problems:\nA local bookstore wanted its catalog online. Physical browsing or phone orders weren\'t scaleable, and they needed a place where customers could see what was in stock and place an order without calling.\n\nMy Approach:\nI built it as a full e-commerce experience with two clear sides â€” a customer-facing storefront and an admin panel for the owner. The storefront pulls books from the database with category filters, a search bar, product detail pages, a shopping cart, and an order checkout flow. The admin side lets the owner add, edit, and remove books, manage stock and pricing, and view incoming orders.\n\nDesign Decisions:\nBooks are a visual product, so I let clear product cards and cover art do the heavy lifting. Category filters and search sit up front to keep browsing friction low, and the admin interface is deliberately simple because its user isn\'t technical.\n\nWhat I\'d Improve:\nI\'d add a payment gateway so orders settle online, improve image handling for faster loads, and add stock-level alerts so the owner knows when to reorder.','PHP, MySQL, HTML, CSS, JavaScript','http://okhelfaoui23.atwebpages.com/main.html',1,'2026-09-02 18:06:06'),(2,'The Great Picnic Rescue','the-great-picnic-rescue','A bilingual (Arabic/English) children\'s book Ã¹ a puzzle-and-teamwork story with coloring pages, designed and published independently.',NULL,'Canva, KDP Publishing, Illustration',NULL,2,'2026-09-02 18:06:18');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'hero_heading','Welcome, I\'m <span class=\"highlight\">Omayma</span>.'),(2,'hero_subheading','A Full-Stack Developer combining the precision of backend engineering with the beauty of frontend design. I transform creative ideas into living digital experiences delivered right on time.'),(3,'about_text','I build web experiences that help small businesses and individuals turn visitors into customers. My work spans web development, with UI/UX design and video editing as complementary skills I bring to every project.'),(4,'contact_email','okhelfaoui23@gmail.com');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

