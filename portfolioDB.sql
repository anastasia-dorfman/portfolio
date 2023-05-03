CREATE DATABASE  IF NOT EXISTS `anastasia_dorfman_portfolio` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `anastasia_dorfman_portfolio`;
-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: anastasia_dorfman_portfolio
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`blog_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (1,'MY main blog','http://localhost/blog.php');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL DEFAULT 'image',
  `name` varchar(45) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  KEY `FK_images_posts_idx` (`post_id`),
  KEY `FK_images_projects_idx` (`project_id`),
  CONSTRAINT `FK_images_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_images_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (3,'image','post1_image2.png','./assets/images/post1_image2.png',1,NULL),(4,'image','project1_image1.png','./assets/images/project1_image1.png',NULL,1),(5,'image','project1_image2.png','./assets/images/project1_image2.png',NULL,1),(6,'image','project1_image3.png','./assets/images/project1_image3.png',NULL,1),(9,'avatar','post16_avatar.jpeg','./assets/images/post16_avatar.jpeg',16,NULL),(10,'image','post16_image1.jpg','./assets/images/post16_image1.jpg',16,NULL),(12,'image','post1_image1.png','./assets/images/post1_image1.png',1,NULL),(14,'image','post1_image3.png','./assets/images/post1_image3.png',1,NULL),(15,'image','post1_image4.png','./assets/images/post1_image4.png',1,NULL),(33,'avatar','post1_avatar','./assets/images/post1_avatar',1,NULL);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_tags` (
  `post_id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_name`),
  KEY `FK_post_tags_tag_name_idx` (`tag_name`),
  CONSTRAINT `FK_post_tags_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_post_tags_tag_name` FOREIGN KEY (`tag_name`) REFERENCES `tags` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tags`
--

