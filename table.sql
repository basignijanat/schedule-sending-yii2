CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `descriptive_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,  
  `position_description` varchar(255) NOT NULL,
  `salary` int(11) NOT NULL,
  `start_at` int(11) NOT NULL,
  `end_at` int(11) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `contact_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,  
  `contact_name` varchar(255) NOT NULL,  
  `contact_email` varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `post_in_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,  
  `place_at` int(11) NOT NULL,  
  `notification_email_at` int(11) NOT NULL,
  PRIMARY KEY (id)
);