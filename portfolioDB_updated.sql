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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (3,'image','post1_image2','./assets/images/post1_image2.png',1,NULL),(9,'avatar','post16_avatar','./assets/images/post16_avatar.jpeg',16,NULL),(10,'image','post16_image1','./assets/images/post16_image1.jpg',16,NULL),(27,'avatar','project1_avatar','./assets/images/project1_avatar.png',1,NULL),(28,'image','project1_image3','./assets/images/project1_image3.png',1,NULL),(36,'avatar','project17_avatar','./assets/images/project17_avatar.jpg',17,NULL),(37,'image','project17_image1','./assets/images/project17_image1.jpg',17,NULL),(38,'avatar','project18_avatar','./assets/images/project18_avatar.png',18,NULL),(39,'avatar','project7_avatar','./assets/images/project7_avatar.png',NULL,7),(40,'image','project7_image1','./assets/images/project7_image1.png',NULL,7),(41,'image','project7_image2','./assets/images/project7_image2.png',NULL,7),(42,'avatar','project8_avatar','./assets/images/project8_avatar.png',NULL,8),(43,'image','project8_image1','./assets/images/project8_image1.png',NULL,8),(44,'image','project8_image2','./assets/images/project8_image2.png',NULL,8),(45,'image','project8_image3','./assets/images/project8_image3.png',NULL,8);
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
INSERT INTO `post_tags` VALUES (17,'AI'),(18,'career'),(18,'coding'),(1,'CSS'),(1,'HTML'),(1,'jobsearch'),(1,'MySQL'),(1,'PHP'),(1,'portfolio'),(18,'social media'),(16,'studentlife'),(18,'telegram'),(16,'tips'),(17,'tips'),(18,'tips'),(17,'webdev tools');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Creating a Winning Portfolio Website: Challenges and Technologies for IT Students','<p><span style=\"font-size: 18pt;\">As an IT student, I understood the importance of creating a portfolio website to showcase my skills and experience to potential employers. It was important to me to create a website that would differentiate me from other candidates and effectively showcase my technical abilities. However, I encountered some challenges during the creation of my portfolio website. Designing an aesthetically pleasing and user-friendly website was a significant obstacle for me since I had limited experience in web development. Additionally, selecting the right technologies and tools to use was overwhelming, considering the vast array of options available.</span></p>\r\n<p><span style=\"font-size: 18pt;\">To overcome these challenges, I chose to use <strong>HTML/CSS</strong> as the foundation of my website, with <strong>PHP </strong>as my server-side scripting language. I used <strong>MySQL </strong>to manage the database, which allowed me to handle form submissions and store user information. Although I did not use Bootstrap, I created a responsive and mobile-friendly website using my HTML/CSS skills. Overall, creating a portfolio website is a crucial step for IT students to establish their personal brand and online presence. Despite the challenges, using the right technologies and tools, such as PHP, MySQL, and HTML/CSS, can help you create a successful and impressive website. Remember to keep your website up-to-date with your latest projects and accomplishments to continue building your personal brand and showcasing your technical abilities.</span></p>','2023-04-19 19:17:36',1,3),(16,'How to Stay Sane as an IT Student: A First-Person Guide to Time Management','Hey there, fellow IT students! Are you feeling overwhelmed with assignments, projects, and deadlines? Are you starting to feel like you\'re living in a perpetual state of stress and exhaustion? Fear not, because I\'ve been there too. But through trial and error (and a lot of coffee), I\'ve learned a few things about managing my time without going completely insane. So, here are my top tips for staying sane as an IT student:\r\n\r\nTip #1: Make Friends with Procrastination\r\n\r\nLet\'s face it, we all procrastinate. It\'s part of human nature, and as an IT student, you\'re probably pretty good at it. So why fight it? Embrace your inner procrastinator, but do it proactively. Set yourself a timer for 30 minutes of mindless scrolling on social media or watching cat videos on YouTube, and then get back to work. You\'ll be surprised at how much more productive you are when you allow yourself a little break from the grind.\r\n\r\nTip #2: Set Priorities and Stick to Them\r\n\r\nAs an IT student, you probably have a never-ending to-do list. But let\'s be honest, not everything on that list is equally important. So, set priorities for yourself and stick to them. Figure out what tasks are urgent, what tasks are important, and what tasks can wait. Then, tackle them in order of priority. And if you don\'t get to everything on your list? That\'s okay. You\'re only human.\r\n\r\nTip #3: Take Breaks (And Don\'t Feel Guilty About It)\r\n\r\nIt\'s easy to fall into the trap of thinking that you have to work non-stop to be successful. But that\'s simply not true. In fact, taking breaks is essential for maintaining your productivity and mental health. So, take a walk, do some yoga, meditate, or just stare out the window for a few minutes. Your brain (and your sanity) will thank you.\r\n\r\nTip #4: Ask for Help When You Need It\r\n\r\nAs IT students, we like to think that we can do everything ourselves. But that\'s simply not possible. Don\'t be afraid to ask your classmates, professors, or even your family and friends for help when you need it. And don\'t forget to offer your own help in return. It\'s amazing how much you can learn (and how much you can accomplish) when you work together.\r\n\r\nIn conclusion, managing your time as an IT student can be tough, but it\'s not impossible. Embrace your inner procrastinator, set priorities, take breaks, and ask for help when you need it. And remember, you\'re not alone in this. We\'re all in the same boat (or rather, the same code editor). So, let\'s support each other, have a few laughs along the way, and stay sane together.','2023-04-27 19:56:14',1,3),(17,'Enhancing Your Web Development Journey: Essential AI Tools for Junior Developers','As a junior web developer, staying ahead of the game and leveraging the power of cutting-edge technologies is crucial to your professional growth. Artificial Intelligence (AI) has emerged as a game-changer in today\'s digital landscape, revolutionizing various industries, including web development. In this post, we will explore a collection of useful AI tools that can empower junior web developers to streamline their workflows, enhance productivity, and deliver exceptional web experiences.\r\n\r\nCode Autocompletion with AI: One of the most time-consuming tasks for developers is writing code. AI-powered code autocompletion tools like Tabnine, Kite, and DeepCode can significantly accelerate your coding process. By analyzing patterns in your code and providing intelligent suggestions, these tools save you precious time and help you write cleaner and more efficient code.\r\n\r\nAutomated Testing and Bug Detection: Ensuring the quality and reliability of your web applications is paramount. AI-driven testing tools like Testim and Applitools can help junior developers identify bugs, errors, and compatibility issues across browsers and devices. By automating the testing process, these tools free up your time for other critical tasks while maintaining the integrity of your codebase.\r\n\r\nNatural Language Processing (NLP) Assistants: Communicating effectively with clients, team members, or end-users is crucial in web development. NLP assistants, such as Dialogflow and Wit.ai, leverage AI to understand and respond to natural language input. These tools enable you to build chatbots, voice assistants, and interactive interfaces that enhance user experience and streamline communication channels.\r\n\r\nImage and Content Analysis: Incorporating AI-powered image and content analysis tools into your web development workflow can offer valuable insights and enhance user engagement. Services like Google Cloud Vision API and IBM Watson Visual Recognition enable you to extract information from images, detect objects, analyze sentiment, and provide personalized content recommendations based on user preferences.\r\n\r\nPerformance Optimization: AI can be vital in optimizing your web applications for speed and performance. Tools like Google\'s PageSpeed Insights and Cloudinary\'s automatic image optimization utilize AI algorithms to analyze and suggest optimizations for your website. These recommendations can enhance user experience, boost search engine rankings, and reduce load times.\r\n\r\nEmbracing AI-powered tools can be a game-changer for your career. These tools can automate repetitive tasks, enhance code quality, improve communication, and optimize website performance. Incorporating AI into your workflow improves productivity and helps you stay on top of the latest technological advancements in the web development industry. So, don\'t hesitate to explore and leverage the power of AI tools to take your skills and portfolio to new heights.','2023-05-16 03:16:46',1,3),(18,'Essential Telegram Channels for Junior Web Developers','As a junior web developer, one of the best ways to stay updated with the latest trends, learn new skills, and connect with fellow developers is through online communities. Telegram, a popular messaging platform, offers a wide range of channels dedicated to web development. In this post, we will explore some of the most useful Telegram channels specifically curated for junior web developers. Whether you\'re seeking coding tips, career advice, or project inspiration, these channels are sure to provide valuable resources and a supportive community.\r\n\r\nWeb Development Channel:\r\nLink: [https://t.me/webdevchannel]\r\nThis channel is an excellent resource for junior web developers as it covers a wide array of topics related to web development. From frontend and backend frameworks to design principles and deployment strategies, you\'ll find discussions, tutorials, articles, and project showcases that can enhance your knowledge and skills.\r\n\r\nCoding Challenges:\r\nLink: []\r\nSharpening your coding skills is essential for growth as a web developer. The LeetCode Discuss channel on Telegram offers regular coding challenges, which are great for improving problem-solving abilities and expanding your programming knowledge. Engaging in these challenges also allows you to compare your solutions with others and learn alternative approaches.\r\n\r\nCareer Development:\r\nLink: []\r\nNavigating the job market and building a successful career as a junior web developer can be daunting. The Career Developers channel on Telegram focuses on career development, providing valuable insights, job postings, interview tips, and resources for honing your professional skills. You can also connect with experienced developers who are willing to share their expertise and guidance.\r\n\r\nUI/UX Design:\r\nLink: []\r\nUnderstanding the principles of user interface (UI) and user experience (UX) design is crucial for creating captivating and user-friendly websites. The UI/UX Inspiration channel on Telegram offers a wealth of resources, articles, and design inspiration to help junior web developers improve their design skills and stay updated with the latest trends in UI/UX.\r\n\r\nOpen Source Projects:\r\nLink: []\r\nContributing to open source projects is an excellent way to gain real-world experience and collaborate with other developers. The Open Source Projects channel on Telegram provides opportunities to join and contribute to various open source projects specifically aimed at junior web developers. You can find projects that suit your interests and skill level, enhancing your practical knowledge and building your portfolio.\r\n\r\nTelegram channels can be valuable sources of information, inspiration, and community for junior web developers. The channels mentioned above cover a wide range of topics, from web development fundamentals to career advice and design principles. By joining these channels, you\'ll have access to a supportive community, learning opportunities, and resources that can accelerate your growth as a web developer. So don\'t hesitate to explore these channels, actively engage in discussions, and make the most of the vast knowledge shared within the Telegram community.','2023-05-17 20:59:57',1,3);
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
  CONSTRAINT `FK_project_skills_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_project_skills_skill_name` FOREIGN KEY (`skill_name`) REFERENCES `skills` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_skills`
--

LOCK TABLES `project_skills` WRITE;
/*!40000 ALTER TABLE `project_skills` DISABLE KEYS */;
INSERT INTO `project_skills` VALUES (7,'.NET 6.0'),(7,'C#'),(8,'HTML'),(8,'Java'),(7,'MSSMS'),(8,'MySQL'),(7,'T-SQL');
/*!40000 ALTER TABLE `project_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `overview` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code_link` varchar(255) NOT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (7,'Hotel Reservation System','The Digital Reservation System is a project aimed at helping businesses manage guest reservations and stays in a more efficient manner. The system allows for creating reservations, searching/viewing reservations, and searching for available rooms. The project was created using MSSMS, C#, N-Tier architecture, and .NET 6.0.','2022-12-11 00:00:00','https://github.com/anastasia-dorfman/Ntier_ReservationSystem','A digital reservation system for managing guest reservations and stays in a more efficient manner'),(8,'Pop-Up Restaurant Reservation System','The Pop-Up Restaurant Reservation System is a sophisticated web application developed using the latest technologies such as Spring Boot, Thymeleaf, Bootstrap, and MySQL. It provides a comprehensive solution for organizing and managing pop-up restaurants, offering a seamless experience for both event organizers and guests. With its user-friendly interface and powerful features, the system ensures efficient reservation processes, accurate seat management, and enhanced event coordination.\r\n\r\nKey Features:\r\n\r\nEvent and Seating Management: Event organizers can effortlessly create events for single or multiple days, specifying the start and end dates. They have the flexibility to define multiple seating times for each event, allowing guests to choose their preferred reservation slots. The system ensures a smooth event scheduling process and provides accurate information on available seatings.\r\n\r\nTable Layout Customization: Organizers can easily customize table layouts, specifying the number of seats available at each table. Each layout can consist of one or more tables, ensuring accurate seat management and seamless association of future reservations with specific tables. The system simplifies the planning and arrangement of seating arrangements, optimizing the guest experience.\r\n\r\nMenu Creation and Selection: To provide guests with complete information, the system allows organizers to specify menus for each event. Organizers can create one or more menus and associate menu items with them. When creating or editing an event, organizers can effortlessly select the appropriate menu, ensuring guests are informed about the food options available during their visit.\r\n\r\nReservation Approval and Denial: Event organizers have the ability to review and manage pending reservation requests. They can approve or deny reservation requests, ensuring accurate tracking of the number of valid reservations for each seating. To approve a reservation, organizers must associate a specific table from the event\'s layout, which guarantees that no other reservation is allocated to the same table for the same event.\r\n\r\nGuest Notifications: The system includes automatic email notifications to keep guests informed about their reservation requests. Upon submitting a reservation request, guests receive an email confirming the receipt of their request, including all the necessary reservation details. Additionally, when the status of a reservation changes (approved or denied), guests receive an email notifying them of the outcome. This feature ensures clear communication and provides guests with peace of mind regarding their reservations.\r\n\r\nSecure User Authentication: To protect sensitive information and ensure authorized access, the system provides a secure login mechanism. Only authenticated users can access the non-public parts of the system, providing a secure environment for both event organizers and guests. User credentials are validated against the stored data in the User entity, and successful login generates a token that is stored in the Login entity. Tokens have expiration times, ensuring session security.\r\n\r\nREST API Integration: Developers can seamlessly integrate event information into their own applications through publicly accessible REST API endpoints. These endpoints provide comprehensive data on events, seatings, menus, and menu items. Developers can retrieve the entire list of events or access specific event information by providing the event ID as a parameter. This feature allows for easy integration and seamless data display in external applications.\r\n\r\nThe Pop-Up Restaurant Reservation System showcases expertise in modern web development technologies, database management, user-centric design, and secure authentication mechanisms. With its attractive and responsive interface built on Bootstrap and Thymeleaf, the system offers an exceptional user experience, promoting engagement and satisfaction.\r\n\r\nWhether you\'re an event organizer, a guest, or a developer seeking seamless integration, the Pop-Up Restaurant Reservation System delivers a reliable, efficient, and user-focused solution. Its clean codebase, well-structured architecture, and REST API capabilities demonstrate a commitment to best practices and future scalability.\r\n\r\nExperience the power of the Pop-Up Restaurant Reservation System, designed to revolutionize the way pop-up restaurants are managed and reservations are made.','2023-04-14 00:00:00','https://github.com/anastasia-dorfman/java-ee-restaurant-project-anastasia_gabriel','Feature-rich web application that streamlines event organization, reservation management, and menu selection for pop-up restaurants, delivering an exceptional user experience');
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
INSERT INTO `skills` VALUES ('.NET 6.0','Framework'),('Angular','Framework'),('ASP.Net MVC 5','Framework'),('Bootstrap','Framework'),('C#','Language'),('CSS','Language'),('Flutter','Language'),('HTML','Language'),('Java','Language'),('JavaScript','Language'),('MSSMS','Database'),('MySQL','Database'),('PHP','Language'),('React','JS Library'),('SQL Server','Database'),('T-SQL','Database'),('Thymeleaf','Template engine'),('TypeScript','Language');
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
  `is_tool` bit(1) DEFAULT b'0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES ('AI',_binary '\0'),('ASP.Net',_binary ''),('Boot Spring',_binary ''),('Bootstrap',_binary ''),('C#',_binary ''),('career',_binary '\0'),('coding',_binary '\0'),('CSS',_binary ''),('Entity Framework',_binary ''),('HTML',_binary ''),('Java',_binary ''),('JavaScript',_binary ''),('jobsearch',_binary '\0'),('Mobile',_binary '\0'),('MySQL',_binary ''),('newtag',_binary '\0'),('PHP',_binary ''),('portfolio',_binary '\0'),('social media',_binary '\0'),('SQL',_binary '\0'),('studentlife',_binary '\0'),('telegram',_binary '\0'),('tips',_binary '\0'),('Web',_binary '\0'),('webdev tools',_binary '\0');
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

-- Dump completed on 2023-05-19 10:19:43