LOCK TABLES `post_tags` WRITE;
/*!40000 ALTER TABLE `post_tags` DISABLE KEYS */;
INSERT INTO `post_tags` VALUES (1,'             HTML'),(1,'             MySQL'),(1,'             PHP'),(1,'            CSS'),(16,' tips'),(16,'studentlife');
/*!40000 ALTER TABLE `post_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `FK_posts_idx` (`blog_id`),
  KEY `FK_posts_users_idx` (`user_id`),
  CONSTRAINT `FK_posts` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_posts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Creating a Winning Portfolio Website: Challenges and Technologies for IT Students','<p><span style=\"font-size: 18pt;\">As an IT student, I understood the importance of creating a portfolio website to showcase my skills and experience to potential employers. It was important to me to create a website that would differentiate me from other candidates and effectively showcase my technical abilities. However, I encountered some challenges during the creation of my portfolio website. Designing an aesthetically pleasing and user-friendly website was a significant obstacle for me since I had limited experience in web development. Additionally, selecting the right technologies and tools to use was overwhelming, considering the vast array of options available.</span></p>\r\n<p><span style=\"font-size: 18pt;\">To overcome these challenges, I chose to use <strong>HTML/CSS</strong> as the foundation of my website, with <strong>PHP </strong>as my server-side scripting language. I used <strong>MySQL </strong>to manage the database, which allowed me to handle form submissions and store user information. Although I did not use Bootstrap, I created a responsive and mobile-friendly website using my HTML/CSS skills. Overall, creating a portfolio website is a crucial step for IT students to establish their personal brand and online presence. Despite the challenges, using the right technologies and tools, such as PHP, MySQL, and HTML/CSS, can help you create a successful and impressive website. Remember to keep your website up-to-date with your latest projects and accomplishments to continue building your personal brand and showcasing your technical abilities.</span></p>','2023-04-19 19:17:36',1,3),(16,'How to Stay Sane as an IT Student: A First-Person Guide to Time Management','Hey there, fellow IT students! Are you feeling overwhelmed with assignments, projects, and deadlines? Are you starting to feel like you\'re living in a perpetual state of stress and exhaustion? Fear not, because I\'ve been there too. But through trial and error (and a lot of coffee), I\'ve learned a few things about managing my time without going completely insane. So, here are my top tips for staying sane as an IT student:\r\n\r\nTip #1: Make Friends with Procrastination\r\n\r\nLet\'s face it, we all procrastinate. It\'s part of human nature, and as an IT student, you\'re probably pretty good at it. So why fight it? Embrace your inner procrastinator, but do it proactively. Set yourself a timer for 30 minutes of mindless scrolling on social media or watching cat videos on YouTube, and then get back to work. You\'ll be surprised at how much more productive you are when you allow yourself a little break from the grind.\r\n\r\nTip #2: Set Priorities and Stick to Them\r\n\r\nAs an IT student, you probably have a never-ending to-do list. But let\'s be honest, not everything on that list is equally important. So, set priorities for yourself and stick to them. Figure out what tasks are urgent, what tasks are important, and what tasks can wait. Then, tackle them in order of priority. And if you don\'t get to everything on your list? That\'s okay. You\'re only human.\r\n\r\nTip #3: Take Breaks (And Don\'t Feel Guilty About It)\r\n\r\nIt\'s easy to fall into the trap of thinking that you have to work non-stop to be successful. But that\'s simply not true. In fact, taking breaks is essential for maintaining your productivity and mental health. So, take a walk, do some yoga, meditate, or just stare out the window for a few minutes. Your brain (and your sanity) will thank you.\r\n\r\nTip #4: Ask for Help When You Need It\r\n\r\nAs IT students, we like to think that we can do everything ourselves. But that\'s simply not possible. Don\'t be afraid to ask your classmates, professors, or even your family and friends for help when you need it. And don\'t forget to offer your own help in return. It\'s amazing how much you can learn (and how much you can accomplish) when you work together.\r\n\r\nIn conclusion, managing your time as an IT student can be tough, but it\'s not impossible. Embrace your inner procrastinator, set priorities, take breaks, and ask for help when you need it. And remember, you\'re not alone in this. We\'re all in the same boat (or rather, the same code editor). So, let\'s support each other, have a few laughs along the way, and stay sane together.','2023-04-27 19:56:14',1,3);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_skills`
--

DROP TABLE IF EXISTS `project_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_skills` (
  `project_id` int(11) NOT NULL,
  `skill_name` varchar(45) NOT NULL,
  PRIMARY KEY (`project_id`,`skill_name`),
  KEY `FK_project_skills_skill_name_idx` (`skill_name`),
  CONSTRAINT `FK_project_skills_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_project_skills_skill_name` FOREIGN KEY (`skill_name`) REFERENCES `skills` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_skills`
--

LOCK TABLES `project_skills` WRITE;
/*!40000 ALTER TABLE `project_skills` DISABLE KEYS */;
INSERT INTO `project_skills` VALUES (1,'.NET 6.0'),(1,'C#'),(1,'MSSMS'),(1,'T-SQL');
/*!40000 ALTER TABLE `project_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `overview` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code_link` varchar(255) NOT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Digital Reservation System','The Digital Reservation System is a project aimed at helping businesses manage guest reservations and stays in a more efficient manner. The system allows for creating reservations, searching/viewing reservations,  and searching for available rooms. The project was created using MSSMS, C#,  N-Tier architecture, and .NET 6.0.','2022-12-11 00:00:00','https://github.com/anastasia-dorfman/Ntier_ReservationSystem','A digital reservation system for managing guest reservations and stays in a more efficient manner');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `name` varchar(255) NOT NULL,
  `type` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES ('.NET 6.0','Framework'),('Angular',NULL),('ASP.Net MVC 5','Framework'),('C#','Language'),('CSS','Language'),('Flutter','Language'),('HTML','Language'),('Java','Language'),('JavaScript','Language'),('MSSMS','Database'),('MySQL','Database'),('PHP','Language'),('React',NULL),('SQL Server','Database'),('T-SQL','Database'),('TypeScript','Language');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `name` varchar(255) NOT NULL,
  `is_post_tag` bit(1) DEFAULT b'1',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES ('',_binary ''),('             HTML',_binary ''),('             MySQL',_binary ''),('             PHP',_binary ''),('            CSS',_binary ''),('            HTML',_binary ''),('            MySQL',_binary ''),('            PHP',_binary ''),('           CSS',_binary ''),('           HTML',_binary ''),('           MySQL',_binary ''),('           PHP',_binary ''),('          CSS',_binary ''),('          HTML',_binary ''),('          MySQL',_binary ''),('          PHP',_binary ''),('         CSS',_binary ''),('         HTML',_binary ''),('         MySQL',_binary ''),('         PHP',_binary ''),('        CSS',_binary ''),('        HTML',_binary ''),('        MySQL',_binary ''),('        PHP',_binary ''),('       CSS',_binary ''),('       HTML',_binary ''),('       MySQL',_binary ''),('       PHP',_binary ''),('      CSS',_binary ''),('      HTML',_binary ''),('      MySQL',_binary ''),('      PHP',_binary ''),('     CSS',_binary ''),('     HTML',_binary ''),('     MySQL',_binary ''),('     PHP',_binary ''),('    CSS',_binary ''),('    HTML',_binary ''),('    MySQL',_binary ''),('    PHP',_binary ''),('   CSS',_binary ''),('   HTML',_binary ''),('   MySQL',_binary ''),('   PHP',_binary ''),('  CSS',_binary ''),('  HTML',_binary ''),('  MySQL',_binary ''),('  PHP',_binary ''),(' CSS',_binary ''),(' HTML',_binary ''),(' MySQL',_binary ''),(' PHP',_binary ''),(' tips',_binary ''),('ASP.Net',_binary ''),('Boot Spring',_binary ''),('Bootstrap',_binary ''),('C#',_binary ''),('CSS',_binary ''),('Entity Framework',_binary ''),('HTML',_binary ''),('Java',_binary ''),('JavaScript',_binary ''),('Mobile',_binary ''),('MySQL',_binary ''),('PHP',_binary ''),('SQL',_binary ''),('studentlife',_binary ''),('tips',_binary ''),('Web',_binary '');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(100) NOT NULL,
  `l_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` varchar(45) NOT NULL DEFAULT 'User',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'Anastasia','Dorfman','anastasia.dorfman1@gmail.com','$2y$10$FEqajPyD0VsK5W/U.xBjneugnp/MbcOlYjTBjGnBMe9hTekm0.9F2','@AD',NULL,'2023-04-19 19:13:11','admin'),(4,'Delon','Van de Venter','delon.vandeventer@nbcc.ca','$2y$10$wkC99kKjSr/mJ3ILH1vlxe2oMtSrZfa3hN0B22.8piuwtXA19Pug.','@Delon',NULL,'2023-04-20 19:13:11','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `works` (
  `work_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` longtext,
  PRIMARY KEY (`work_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
INSERT INTO `works` VALUES (1,'Restraunt',NULL),(2,'Hotel Reservation System',NULL),(3,'Card Game',NULL),(4,'Mobile App',NULL),(5,'Realtor Agency',NULL),(6,'Social Media',NULL);
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-03 15:12:28
