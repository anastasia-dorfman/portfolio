USE `anastbj9_anastasia_dorfman_portfolio`;
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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (9,'avatar','post16_avatar','./assets/images/post16_avatar.jpeg',16,NULL),(39,'avatar','project7_avatar','./assets/images/project7_avatar.png',NULL,7),(40,'image','project7_image1','./assets/images/project7_image1.png',NULL,7),(43,'image','project8_image1','./assets/images/project8_image1.png',NULL,8),(44,'image','project8_image2','./assets/images/project8_image2.png',NULL,8),(45,'image','project8_image3','./assets/images/project8_image3.png',NULL,8),(47,'image','project9_image1','./assets/images/project9_image1.png',NULL,9),(48,'image','project9_image2','./assets/images/project9_image2.png',NULL,9),(49,'image','project9_image3','./assets/images/project9_image3.png',NULL,9),(51,'image','project10_image1','./assets/images/project10_image1.png',NULL,10),(52,'image','project10_image2','./assets/images/project10_image2.png',NULL,10),(53,'image','project10_image3','./assets/images/project10_image3.png',NULL,10),(55,'avatar','project10_avatar','./assets/images/project10_avatar.png',NULL,10),(59,'avatar','project8_avatar','./assets/images/project8_avatar.png',NULL,8),(60,'avatar','project9_avatar','./assets/images/project9_avatar.png',NULL,9),(61,'avatar','project11_avatar','./assets/images/project11_avatar.png',NULL,11),(62,'image','project11_image1','./assets/images/project11_image1.png',NULL,11),(63,'image','project11_image2','./assets/images/project11_image2.png',NULL,11),(64,'image','project7_image2','./assets/images/project7_image2.png',NULL,7),(65,'image','project7_image3','./assets/images/project7_image3.png',NULL,7),(66,'avatar','post1_avatar','./assets/images/post1_avatar.png',1,NULL),(69,'avatar','post17_avatar','./assets/images/post17_avatar.png',17,NULL),(74,'avatar','post18_avatar','./assets/images/post18_avatar.png',18,NULL);
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
INSERT INTO `post_tags` VALUES (17,'AI'),(18,'career'),(18,'coding'),(1,'CSS'),(1,'HTML'),(1,'PHP'),(18,'social media'),(1,'SQL'),(16,'studentlife'),(18,'telegram'),(1,'tips'),(16,'tips'),(17,'tips'),(18,'tips'),(17,'webdev tools');
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
INSERT INTO `posts` VALUES (1,'Creating a Winning Portfolio Website: Challenges and Technologies for IT Students','As an IT student, I understood the importance of creating a portfolio website to showcase my skills and experience to potential employers. It was important to me to create a website that would differentiate me from other candidates and effectively showcase my technical abilities. However, I encountered some challenges during the creation of my portfolio website. Designing an aesthetically pleasing and user-friendly website was a significant obstacle for me since I had limited experience in web development. Additionally, selecting the right technologies and tools to use was overwhelming, considering the vast array of options available.<br><br>To overcome these challenges, I chose to use <strong>HTML/CSS</strong> as the foundation of my website, with <strong>PHP </strong>as my server-side scripting language. I used <strong>MySQL </strong>to manage the database, which allowed me to handle form submissions and store user information. Although I did not use Bootstrap, I created a responsive and mobile-friendly website using my HTML/CSS skills. Overall, creating a portfolio website is a crucial step for IT students to establish their personal brand and online presence. Despite the challenges, using the right technologies and tools, such as PHP, MySQL, and HTML/CSS, can help you create a successful and impressive website. Remember to keep your website up-to-date with your latest projects and accomplishments to continue building your personal brand and showcasing your technical abilities.','2023-04-19 19:17:36',1,3),(16,'How to Stay Sane as an IT Student: A First-Person Guide to Time Management','Hey there, fellow IT students! Are you feeling overwhelmed with assignments, projects, and deadlines? Are you starting to feel like you\'re living in a perpetual state of stress and exhaustion? Fear not, because I\'ve been there too. But through trial and error (and a lot of coffee), I\'ve learned a few things about managing my time without going completely insane. So, here are my top tips for staying sane as an IT student:\r\n\r\nTip #1: Make Friends with Procrastination\r\n\r\nLet\'s face it, we all procrastinate. It\'s part of human nature, and as an IT student, you\'re probably pretty good at it. So why fight it? Embrace your inner procrastinator, but do it proactively. Set yourself a timer for 30 minutes of mindless scrolling on social media or watching cat videos on YouTube, and then get back to work. You\'ll be surprised at how much more productive you are when you allow yourself a little break from the grind.\r\n\r\nTip #2: Set Priorities and Stick to Them\r\n\r\nAs an IT student, you probably have a never-ending to-do list. But let\'s be honest, not everything on that list is equally important. So, set priorities for yourself and stick to them. Figure out what tasks are urgent, what tasks are important, and what tasks can wait. Then, tackle them in order of priority. And if you don\'t get to everything on your list? That\'s okay. You\'re only human.\r\n\r\nTip #3: Take Breaks (And Don\'t Feel Guilty About It)\r\n\r\nIt\'s easy to fall into the trap of thinking that you have to work non-stop to be successful. But that\'s simply not true. In fact, taking breaks is essential for maintaining your productivity and mental health. So, take a walk, do some yoga, meditate, or just stare out the window for a few minutes. Your brain (and your sanity) will thank you.\r\n\r\nTip #4: Ask for Help When You Need It\r\n\r\nAs IT students, we like to think that we can do everything ourselves. But that\'s simply not possible. Don\'t be afraid to ask your classmates, professors, or even your family and friends for help when you need it. And don\'t forget to offer your own help in return. It\'s amazing how much you can learn (and how much you can accomplish) when you work together.\r\n\r\nIn conclusion, managing your time as an IT student can be tough, but it\'s not impossible. Embrace your inner procrastinator, set priorities, take breaks, and ask for help when you need it. And remember, you\'re not alone in this. We\'re all in the same boat (or rather, the same code editor). So, let\'s support each other, have a few laughs along the way, and stay sane together.','2023-04-27 19:56:14',1,3),(17,'Enhancing Your Web Development Journey: Essential AI Tools for Junior Developers','As a junior web developer, staying ahead of the game and leveraging the power of cutting-edge technologies is crucial to your professional growth. Artificial Intelligence (AI) has emerged as a game-changer in today\'s digital landscape, revolutionizing various industries, including web development. In this post, we will explore a collection of useful AI tools that can empower junior web developers to streamline their workflows, enhance productivity, and deliver exceptional web experiences.<br><br><strong>Code Autocompletion with AI</strong>: One of the most time-consuming tasks for developers is writing code. AI-powered code autocompletion tools like Tabnine, Kite, and DeepCode can significantly accelerate your coding process. By analyzing patterns in your code and providing intelligent suggestions, these tools save you precious time and help you write cleaner and more efficient code.&nbsp; <br><br><strong>Automated Testing and Bug Detection</strong>: Ensuring the quality and reliability of your web applications is paramount. AI-driven testing tools like Testim and Applitools can help junior developers identify bugs, errors, and compatibility issues across browsers and devices. By automating the testing process, these tools free up your time for other critical tasks while maintaining the integrity of your codebase. <br><br><strong> Natural Language Processing (NLP) Assistants</strong>: Communicating effectively with clients, team members, or end-users is crucial in web development. NLP assistants, such as Dialogflow and Wit.ai, leverage AI to understand and respond to natural language input. These tools enable you to build chatbots, voice assistants, and interactive interfaces that enhance user experience and streamline communication channels. <br><br><strong>Image and Content Analysis</strong>: Incorporating AI-powered image and content analysis tools into your web development workflow can offer valuable insights and enhance user engagement. Services like Google Cloud Vision API and IBM Watson Visual Recognition enable you to extract information from images, detect objects, analyze sentiment, and provide personalized content recommendations based on user preferences. <br><br><strong>Performance Optimization</strong>: AI can be vital in optimizing your web applications for speed and performance. Tools like Google\'s PageSpeed Insights and Cloudinary\'s automatic image optimization utilize AI algorithms to analyze and suggest optimizations for your website. <br><br>These recommendations can enhance user experience, boost search engine rankings, and reduce load times. Embracing AI-powered tools can be a game-changer for your career. These tools can automate repetitive tasks, enhance code quality, improve communication, and optimize website performance. Incorporating AI into your workflow improves productivity and helps you stay on top of the latest technological advancements in the web development industry. So, don\'t hesitate to explore and leverage the power of AI tools to take your skills and portfolio to new heights.','2023-05-16 03:16:46',1,3),(18,'Essential Telegram Channels for Junior Web Developers','<p>As a junior web developer, one of the best ways to stay updated with the latest trends, learn new skills, and connect with fellow developers is through online communities. Telegram, a popular messaging platform, offers a wide range of channels dedicated to web development. In this post, we will explore some of the most useful Telegram channels specifically curated for junior web developers. Whether you\'re seeking coding tips, career advice, or project inspiration, these channels are sure to provide valuable resources and a supportive community.<br><br><strong>Web Development Channel</strong>: Link: [https://t.me/webdevchannel]<br>This channel is an excellent resource for junior web developers as it covers a wide array of topics related to web development. From frontend and backend frameworks to design principles and deployment strategies, you\'ll find discussions, tutorials, articles, and project showcases that can enhance your knowledge and skills.&nbsp;<br><br><strong>Coding Challenges</strong>: Link: []<br>Sharpening your coding skills is essential for growth as a web developer. The LeetCode Discuss channel on Telegram offers regular coding challenges, which are great for improving problem-solving abilities and expanding your programming knowledge. Engaging in these challenges also allows you to compare your solutions with others and learn alternative approaches.<br><br><strong>Career Development</strong>: Link: [] <br>Navigating the job market and building a successful career as a junior web developer can be daunting. The Career Developers channel on Telegram focuses on career development, providing valuable insights, job postings, interview tips, and resources for honing your professional skills. You can also connect with experienced developers who are willing to share their expertise and guidance.<br><br><strong>UI/UX Design</strong>: Link: []<br>Understanding the principles of user interface (UI) and user experience (UX) design is crucial for creating captivating and user-friendly websites. The UI/UX Inspiration channel on Telegram offers a wealth of resources, articles, and design inspiration to help junior web developers improve their design skills and stay updated with the latest trends in UI/UX.<br><br><strong>Open Source Projects</strong>: Link: [] <br>Contributing to open source projects is an excellent way to gain real-world experience and collaborate with other developers. The Open Source Projects channel on Telegram provides opportunities to join and contribute to various open source projects specifically aimed at junior web developers. You can find projects that suit your interests and skill level, enhancing your practical knowledge and building your portfolio.<br><br>Telegram channels can be valuable sources of information, inspiration, and community for junior web developers. The channels mentioned above cover a wide range of topics, from web development fundamentals to career advice and design principles. By joining these channels, you\'ll have access to a supportive community, learning opportunities, and resources that can accelerate your growth as a web developer. So don\'t hesitate to explore these channels, actively engage in discussions, and make the most of the vast knowledge shared within the Telegram community.</p>','2023-05-17 20:59:57',1,3);
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
INSERT INTO `project_skills` VALUES (7,'.NET 6.0'),(9,'Bootstrap'),(7,'C#'),(9,'CSS'),(10,'CSS'),(11,'CSS'),(8,'HTML'),(9,'HTML'),(10,'HTML'),(11,'HTML'),(8,'Java'),(11,'JavaScript'),(7,'MSSMS'),(8,'MySQL'),(9,'MySQL'),(10,'MySQL'),(9,'PHP'),(10,'PHP'),(7,'T-SQL'),(8,'Thymeleaf');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (7,'Hotel Reservation System','<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\">The Digital Reservation System is a project aimed at helping businesses manage guest reservations and stays in a more efficient manner. The system allows for creating reservations, searching/viewing reservations, and searching for available rooms. </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\">The project was created using MSSMS, C#, N-Tier architecture, and .NET 6.0.</span></p>','2022-12-11 00:00:00','https://github.com/anastasia-dorfman/Ntier_ReservationSystem','A digital reservation system for managing guest reservations and stays in a more efficient manner'),(8,'Pop-Up Restaurant Reservation System','<p><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\">The Pop-Up Restaurant Reservation System is a sophisticated web application developed using the latest technologies such as Spring Boot, Thymeleaf, Bootstrap, and MySQL. It provides a comprehensive solution for organizing and managing pop-up restaurants, offering a seamless experience for both event organizers and guests. With its user-friendly interface and powerful features, the system ensures efficient reservation processes, accurate seat management, and enhanced event coordination.</span></p>\r\n<p><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>Key Features</strong>:</span></p>\r\n<ol>\r\n<li style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>Event and Seating Management</strong>: Event organizers can effortlessly create events for single or multiple days, specifying the start and end dates. They can define multiple seating times for each event, allowing guests to choose their preferred reservation slots. The system ensures a smooth event scheduling process and provides accurate information on available seatings.</span></li>\r\n<li style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>Table Layout Customization</strong>: Organizers can easily customize table layouts, specifying the seats available at each table. Each layout can consist of one or more tables, ensuring accurate seat management and seamless association of future reservations with specific tables. The system simplifies the planning and arrangement of seating arrangements, optimizing the guest experience.&nbsp;</span></li>\r\n<li style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>Menu Creation and Selection</strong>: The system allows organizers to specify menus for each event to provide guests with complete information. Organizers can create one or more menus and associate menu items with them. When creating or editing an event, organizers can effortlessly select the appropriate menu, ensuring guests are informed about the food options available during their visit.&nbsp;</span></li>\r\n<li style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>Reservation Approval and Denial</strong>: Event organizers can review and manage pending reservation requests. They can approve or deny reservation requests, ensuring accurate tracking of the number of valid reservations for each seating. To approve a reservation, organizers must associate a specific table from the event\'s layout, guaranteeing that no other reservation is allocated to the same table for the same event.</span></li>\r\n<li style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>Guest Notifications</strong>: The system includes automatic email notifications to inform guests about reservation requests. Upon submitting a reservation request, guests receive an email confirming the receipt of their request, including all the necessary reservation details. Additionally, when the status of reservation changes (approved or denied), guests receive an email notifying them of the outcome. This feature ensures clear communication and gives guests peace of mind regarding their reservations.</span></li>\r\n<li style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>Secure User Authentication</strong>: The system provides a secure login mechanism to protect sensitive information and ensure authorized access. Only authenticated users can access the non-public parts of the system, providing a secure environment for both event organizers and guests. User credentials are validated against the stored data in the User entity, and successful login generates a token stored in the Login entity. Tokens have expiration times, ensuring session security.&nbsp;</span></li>\r\n<li style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\"><strong>REST API Integration</strong>: Developers can seamlessly integrate event information into their own applications through publicly accessible REST API endpoints. These endpoints provide comprehensive data on events, seatings, menus, and menu items. Developers can retrieve the entire list of events or access specific event information by providing the event ID as a parameter. This feature allows for easy integration and seamless data display in external applications.</span></li>\r\n</ol>\r\n<p><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\">The Pop-Up Restaurant Reservation System showcases expertise in modern web development technologies, database management, user-centric design, and secure authentication mechanisms. With its attractive and responsive interface built on Bootstrap and Thymeleaf, the system offers an exceptional user experience, promoting engagement and satisfaction.</span></p>\r\n<p><span style=\"color: rgb(149, 165, 166); font-size: 18pt; font-family: tahoma, arial, helvetica, sans-serif;\">&nbsp;Whether you\'re an event organizer, a guest, or a developer seeking seamless integration, the Pop-Up Restaurant Reservation System delivers a reliable, efficient, and user-focused solution. Its clean codebase, well-structured architecture, and REST API capabilities demonstrate a commitment to best practices and future scalability. Experience the power of the Pop-Up Restaurant Reservation System, designed to revolutionize the way pop-up restaurants are managed, and reservations are made.</span></p>','2023-04-14 00:00:00','https://github.com/anastasia-dorfman/java-ee-restaurant-project-anastasia_gabriel','Feature-rich web application that streamlines event organization, reservation management, and menu selection for pop-up restaurants'),(9,'Bitter - A Database-Driven Social Media Website','<p><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Bitter is a dynamic and engaging social media website that allows users to connect, share updates, and interact with each other. Developed using the Bootstrap framework, Spring Boot, Thymeleaf, and MySQL, this project showcases my skills in building a database-driven web application. The project began as a simple static HTML site and gradually evolved into a fully functional social media platform. Key accomplishments in each sprint include:</span></p>\r\n<p><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Sprint #1: </span></p>\r\n<ul style=\"list-style-type: circle;\">\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Created a user registration form with PHP validation and data insertion into the MySQL database. </span></li>\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Implemented user authentication and session management for secure login. Implemented access control to redirect users based on their login status.</span></li>\r\n</ul>\r\n<p><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Sprint #2: </span></p>\r\n<ul style=\"list-style-type: circle;\">\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Developed a recommendation panel suggesting users for the logged-in user to follow. </span></li>\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Created SQL queries to fetch random users, excluding the logged-in user and those already followed. </span></li>\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Implemented the functionality to follow other users.</span></li>\r\n</ul>\r\n<p><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Sprint #3: </span></p>\r\n<ul style=\"list-style-type: circle;\">\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Enhanced user profiles by enabling profile picture upload and editing. </span></li>\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Implemented logic to display user profile pictures, including a default image for users without a profile picture.&nbsp;</span></li>\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Implemented tweet creation and display on the index page, including user information and like/retweet icons.&nbsp;</span></li>\r\n</ul>\r\n<p><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Sprint #4: </span></p>\r\n<ul style=\"list-style-type: circle;\">\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Added the functionality to retweet other users\' tweets. </span></li>\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Implemented the ability to reply to tweets, visually connecting replies with the original tweets.</span></li>\r\n</ul>\r\n<p><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Sprint #5: </span></p>\r\n<ul style=\"list-style-type: circle;\">\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Developed the userpage.php to display detailed information about a specific user, including tweets and retweets associated with them. </span></li>\r\n<li><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Implemented the search feature, allowing users to find other users and tweets based on specific criteria.&nbsp;</span></li>\r\n</ul>\r\n<p><span style=\"font-size: 14pt; color: rgb(126, 140, 141);\">Throughout the project, I have utilized frameworks such as Bootstrap, Spring Boot, and Thymeleaf to enhance the website\'s functionality and design. Additionally, I have demonstrated my proficiency in MySQL for efficient database management. This project serves as a portfolio-worthy example showcasing my skills in developing a database-driven social media website using PHP and MySQL.</span></p>','2023-04-07 00:00:00','https://github.com/anastasia-dorfman/bitter-sprints-starter-files-anastasia-dorfman','A feature-rich social media website developed in PHP, utilizing MySQL for the database, enabling user registration, profile customization, tweet posting, retweeting, replying, and search functionalities.'),(10,'PHP Portfolio Website','<p><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Welcome to my portfolio website! This project showcases my skills in PHP and MySQL, offering an interactive platform for potential employers to explore my work. With a user-friendly interface and comprehensive features, this website demonstrates my web development and database management expertise. </span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\">I created a dedicated database to organize and store the project\'s data effectively. The database structure allows for future flexibility, allowing tables to be added, removed, or updated as needed.&nbsp;</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The website includes user accounts for the admin to enable editing the website\'s content.&nbsp;</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\">You will find a basic HTML layout on the website\'s main page with intuitive navigation. The navigation menu directs you to various sections of the website.</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Throughout the development of the portfolio website, I considered several critical factors in creating an efficient database. The database includes the following essential components:</span></p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><strong>Users</strong>: The user table manages the authentication and access control for the website. It ensures that only authorized individuals can perform CRUD operations. </span></li>\r\n<li><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><strong>Post</strong>: The posts table stores all the blog posts, including their titles, dates, and content. </span></li>\r\n<li><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><strong>Projects</strong>: This table houses examples of my work, allowing potential employers to explore my previous projects. With the ability to add, update, and delete entries, I can keep this section up to date with my latest accomplishments.&nbsp;</span></li>\r\n<li><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><strong>Skillsets</strong>: The skills table categorizes my skill sets, making it easier for employers to identify my areas of expertise. </span></li>\r\n<li><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><strong>Images</strong>: The images table allows for the seamless integration of images in both blog posts and work samples.</span></li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: rgb(126, 140, 141); font-family: arial, helvetica, sans-serif; font-size: 14pt;\">To enhance user experience and facilitate content discovery, I have implemented a search box that enables keyword searches. This feature allows visitors to search for specific topics or keywords across blogs and posts, making it effortless to find relevant information. As for the requirements, the portfolio website offers full CRUD functionality for blog posts, allowing me to create, update, and delete posts as needed.</span></p>','2023-04-14 00:00:00','https://github.com/anastasia-dorfman/portfolio','A dynamic and PHP portfolio website integrated with TinyMCE and MySQL'),(11,'Shared Shopping List','<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\">The Shared Shopping List project is a collaborative web application that simplifies the management of shopping lists by enabling multiple users to connect and update a shared list in real time. Developed using JavaScript and incorporating web sockets, this innovative solution ensures seamless communication between the server and clients, allowing for instant updates and synchronized data across all connected devices.&nbsp;</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\"><strong>Key Features</strong>: </span></p>\r\n<ol>\r\n<li><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\"><span style=\"text-decoration: underline;\">Real-Time Collaboration</span>: The Shared Shopping List facilitates the collaborative creation, updates, and management of a shared shopping list. Any changes made by one user are instantly reflected on the lists of all connected users, ensuring everyone stays up-to-date. </span></li>\r\n<li><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\"><span style=\"text-decoration: underline;\">Web Socket Server</span>: The application relies on a robust web socket server that efficiently handles communication between clients. It manages multiple client connections, ensuring smooth information flow and adherence to all business rules. </span></li>\r\n<li><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\"><span style=\"text-decoration: underline;\">User-Friendly Interface</span>: The client application provides an intuitive graphical user interface (GUI) for seamless interaction with the shopping list. The visually appealing interface enhances the user experience, making list management effortless. </span></li>\r\n<li><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\"><span style=\"text-decoration: underline;\">Server-Side Logic:</span> All application logic is centralized on the server, which enforces business rules and guarantees data integrity. The client\'s responsibility is solely to display functionality and visualize updates, ensuring consistent states across all clients. </span></li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt; color: rgb(126, 140, 141);\">The Shared Shopping List project showcases the power of collaboration and real-time communication in simplifying shared shopping responsibilities. Through its reliable web socket server, intuitive client interface, and synchronized updates, it transforms the way users manage their shopping lists. This project demonstrates proficiency in networking concepts, JavaScript development, and UI design, making it a valuable asset for any developer\'s portfolio.</span></p>','2023-04-13 00:00:00','https://github.com/anastasia-dorfman/nfp-project-nfp_project_gabriel_anastasia','A collaborative web application that enables real-time updates and seamless management of shared shopping lists using JavaScript and web sockets');
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

-- Dump completed on 2023-06-08 11:33:27
