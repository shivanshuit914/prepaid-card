CREATE TABLE `balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(45) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `reference` varchar(45) DEFAULT NULL,
  `merchant_account` varchar(45) DEFAULT NULL,
  `merchant_reference` varchar(45) DEFAULT NULL,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
CREATE TABLE `prepaid_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(45) DEFAULT NULL,
  `issue` varchar(45) DEFAULT NULL,
  `expiry` varchar(45) DEFAULT NULL,
  `security` int(3) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_number_UNIQUE` (`card_number`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
