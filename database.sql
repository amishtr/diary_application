/* --- TABLE SCRIPT --- */

CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `userEmail` text NOT NULL,
 `userPassword` text NOT NULL,
 `salt` varchar(255) DEFAULT NULL,
 `userName` text NOT NULL,
 `userStory` varchar(10000) DEFAULT NULL,
 `createdDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='User table'

