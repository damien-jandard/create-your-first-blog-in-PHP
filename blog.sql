-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: blog
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `post_id` int NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '2',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comments_users` (`user_id`),
  KEY `FK_comments_posts` (`post_id`),
  CONSTRAINT `FK_comments_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,2,1,'Excellent article sur Symfony ! Clair, précis et instructif. Merci !',1,'2023-05-03 09:09:13'),(2,3,2,'Merci pour cet article concis et informatif sur Symfony. J\'ai maintenant une meilleure compréhension de la structure et des fonctionnalités du framework. Je vais certainement l\'utiliser pour mes projets futurs !',1,'2023-05-09 15:17:15'),(3,3,1,'Superbe article d\'introduction à Symfony! Les explications claires et les exemples pratiques rendent ce framework PHP complexe facile à comprendre pour les débutants. Merci pour ce guide utile et bien écrit!',1,'2023-05-16 17:34:27'),(4,4,1,'Wow, je suis tellement impressionné par ton niveau d\'intelligence ! Je ne savais pas que les trolls pouvaient écrire des articles aussi pathétiques. Continue comme ça, champion, tu es la preuve vivante que l\'évolution a encore des ratés. Bravo !',0,'2023-05-16 14:24:55'),(5,4,3,'Symfony, le compagnon idéal pour les développeurs en herbe !',2,'2023-05-16 15:44:20'),(6,2,4,'OpenClassrooms m\'a permis d\'acquérir de nouvelles compétences de manière pratique et concrète. Les mentors sont incroyablement utiles et le contenu est toujours à jour. Je recommande vivement !',2,'2023-05-26 15:51:26'),(7,3,4,'Je suis impressionné par la variété des cours proposés par OpenClassrooms. J\'ai pu choisir exactement ce dont j\'avais besoin pour progresser dans ma carrière. Les projets pratiques sont un excellent moyen d\'apprendre. Merci OpenClassrooms ',2,'2023-05-26 15:52:35'),(8,4,4,'Je trouve que la plateforme OpenClassrooms manque de diversité dans les cours proposés. J\'aurais aimé voir davantage de programmes axés sur les domaines artistiques et créatifs. Espérons qu\'ils élargissent leur offre à l\'avenir.',2,'2023-05-26 15:52:51');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `chapo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_posts_users` (`user_id`),
  CONSTRAINT `FK_posts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,'Introduction à Symfony : un framework PHP puissant et flexible','Symfony : le choix idéal pour les projets web.','Symfony est un framework PHP développé pour faciliter le processus de création d\'applications web complexes. Il est basé sur une architecture MVC (Modèle-Vue-Contrôleur) et est conçu pour permettre une grande flexibilité dans la création d\'applications web.\r\n\r\nSymfony est utilisé par de nombreuses grandes entreprises pour créer des applications web évolutives et sécurisées. Il est également largement utilisé dans la communauté open source pour la création de projets de toutes tailles.\r\n\r\nLe framework est livré avec une large gamme de composants réutilisables, tels que des composants de sécurité, de base de données et de formulaire, ce qui permet aux développeurs de gagner du temps en évitant de réinventer la roue. Il existe également de nombreuses bibliothèques tierces qui peuvent être intégrées à Symfony pour étendre ses fonctionnalités.\r\n\r\nL\'une des principales caractéristiques de Symfony est son système de bundle. Les bundles sont des modules qui peuvent être ajoutés à une application Symfony pour ajouter des fonctionnalités spécifiques. Ils permettent également de partager facilement des fonctionnalités entre différentes applications Symfony.\r\n\r\nEn termes de performances, Symfony est assez rapide et efficace, en particulier pour les applications web de grande envergure. Le framework est également régulièrement mis à jour pour garantir sa compatibilité avec les dernières versions de PHP.\r\n\r\nEn conclusion, Symfony est un framework PHP flexible et puissant qui offre de nombreuses fonctionnalités et composants utiles pour la création d\'applications web de qualité professionnelle. Si vous êtes un développeur web et que vous cherchez un outil puissant pour créer des applications web évolutives, Symfony est certainement un choix à considérer.','2023-04-26 16:34:53','2023-05-12 15:54:02'),(2,1,'Découvrez les nouvelles fonctionnalités de PHP 8','PHP 8 : nouvelles fonctionnalités et améliorations','PHP est l&#039;un des langages de programmation les plus populaires pour les développeurs web, utilisé pour créer une grande variété d&#039;applications web. PHP 8 est la dernière version majeure de PHP, publiée fin 2020. Cette version apporte de nombreuses améliorations et de nouvelles fonctionnalités qui améliorent la productivité des développeurs.\r\n\r\nL&#039;une des nouvelles fonctionnalités les plus importantes de PHP 8 est l&#039;introduction du JIT (Just-In-Time) pour l&#039;exécution des scripts PHP. Le JIT est une technique d&#039;optimisation qui compile le code PHP en code machine natif à la volée, ce qui permet d&#039;améliorer considérablement les performances des applications.\r\n\r\nEn plus du JIT, PHP 8 comprend également des améliorations importantes dans les types de données, y compris de nouveaux types tels que le &quot;mixed type&quot;, le &quot;union type&quot; et le &quot;nullsafe operator&quot;. Ces nouvelles fonctionnalités permettent aux développeurs de gérer plus facilement les types de données complexes et d&#039;éviter des erreurs potentielles.\r\n\r\nEn outre, PHP 8 apporte également des améliorations dans la gestion des erreurs, de nouvelles fonctionnalités pour les chaînes de caractères, et des améliorations de performance pour les fonctions d&#039;analyse de code.\r\n\r\nCependant, il est important de noter que certaines fonctionnalités de PHP ont été supprimées dans cette version, ce qui peut causer des problèmes de compatibilité avec les anciennes applications. Les développeurs devront donc vérifier leur code pour s&#039;assurer qu&#039;il fonctionne correctement avec PHP 8.\r\n\r\nEn conclusion, PHP 8 apporte de nombreuses améliorations et fonctionnalités qui améliorent considérablement l&#039;expérience de développement pour les développeurs web. Si vous êtes un développeur PHP, il est temps d&#039;explorer les nouvelles fonctionnalités et d&#039;essayer cette dernière version pour améliorer vos projets et applications.','2023-05-09 16:38:41','2023-05-09 16:38:41'),(3,1,'Introduction à la programmation orientée objet en PHP','Les concepts clés de la POO en PHP','La programmation orientée objet (POO) est une méthode de développement de logiciels qui permet de concevoir des applications modulaires et extensibles. Dans la POO, le code est organisé en classes et en objets, qui sont des instances de ces classes. Cette approche permet d&#039;encapsuler les données et le comportement dans des entités cohérentes et de faciliter la réutilisation du code.\r\n\r\nEn PHP, la POO est une fonctionnalité clé du langage depuis sa version 5. La POO en PHP implique l&#039;utilisation de classes, d&#039;objets, d&#039;héritage, de polymorphisme et d&#039;autres concepts de la POO.\r\n\r\nLes classes sont des modèles qui définissent les propriétés et les méthodes qui sont communes à un groupe d&#039;objets. Les objets sont des instances de ces classes, et chaque objet possède des valeurs uniques pour ses propriétés. Les méthodes sont les fonctions qui sont définies dans une classe et qui peuvent être appelées sur un objet pour effectuer des opérations sur les données.\r\n\r\nL&#039;héritage est un concept clé de la POO qui permet de définir une classe enfant qui hérite des propriétés et des méthodes d&#039;une classe parent. Cela permet de créer des classes qui étendent le comportement de classes existantes, sans avoir à réécrire le code commun.\r\n\r\nLe polymorphisme est un autre concept clé de la POO qui permet à des objets de même type d&#039;exposer des comportements différents. Cela permet de traiter les objets de manière générique, en utilisant une interface commune pour interagir avec eux, sans avoir à connaître les détails spécifiques de leur implémentation.\r\n\r\nEn PHP, la syntaxe pour définir une classe est simple. Voici un exemple :\r\n\r\nphp\r\n\r\nclass Voiture {\r\n  // propriétés\r\n  public $marque;\r\n  public $modele;\r\n  \r\n  // méthodes\r\n  public function demarrer() {\r\n    echo &quot;La voiture démarre&quot;;\r\n  }\r\n}\r\n\r\nDans cet exemple, nous définissons une classe Voiture qui a deux propriétés publiques marque et modele et une méthode publique demarrer() qui affiche un message à l&#039;écran.\r\n\r\nPour créer un objet de cette classe, nous utilisons le mot-clé new suivi du nom de la classe :\r\n\r\nphp\r\n\r\n$maVoiture = new Voiture();\r\n\r\nMaintenant que nous avons créé notre objet, nous pouvons accéder à ses propriétés et méthodes :\r\n\r\nphp\r\n\r\n$maVoiture-&gt;marque = &quot;Renault&quot;;\r\n$maVoiture-&gt;modele = &quot;Clio&quot;;\r\n$maVoiture-&gt;demarrer(); // affiche &quot;La voiture démarre&quot;\r\n\r\nEn utilisant la POO en PHP, vous pouvez créer des applications logicielles plus robuste','2023-05-09 16:48:27','2023-05-09 16:48:27'),(4,1,'Découvrez OpenClassrooms : Votre Porte d\'Accès à l\'Apprentissage en Ligne','Une plateforme d\'apprentissage en ligne pour développer vos compétences et réaliser vos projets professionnels','OpenClassrooms est une plateforme d\'apprentissage en ligne qui vous permet d\'accéder à une multitude de cours et de programmes pour développer vos compétences et atteindre vos objectifs professionnels. Que vous soyez étudiant cherchant à enrichir votre parcours éducatif, professionnel souhaitant acquérir de nouvelles compétences ou en reconversion professionnelle à la recherche de nouvelles opportunités, OpenClassrooms offre une expérience d\'apprentissage flexible et accessible.\r\n\r\nL\'un des principaux avantages d\'OpenClassrooms est sa méthode pédagogique axée sur la pratique et les projets concrets. Au lieu de se concentrer uniquement sur des concepts théoriques, les apprenants sont amenés à travailler sur des projets réels simulant des situations rencontrées dans le monde professionnel. Cette approche permet aux étudiants de développer des compétences concrètes et d\'acquérir une expérience pertinente qu\'ils pourront directement appliquer dans leur domaine d\'activité.\r\n\r\nOpenClassrooms propose une grande variété de cours dans des domaines tels que la programmation, la data science, le marketing digital, le développement web, et bien plus encore. Les cours sont conçus par des experts du domaine et sont régulièrement mis à jour pour correspondre aux dernières tendances et aux exigences du marché.\r\n\r\nEn plus de son contenu de qualité, OpenClassrooms met l\'accent sur l\'accompagnement personnalisé de ses étudiants. Chaque apprenant bénéficie d\'un mentor dédié qui les guide, les conseille et les soutient tout au long de leur parcours. Les mentors sont des professionnels expérimentés qui partagent leurs connaissances et leur expertise pour aider les étudiants à réussir.\r\n\r\nAvec OpenClassrooms, vous avez la liberté d\'apprendre à votre propre rythme, de choisir les compétences que vous souhaitez développer et de construire votre parcours d\'apprentissage sur mesure. N\'attendez plus, rejoignez la communauté OpenClassrooms et donnez un nouvel élan à votre carrière !','2023-05-26 15:50:00','2023-05-26 15:50:00');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(32) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@blog.com','$2y$10$05qyJsbNBIzLyC6eua8L8OI2xqu6gAbgBNzru3x99o1GNcM2SGrFK',1,1,'','2023-04-24 15:12:05'),(2,'user@blog.com','$2y$10$2GQzZfY2UozLfTwRmwIWVeVjXLx3t/Re8kjcoKUGzk/rQTs4kaOPm',0,1,'bfeec451d5edcab76f19385f97a61a3e','2023-04-28 15:49:55'),(3,'damien@blog.com','$2y$10$gbd9Vffeln4HCbmDADKNbecBTxmj7HzC26hiiVT8SRYZ6jpIQuS8q',0,1,'59ffeeee9c679a433cc8e8d2349c6e64','2023-05-04 15:31:33'),(4,'troll@blog.com','$2y$10$qw5DZpb/H6/ri6iv0WbqjuESaHzd6mYEyg5e7YFbkHaZNzKD0MvlK',0,1,'7d8407cdda11231019151738ed8ac353','2023-05-04 15:32:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-26 16:09:28
