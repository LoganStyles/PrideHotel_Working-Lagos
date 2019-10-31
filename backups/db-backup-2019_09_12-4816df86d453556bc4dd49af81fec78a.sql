DROP TABLE IF EXISTS account_classitems;

CREATE TABLE `account_classitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `signature_created` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'account_class',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO account_classitems VALUES("1","DRINK","DRINKS","MAZ","account_class","0000-00-00 00:00:00","2017-08-02 20:19:28");
INSERT INTO account_classitems VALUES("2","FOOD","FOOD","MAZ","account_class","0000-00-00 00:00:00","2017-05-03 21:42:43");
INSERT INTO account_classitems VALUES("3","HALL","HALL","MAZ","account_class","2015-10-09 00:00:00","2017-04-28 20:27:08");
INSERT INTO account_classitems VALUES("4","LAUND","LAUNDRY","MAZ","account_class","2015-11-04 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_classitems VALUES("5","OTHER","OTHERS","","account_class","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_classitems VALUES("6","ROOM","ROOM","JBA","account_class","2015-10-09 00:00:00","2017-03-10 18:07:13");



DROP TABLE IF EXISTS account_discountitems;

CREATE TABLE `account_discountitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'account_discount',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO account_discountitems VALUES("1","ROOM","ROOM","account_discount","JBA","0000-00-00 00:00:00","2017-03-10 17:49:03");
INSERT INTO account_discountitems VALUES("2","HALL","HALL","account_discount","MAZ","0000-00-00 00:00:00","2017-05-03 21:43:26");
INSERT INTO account_discountitems VALUES("3","RESTAURANT","","account_discount","","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_discountitems VALUES("4","DRINKS","","account_discount","","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_discountitems VALUES("5","LAUNDRY","","account_discount","","0000-00-00 00:00:00","0000-00-00 00:00:00");



DROP TABLE IF EXISTS account_paymentitems;

CREATE TABLE `account_paymentitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text,
  `alias` varchar(255) DEFAULT NULL,
  `accounttype` tinyint(3) NOT NULL,
  `debit_credit` enum('debit','credit') NOT NULL DEFAULT 'debit',
  `cash_declaration` enum('no','yes') NOT NULL DEFAULT 'no',
  `accountclass` tinyint(3) NOT NULL,
  `enable` enum('no','yes') NOT NULL DEFAULT 'yes',
  `type` varchar(255) NOT NULL DEFAULT 'account_payment',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `payment_index` (`code`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO account_paymentitems VALUES("1","CASH2","1010","CASH PAYMENT","CASH PAYMENT","5","credit","no","2","yes","account_payment","MAZ","2015-10-10 00:00:00","2017-05-03 16:50:24");
INSERT INTO account_paymentitems VALUES("2","CHQ","1020","CHEQUE PAYMENT","","1","credit","no","2","yes","account_payment","MAZ","2015-10-10 00:00:00","2017-05-05 07:11:44");
INSERT INTO account_paymentitems VALUES("3","DRCD","1040","DEBIT CARD PAYMENT3","","1","credit","no","5","yes","account_payment","MAZ","2015-12-08 00:00:00","2017-05-03 16:51:59");
INSERT INTO account_paymentitems VALUES("4","CRCD","1050","CREDIT CARD PAYMENT","","5","credit","no","5","yes","account_payment","MAZ","2015-10-10 00:00:00","2017-05-03 16:52:58");
INSERT INTO account_paymentitems VALUES("5","REFUN","1060","CASH REFUND","CASH REFUND","5","credit","no","6","yes","account_payment","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_paymentitems VALUES("6","COMP","1090","COMPLIMENTARY","","1","credit","no","5","yes","account_payment","MAZ","2015-10-10 00:00:00","2017-05-03 16:54:53");
INSERT INTO account_paymentitems VALUES("7","CLEDG","4000","CITY LEDGER","","16","credit","no","5","yes","account_payment","MAZ","2015-10-10 00:00:00","2017-05-03 16:55:29");
INSERT INTO account_paymentitems VALUES("8","GLEDG","4010","GUEST LEDGER","","8","debit","no","5","yes","account_payment","MAZ","2015-12-08 00:00:00","2017-05-03 16:55:54");
INSERT INTO account_paymentitems VALUES("9","POSCH","1015","POS PAYMENT","","5","credit","no","5","yes","account_payment","MAZ","2016-01-01 00:00:00","2017-05-03 16:56:31");



DROP TABLE IF EXISTS account_plu_groupitems;

CREATE TABLE `account_plu_groupitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `signature_created` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'account_plu_group',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `type` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO account_plu_groupitems VALUES("1","BF","BREAKFAST (100 - 200)","","account_plu_group","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("2","CONFR","HALLS & CONFERENCES (701 - 705","MAZ","account_plu_group","2015-11-28 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("3","DINNE","DINNER (301 - 400)","JBA","account_plu_group","2015-12-27 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("4","DRINK","DRINK","JBA","account_plu_group","2016-01-01 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("5","HALLS","HALL CHARGES","JBA","account_plu_group","2016-01-01 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("6","LAUND","LAUNDRY","JBA","account_plu_group","2016-01-01 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("10","FOOD","FOOD","JBA","account_plu_group","2016-01-01 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("11","REST","RESTAURANT","JBA","account_plu_group","2016-11-22 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_plu_groupitems VALUES("12","ROOM","STANDARD","JBA","account_plu_group","2017-09-11 06:26:00","2017-09-11 06:26:41");



DROP TABLE IF EXISTS account_plu_numberitems;

CREATE TABLE `account_plu_numberitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `plu_group` tinyint(3) NOT NULL,
  `acctsale` tinyint(3) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(255) NOT NULL DEFAULT 'account_plu_number',
  `enable` enum('no','yes') NOT NULL DEFAULT 'no',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO account_plu_numberitems VALUES("1","100","10","13","FOOD","0.00","0.00","account_plu_number","yes","MAZ","2016-01-01 00:00:00","2017-02-16 15:55:31");
INSERT INTO account_plu_numberitems VALUES("2","101","4","14","DRINK","0.00","0.00","account_plu_number","yes","MAZ","2016-01-01 00:00:00","2017-02-16 15:56:57");
INSERT INTO account_plu_numberitems VALUES("3","407","5","9","HALL","0.00","0.00","account_plu_number","yes","MAZ","2016-01-01 00:00:00","2017-02-16 15:57:38");
INSERT INTO account_plu_numberitems VALUES("7","200","6","15","LAUNDRY","0.00","0.00","account_plu_number","yes","MAZ","2016-01-01 00:00:00","2017-02-16 15:58:09");
INSERT INTO account_plu_numberitems VALUES("8","1001","11","10","RESTAURANT","0.00","0.00","account_plu_number","yes","MAZ","2016-11-22 00:00:00","2017-02-16 15:59:08");
INSERT INTO account_plu_numberitems VALUES("9","300","12","5","STANDARD ROOM","0.00","0.00","account_plu_number","yes","JBA","2017-09-11 06:27:35","0000-00-00 00:00:00");



DROP TABLE IF EXISTS account_saleitems;

CREATE TABLE `account_saleitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `alias` varchar(255) DEFAULT NULL,
  `accounttype` tinyint(3) NOT NULL,
  `accountclass` tinyint(3) NOT NULL,
  `debit_credit` enum('debit','credit') NOT NULL DEFAULT 'debit',
  `vattype` enum('excl','incl') NOT NULL DEFAULT 'excl',
  `vatpercent` decimal(10,2) DEFAULT '0.00',
  `salescategory` tinyint(3) NOT NULL,
  `discountcategory` tinyint(3) NOT NULL,
  `default_price` decimal(10,2) DEFAULT '0.00',
  `service_charge` enum('no','yes') NOT NULL DEFAULT 'no',
  `enable` enum('no','yes') NOT NULL DEFAULT 'yes',
  `type` varchar(255) NOT NULL DEFAULT 'account_sale',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name_title` (`code`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

INSERT INTO account_saleitems VALUES("1","1216","GLEDG","GUEST LEDGER","","8","1","credit","excl","0.00","1","1","0.00","no","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:28:35");
INSERT INTO account_saleitems VALUES("2","2400","IVAT","IN VAT","","7","2","credit","excl","5.00","4","3","10.00","no","yes","account_sale","JBA","2015-10-10 00:00:00","2017-03-11 15:24:08");
INSERT INTO account_saleitems VALUES("3","2410","OVAT","OUT VAT","","6","5","debit","excl","0.00","5","1","0.00","no","yes","account_sale","MAZ","2015-12-08 00:00:00","2017-05-03 16:38:30");
INSERT INTO account_saleitems VALUES("4","2420","SC","SERVICE CHARGE","","15","5","debit","excl","0.00","5","0","10.00","yes","yes","account_sale","MAZ","2015-12-08 00:00:00","2019-09-07 18:05:58");
INSERT INTO account_saleitems VALUES("5","3010","STANDARD","STANDARD ROOM","STANDARD ROOM","2","6","debit","excl","5.00","1","1","0.00","no","yes","account_sale","MAZ","2015-12-08 00:00:00","2019-08-31 21:51:08");
INSERT INTO account_saleitems VALUES("9","3060","HALL","HALLS","","1","3","debit","incl","5.00","2","2","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:39:21");
INSERT INTO account_saleitems VALUES("10","3110","REST","BREAKFAST","","1","2","debit","incl","5.00","4","3","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:39:47");
INSERT INTO account_saleitems VALUES("11","3120","LUNCH","LUNCH","","1","2","debit","incl","5.00","2","3","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:40:16");
INSERT INTO account_saleitems VALUES("12","3130","DINN","DINNER","","1","2","debit","incl","5.00","2","3","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:40:38");
INSERT INTO account_saleitems VALUES("13","3140","POS1","FOOD","","1","2","debit","incl","5.00","4","3","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:41:03");
INSERT INTO account_saleitems VALUES("14","3145","POS2","DRINKS","","1","1","debit","incl","5.00","3","4","0.00","yes","yes","account_sale","MAZ","2015-12-08 00:00:00","2017-05-03 16:41:32");
INSERT INTO account_saleitems VALUES("15","3150","LAUND","LAUNDRY","","1","4","debit","incl","5.00","5","5","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:41:54");
INSERT INTO account_saleitems VALUES("16","3160","TEL","TELEPHONE","TEL","21","0","debit","incl","5.00","1","5","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:42:31");
INSERT INTO account_saleitems VALUES("17","3170","DELUXE","DELUXE ROOM","DELUXE ROOM","2","6","debit","excl","5.00","1","1","0.00","no","yes","account_sale","MAZ","2015-10-10 00:00:00","2019-08-31 21:50:50");
INSERT INTO account_saleitems VALUES("18","3190","SALES","OTHER SALES","","1","5","debit","incl","5.00","5","1","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:43:48");
INSERT INTO account_saleitems VALUES("19","3310","DISRM","DISCOUNT ON ROOM","","25","6","credit","incl","5.00","1","1","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:44:22");
INSERT INTO account_saleitems VALUES("20","3320","DISHL","DISCOUNT ON HALL","","25","3","credit","incl","5.00","2","2","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:44:53");
INSERT INTO account_saleitems VALUES("21","7155","COMM","AGENCY  COMMISSION","","9","2","credit","incl","5.00","5","1","0.00","yes","yes","account_sale","MAZ","2015-10-10 00:00:00","2017-05-03 16:45:21");
INSERT INTO account_saleitems VALUES("22","2430","IVAT2","IN VAT2 DIFFERENT","","7","5","credit","excl","0.00","5","1","0.00","no","yes","account_sale","MAZ","2015-12-19 00:00:00","2017-05-03 16:45:52");
INSERT INTO account_saleitems VALUES("23","3180","SDELUXE","SUPER DELUXE","SUPER DELUXE","2","6","debit","incl","5.00","1","1","0.00","no","yes","account_sale","JBA","2018-09-28 16:53:17","2018-11-27 18:32:39");
INSERT INTO account_saleitems VALUES("24","3020","DIPLOMAT","DIPLOMATIC ROOM","DIPLOMATIC ROOM","2","6","debit","incl","5.00","1","1","0.00","no","yes","account_sale","JBA","2018-09-28 16:54:45","2018-11-27 17:20:21");



DROP TABLE IF EXISTS account_salescategoryitems;

CREATE TABLE `account_salescategoryitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'account_salescategory',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO account_salescategoryitems VALUES("1","ROOM","ROOM","account_salescategory","MAZ","0000-00-00 00:00:00","2017-04-28 19:43:46");
INSERT INTO account_salescategoryitems VALUES("2","HALL","","account_salescategory","JBA","0000-00-00 00:00:00","2017-03-10 18:44:47");
INSERT INTO account_salescategoryitems VALUES("3","DRINKS","","account_salescategory","","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_salescategoryitems VALUES("4","FOOD","","account_salescategory","","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_salescategoryitems VALUES("5","OTHERS","","account_salescategory","","0000-00-00 00:00:00","0000-00-00 00:00:00");



DROP TABLE IF EXISTS account_typeitems;

CREATE TABLE `account_typeitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'account_type',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

INSERT INTO account_typeitems VALUES("1","STANDARD","STANDARD","account_type","JBA","2015-10-06 00:00:00","2017-03-10 17:31:15");
INSERT INTO account_typeitems VALUES("2","ROOM","","account_type","OLA","2015-10-07 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("3","BOARD","BOARD","account_type","JBA","2015-10-07 00:00:00","2017-03-10 17:31:40");
INSERT INTO account_typeitems VALUES("4","N/A","","account_type","OLA","2015-09-04 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("5","CASH","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("6","VAT OUT","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("7","VAT IN","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("8","GUEST LEDGER","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("9","COMMISSION","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("10","INVOICE CLOSING","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("11","FUNCTION ROOM","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("12","INVOICE FEE","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("13","ROUNDING","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("14","NIGHT TAX","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("15","SERVICE CHARGE","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("16","CITY LEDGER","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("17","DEPOSIT LEDGER","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("18","DEPOSIT REFUND","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("19","DEPOSIT PROFIT","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("20","REMOTE PAYMENT","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("21","TELEPHONE","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("22","CANCELLATION FEE","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("23","hPOS SERVICE CHARGE","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("24","hPOS MOVE","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("25","DISCOUNT","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("26","INTER HOTEL LEDGER","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("27","INTER HOTEL SALES","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("28","VOUCHER LEDGER","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("29","VOUCHER PAYMENT","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("30","VOUCHER REFUND","","account_type","OLA","2015-10-10 00:00:00","0000-00-00 00:00:00");
INSERT INTO account_typeitems VALUES("31","VOUCHER PROFIT","VOCHER","account_type","JBA","2015-10-10 00:00:00","2017-03-10 17:34:44");



DROP TABLE IF EXISTS limits;

CREATE TABLE `limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS logitems;

CREATE TABLE `logitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `description` text,
  `old_value` text,
  `new_value` text,
  `reason` text,
  `type` varchar(255) NOT NULL DEFAULT 'log',
  `signature_created` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='logs of sensitive activities';

INSERT INTO logitems VALUES("1","reservation","delete","Reservation 000000000002 was deleted by MAZ","confirmed","cancelled","yes","log","MAZ","2019-08-28 08:40:35");
INSERT INTO logitems VALUES("2","reservation","delete","Reservation 000000000004 was deleted by MAZ","confirmed","cancelled","to test 0000000004 delete","log","MAZ","2019-08-28 01:42:55");
INSERT INTO logitems VALUES("3","reservation","delete","Reservation 000000000001 was deleted by MAZ","staying","cancelled","TESTING ANOTHER DELETE","log","MAZ","2019-08-28 14:21:08");



DROP TABLE IF EXISTS maintenance;

CREATE TABLE `maintenance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `last_rooms_charge` datetime NOT NULL,
  `last_close_account` datetime NOT NULL,
  `charged_rooms_count` int(11) NOT NULL,
  `allow_pos` enum('0','1') NOT NULL DEFAULT '0',
  `license_key` varchar(50) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `install_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO maintenance VALUES("1","2019-09-12 23:31:41","2019-09-12 23:31:41","2","0","sha256:1000:Y2To7NU0srktPJv7kXOvhTaexvNb763E:NcizR","1","2018-11-28 00:00:00","2020-08-31 00:00:00");



DROP TABLE IF EXISTS personitems;

CREATE TABLE `personitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sex` enum('m','f') NOT NULL DEFAULT 'm',
  `title_ref` varchar(255) DEFAULT NULL,
  `passport_no` varchar(255) DEFAULT NULL,
  `pp_issued_at` varchar(255) DEFAULT NULL,
  `pp_issued_date` date DEFAULT '0000-00-00',
  `pp_expiry_date` date DEFAULT '0000-00-00',
  `visa` varchar(255) DEFAULT NULL,
  `resident_permit_no` varchar(255) DEFAULT NULL,
  `spg_no` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT '0000-00-00',
  `birth_location` varchar(255) DEFAULT NULL,
  `reservation_id` varchar(255) DEFAULT NULL,
  `remarks` text,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `signature_created` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'person',
  `destination` varchar(255) DEFAULT NULL,
  `payment_method` enum('coy','cash','pos','cheque','others') NOT NULL DEFAULT 'cash',
  `group_name` varchar(255) DEFAULT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO personitems VALUES("1","Mr. Ibrahim","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2018-09-29 11:20:48","0000-00-00 00:00:00","ACC","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("2","mark","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 02:14:21","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("3","solomon gundi","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 04:32:34","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("4","jackobo","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 16:45:38","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("5","silvia","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 05:27:28","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("6","adam lallana","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 21:27:40","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("7","collins brad","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 15:01:42","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("8","ola","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 15:02:20","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("9","obi","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 19:44:53","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("10","bullus mark","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-28 22:31:11","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("11","solomon","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-29 21:17:41","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("12","hope","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-30 17:06:40","0000-00-00 00:00:00","750","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("13","sam","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-30 18:28:08","0000-00-00 00:00:00","750","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("14","donald","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-08-30 18:38:54","0000-00-00 00:00:00","750","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("15","vincent","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-09-05 09:28:09","0000-00-00 00:00:00","750","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("16","takon","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-09-09 09:08:29","0000-00-00 00:00:00","MAZ","","","","","","","person","","cash","","");
INSERT INTO personitems VALUES("17","sandra","m","mr.","","","1970-01-01","1970-01-01","","","","","1970-01-01","","","","2019-09-10 10:00:56","0000-00-00 00:00:00","750","","","","","","","person","","cash","","");



DROP TABLE IF EXISTS priceitems;

CREATE TABLE `priceitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinyint(3) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'price',
  `acctsale` tinyint(3) NOT NULL,
  `comp_nights` tinyint(3) NOT NULL,
  `comp_visits` enum('no','yes') NOT NULL DEFAULT 'no',
  `enable` enum('no','yes') NOT NULL DEFAULT 'no',
  `adults` tinyint(3) NOT NULL,
  `children` tinyint(3) NOT NULL,
  `special` tinyint(3) NOT NULL,
  `weekday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weekend` decimal(10,2) NOT NULL DEFAULT '0.00',
  `holiday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO priceitems VALUES("1","6","STANDARD ROOM","price","5","0","no","yes","1","0","0","15000.00","15000.00","15000.00","JBA","2018-09-28 17:48:11","2018-11-27 17:33:36");
INSERT INTO priceitems VALUES("2","9","DIPLOMATIC ROOM","price","24","0","no","yes","0","0","0","30000.00","30000.00","30000.00","JBA","2018-09-28 17:49:00","2018-11-27 17:40:54");
INSERT INTO priceitems VALUES("3","7","DELUXE ROOM","price","17","0","no","yes","1","0","0","20000.00","20000.00","20000.00","JBA","2018-09-28 17:49:44","2018-11-27 17:43:01");
INSERT INTO priceitems VALUES("4","8","SUPER DELUXE","price","23","0","no","yes","1","0","0","25000.00","25000.00","25000.00","JBA","2018-09-28 17:50:21","2018-11-27 17:44:50");



DROP TABLE IF EXISTS ref_countryitems;

CREATE TABLE `ref_countryitems` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=latin1;

INSERT INTO ref_countryitems VALUES("1","Afghanistan");
INSERT INTO ref_countryitems VALUES("2","Akrotiri");
INSERT INTO ref_countryitems VALUES("3","Albania");
INSERT INTO ref_countryitems VALUES("4","Algeria");
INSERT INTO ref_countryitems VALUES("5","American Samoa");
INSERT INTO ref_countryitems VALUES("6","Andorra");
INSERT INTO ref_countryitems VALUES("7","Angola");
INSERT INTO ref_countryitems VALUES("8","Anguilla");
INSERT INTO ref_countryitems VALUES("9","Antarctica");
INSERT INTO ref_countryitems VALUES("10","Antigua and Barbuda");
INSERT INTO ref_countryitems VALUES("11","Argentina");
INSERT INTO ref_countryitems VALUES("12","Armenia");
INSERT INTO ref_countryitems VALUES("13","Aruba");
INSERT INTO ref_countryitems VALUES("14","Ashmore and Cartier ");
INSERT INTO ref_countryitems VALUES("15","Australia");
INSERT INTO ref_countryitems VALUES("16","Austria");
INSERT INTO ref_countryitems VALUES("17","Azerbaijan");
INSERT INTO ref_countryitems VALUES("18","Bahamas, The");
INSERT INTO ref_countryitems VALUES("19","Bahrain");
INSERT INTO ref_countryitems VALUES("20","Bangladesh");
INSERT INTO ref_countryitems VALUES("21","Barbados");
INSERT INTO ref_countryitems VALUES("22","Bassas da India");
INSERT INTO ref_countryitems VALUES("23","Belarus");
INSERT INTO ref_countryitems VALUES("24","Belgium");
INSERT INTO ref_countryitems VALUES("25","Belize");
INSERT INTO ref_countryitems VALUES("26","Benin");
INSERT INTO ref_countryitems VALUES("27","Bermuda");
INSERT INTO ref_countryitems VALUES("28","Bhutan");
INSERT INTO ref_countryitems VALUES("29","Bolivia");
INSERT INTO ref_countryitems VALUES("30","Bosnia and Herzegovi");
INSERT INTO ref_countryitems VALUES("31","Botswana");
INSERT INTO ref_countryitems VALUES("32","Bouvet Island");
INSERT INTO ref_countryitems VALUES("33","Brazil");
INSERT INTO ref_countryitems VALUES("34","British Indian Ocean");
INSERT INTO ref_countryitems VALUES("35","British Virgin Islan");
INSERT INTO ref_countryitems VALUES("36","Brunei");
INSERT INTO ref_countryitems VALUES("37","Bulgaria");
INSERT INTO ref_countryitems VALUES("38","Burkina Faso");
INSERT INTO ref_countryitems VALUES("39","Burma");
INSERT INTO ref_countryitems VALUES("40","Burundi");
INSERT INTO ref_countryitems VALUES("41","Cambodia");
INSERT INTO ref_countryitems VALUES("42","Cameroon");
INSERT INTO ref_countryitems VALUES("43","Canada");
INSERT INTO ref_countryitems VALUES("44","Cape Verde");
INSERT INTO ref_countryitems VALUES("45","Cayman Islands");
INSERT INTO ref_countryitems VALUES("46","Central African Repu");
INSERT INTO ref_countryitems VALUES("47","Chad");
INSERT INTO ref_countryitems VALUES("48","Chile");
INSERT INTO ref_countryitems VALUES("49","China");
INSERT INTO ref_countryitems VALUES("50","Christmas Island");
INSERT INTO ref_countryitems VALUES("51","Clipperton Island");
INSERT INTO ref_countryitems VALUES("52","Cocos (Keeling) Isla");
INSERT INTO ref_countryitems VALUES("53","Colombia");
INSERT INTO ref_countryitems VALUES("54","Comoros");
INSERT INTO ref_countryitems VALUES("55","Congo, Democratic Re");
INSERT INTO ref_countryitems VALUES("56","Congo, Republic of t");
INSERT INTO ref_countryitems VALUES("57","Cook Islands");
INSERT INTO ref_countryitems VALUES("58","Coral Sea Islands");
INSERT INTO ref_countryitems VALUES("59","Costa Rica");
INSERT INTO ref_countryitems VALUES("60","Cote d&singlequot;Iv");
INSERT INTO ref_countryitems VALUES("61","Croatia");
INSERT INTO ref_countryitems VALUES("62","Cuba");
INSERT INTO ref_countryitems VALUES("63","Cyprus");
INSERT INTO ref_countryitems VALUES("64","Czech Republic");
INSERT INTO ref_countryitems VALUES("65","Denmark");
INSERT INTO ref_countryitems VALUES("66","Dhekelia");
INSERT INTO ref_countryitems VALUES("67","Djibouti");
INSERT INTO ref_countryitems VALUES("68","Dominica");
INSERT INTO ref_countryitems VALUES("69","Dominican Republic");
INSERT INTO ref_countryitems VALUES("70","Ecuador");
INSERT INTO ref_countryitems VALUES("71","Egypt");
INSERT INTO ref_countryitems VALUES("72","El Salvador");
INSERT INTO ref_countryitems VALUES("73","Equatorial Guinea");
INSERT INTO ref_countryitems VALUES("74","Eritrea");
INSERT INTO ref_countryitems VALUES("75","Estonia");
INSERT INTO ref_countryitems VALUES("76","Ethiopia");
INSERT INTO ref_countryitems VALUES("77","Europa Island");
INSERT INTO ref_countryitems VALUES("78","Falkland Islands (Is");
INSERT INTO ref_countryitems VALUES("79","Faroe Islands");
INSERT INTO ref_countryitems VALUES("80","Fiji");
INSERT INTO ref_countryitems VALUES("81","Finland");
INSERT INTO ref_countryitems VALUES("82","France");
INSERT INTO ref_countryitems VALUES("83","French Guiana");
INSERT INTO ref_countryitems VALUES("84","French Polynesia");
INSERT INTO ref_countryitems VALUES("85","French Southern and ");
INSERT INTO ref_countryitems VALUES("86","Gabon");
INSERT INTO ref_countryitems VALUES("87","Gambia, The");
INSERT INTO ref_countryitems VALUES("88","Gaza Strip");
INSERT INTO ref_countryitems VALUES("89","Georgia");
INSERT INTO ref_countryitems VALUES("90","Germany");
INSERT INTO ref_countryitems VALUES("91","Ghana");
INSERT INTO ref_countryitems VALUES("92","Gibraltar");
INSERT INTO ref_countryitems VALUES("93","Glorioso Islands");
INSERT INTO ref_countryitems VALUES("94","Greece");
INSERT INTO ref_countryitems VALUES("95","Greenland");
INSERT INTO ref_countryitems VALUES("96","Grenada");
INSERT INTO ref_countryitems VALUES("97","Guadeloupe");
INSERT INTO ref_countryitems VALUES("98","Guam");
INSERT INTO ref_countryitems VALUES("99","Guatemala");
INSERT INTO ref_countryitems VALUES("100","Guernsey");
INSERT INTO ref_countryitems VALUES("101","Guinea");
INSERT INTO ref_countryitems VALUES("102","Guinea-Bissau");
INSERT INTO ref_countryitems VALUES("103","Guyana");
INSERT INTO ref_countryitems VALUES("104","Haiti");
INSERT INTO ref_countryitems VALUES("105","Heard Island and McD");
INSERT INTO ref_countryitems VALUES("106","Holy See (Vatican Ci");
INSERT INTO ref_countryitems VALUES("107","Honduras");
INSERT INTO ref_countryitems VALUES("108","Hong Kong");
INSERT INTO ref_countryitems VALUES("109","Hungary");
INSERT INTO ref_countryitems VALUES("110","Iceland");
INSERT INTO ref_countryitems VALUES("111","India");
INSERT INTO ref_countryitems VALUES("112","Indonesia");
INSERT INTO ref_countryitems VALUES("113","Iran");
INSERT INTO ref_countryitems VALUES("114","Iraq");
INSERT INTO ref_countryitems VALUES("115","Ireland");
INSERT INTO ref_countryitems VALUES("116","Isle of Man");
INSERT INTO ref_countryitems VALUES("117","Israel");
INSERT INTO ref_countryitems VALUES("118","Italy");
INSERT INTO ref_countryitems VALUES("119","Jamaica");
INSERT INTO ref_countryitems VALUES("120","Jan Mayen");
INSERT INTO ref_countryitems VALUES("121","Japan");
INSERT INTO ref_countryitems VALUES("122","Jersey");
INSERT INTO ref_countryitems VALUES("123","Jordan");
INSERT INTO ref_countryitems VALUES("124","Juan de Nova Island");
INSERT INTO ref_countryitems VALUES("125","Kazakhstan");
INSERT INTO ref_countryitems VALUES("126","Kenya");
INSERT INTO ref_countryitems VALUES("127","Kiribati");
INSERT INTO ref_countryitems VALUES("128","Korea, North");
INSERT INTO ref_countryitems VALUES("129","Korea, South");
INSERT INTO ref_countryitems VALUES("130","Kuwait");
INSERT INTO ref_countryitems VALUES("131","Kyrgyzstan");
INSERT INTO ref_countryitems VALUES("132","Laos");
INSERT INTO ref_countryitems VALUES("133","Latvia");
INSERT INTO ref_countryitems VALUES("134","Lebanon");
INSERT INTO ref_countryitems VALUES("135","Lesotho");
INSERT INTO ref_countryitems VALUES("136","Liberia");
INSERT INTO ref_countryitems VALUES("137","Libya");
INSERT INTO ref_countryitems VALUES("138","Liechtenstein");
INSERT INTO ref_countryitems VALUES("139","Lithuania");
INSERT INTO ref_countryitems VALUES("140","Luxembourg");
INSERT INTO ref_countryitems VALUES("141","Macau");
INSERT INTO ref_countryitems VALUES("142","Macedonia");
INSERT INTO ref_countryitems VALUES("143","Madagascar");
INSERT INTO ref_countryitems VALUES("144","Malawi");
INSERT INTO ref_countryitems VALUES("145","Malaysia");
INSERT INTO ref_countryitems VALUES("146","Maldives");
INSERT INTO ref_countryitems VALUES("147","Mali");
INSERT INTO ref_countryitems VALUES("148","Malta");
INSERT INTO ref_countryitems VALUES("149","Marshall Islands");
INSERT INTO ref_countryitems VALUES("150","Martinique");
INSERT INTO ref_countryitems VALUES("151","Mauritania");
INSERT INTO ref_countryitems VALUES("152","Mauritius");
INSERT INTO ref_countryitems VALUES("153","Mayotte");
INSERT INTO ref_countryitems VALUES("154","Mexico");
INSERT INTO ref_countryitems VALUES("155","Micronesia, Federate");
INSERT INTO ref_countryitems VALUES("156","Moldova");
INSERT INTO ref_countryitems VALUES("157","Monaco");
INSERT INTO ref_countryitems VALUES("158","Mongolia");
INSERT INTO ref_countryitems VALUES("159","Montserrat");
INSERT INTO ref_countryitems VALUES("160","Morocco");
INSERT INTO ref_countryitems VALUES("161","Mozambique");
INSERT INTO ref_countryitems VALUES("162","Namibia");
INSERT INTO ref_countryitems VALUES("163","Nauru");
INSERT INTO ref_countryitems VALUES("164","Navassa Island");
INSERT INTO ref_countryitems VALUES("165","Nepal");
INSERT INTO ref_countryitems VALUES("166","Netherlands");
INSERT INTO ref_countryitems VALUES("167","Netherlands Antilles");
INSERT INTO ref_countryitems VALUES("168","New Caledonia");
INSERT INTO ref_countryitems VALUES("169","New Zealand");
INSERT INTO ref_countryitems VALUES("170","Nicaragua");
INSERT INTO ref_countryitems VALUES("171","Niger");
INSERT INTO ref_countryitems VALUES("172","Nigeria");
INSERT INTO ref_countryitems VALUES("173","Niue");
INSERT INTO ref_countryitems VALUES("174","Norfolk Island");
INSERT INTO ref_countryitems VALUES("175","Northern Mariana Isl");
INSERT INTO ref_countryitems VALUES("176","Norway");
INSERT INTO ref_countryitems VALUES("177","Oman");
INSERT INTO ref_countryitems VALUES("178","Pakistan");
INSERT INTO ref_countryitems VALUES("179","Palau");
INSERT INTO ref_countryitems VALUES("180","Panama");
INSERT INTO ref_countryitems VALUES("181","Papua New Guinea");
INSERT INTO ref_countryitems VALUES("182","Paracel Islands");
INSERT INTO ref_countryitems VALUES("183","Paraguay");
INSERT INTO ref_countryitems VALUES("184","Peru");
INSERT INTO ref_countryitems VALUES("185","Philippines");
INSERT INTO ref_countryitems VALUES("186","Pitcairn Islands");
INSERT INTO ref_countryitems VALUES("187","Poland");
INSERT INTO ref_countryitems VALUES("188","Portugal");
INSERT INTO ref_countryitems VALUES("189","Puerto Rico");
INSERT INTO ref_countryitems VALUES("190","Qatar");
INSERT INTO ref_countryitems VALUES("191","Reunion");
INSERT INTO ref_countryitems VALUES("192","Romania");
INSERT INTO ref_countryitems VALUES("193","Russia");
INSERT INTO ref_countryitems VALUES("194","Rwanda");
INSERT INTO ref_countryitems VALUES("195","Saint Helena");
INSERT INTO ref_countryitems VALUES("196","Saint Kitts and Nevi");
INSERT INTO ref_countryitems VALUES("197","Saint Lucia");
INSERT INTO ref_countryitems VALUES("198","Saint Pierre and Miq");
INSERT INTO ref_countryitems VALUES("199","Saint Vincent and th");
INSERT INTO ref_countryitems VALUES("200","Samoa");
INSERT INTO ref_countryitems VALUES("201","San Marino");
INSERT INTO ref_countryitems VALUES("202","Sao Tome and Princip");
INSERT INTO ref_countryitems VALUES("203","Saudi Arabia");
INSERT INTO ref_countryitems VALUES("204","Senegal");
INSERT INTO ref_countryitems VALUES("205","Serbia and Montenegr");
INSERT INTO ref_countryitems VALUES("206","Seychelles");
INSERT INTO ref_countryitems VALUES("207","Sierra Leone");
INSERT INTO ref_countryitems VALUES("208","Singapore");
INSERT INTO ref_countryitems VALUES("209","Slovakia");
INSERT INTO ref_countryitems VALUES("210","Slovenia");
INSERT INTO ref_countryitems VALUES("211","Solomon Islands");
INSERT INTO ref_countryitems VALUES("212","Somalia");
INSERT INTO ref_countryitems VALUES("213","South Africa");
INSERT INTO ref_countryitems VALUES("214","South Georgia and th");
INSERT INTO ref_countryitems VALUES("215","Spain");
INSERT INTO ref_countryitems VALUES("216","Spratly Islands");
INSERT INTO ref_countryitems VALUES("217","Sri Lanka");
INSERT INTO ref_countryitems VALUES("218","Sudan");
INSERT INTO ref_countryitems VALUES("219","Suriname");
INSERT INTO ref_countryitems VALUES("220","Svalbard");
INSERT INTO ref_countryitems VALUES("221","Swaziland");
INSERT INTO ref_countryitems VALUES("222","Sweden");
INSERT INTO ref_countryitems VALUES("223","Switzerland");
INSERT INTO ref_countryitems VALUES("224","Syria");
INSERT INTO ref_countryitems VALUES("225","Taiwan");
INSERT INTO ref_countryitems VALUES("226","Tajikistan");
INSERT INTO ref_countryitems VALUES("227","Tanzania");
INSERT INTO ref_countryitems VALUES("228","Thailand");
INSERT INTO ref_countryitems VALUES("229","Timor-Leste");
INSERT INTO ref_countryitems VALUES("230","Togo");
INSERT INTO ref_countryitems VALUES("231","Tokelau");
INSERT INTO ref_countryitems VALUES("232","Tonga");
INSERT INTO ref_countryitems VALUES("233","Trinidad and Tobago");
INSERT INTO ref_countryitems VALUES("234","Tromelin Island");
INSERT INTO ref_countryitems VALUES("235","Tunisia");
INSERT INTO ref_countryitems VALUES("236","Turkey");
INSERT INTO ref_countryitems VALUES("237","Turkmenistan");
INSERT INTO ref_countryitems VALUES("238","Turks and Caicos Isl");
INSERT INTO ref_countryitems VALUES("239","Tuvalu");
INSERT INTO ref_countryitems VALUES("240","Uganda");
INSERT INTO ref_countryitems VALUES("241","Ukraine");
INSERT INTO ref_countryitems VALUES("242","United Arab Emirates");
INSERT INTO ref_countryitems VALUES("243","United Kingdom");
INSERT INTO ref_countryitems VALUES("244","United States");
INSERT INTO ref_countryitems VALUES("245","Uruguay");
INSERT INTO ref_countryitems VALUES("246","Uzbekistan");
INSERT INTO ref_countryitems VALUES("247","Vanuatu");
INSERT INTO ref_countryitems VALUES("248","Venezuela");
INSERT INTO ref_countryitems VALUES("249","Vietnam");
INSERT INTO ref_countryitems VALUES("250","Virgin Islands");
INSERT INTO ref_countryitems VALUES("251","Wake Island");
INSERT INTO ref_countryitems VALUES("252","Wallis and Futuna");
INSERT INTO ref_countryitems VALUES("253","West Bank");
INSERT INTO ref_countryitems VALUES("254","Western Sahara");
INSERT INTO ref_countryitems VALUES("255","Yemen");
INSERT INTO ref_countryitems VALUES("256","Zambia");
INSERT INTO ref_countryitems VALUES("257","Zimbabwe");



DROP TABLE IF EXISTS ref_roomstatus;

CREATE TABLE `ref_roomstatus` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `signature_created` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO ref_roomstatus VALUES("1","vacant","2015-10-19 00:00:00","SAN");
INSERT INTO ref_roomstatus VALUES("2","vacant_dirty","2015-10-19 00:00:00","SAN");
INSERT INTO ref_roomstatus VALUES("3","occupied","2015-10-19 00:00:00","SAN");
INSERT INTO ref_roomstatus VALUES("4","occupied_dirty","2015-10-19 00:00:00","SAN");
INSERT INTO ref_roomstatus VALUES("5","reserved","2015-10-19 00:00:00","SAN");
INSERT INTO ref_roomstatus VALUES("6","out_of_use","2015-10-19 00:00:00","SAN");
INSERT INTO ref_roomstatus VALUES("7","blocked","2015-10-19 00:00:00","SAN");



DROP TABLE IF EXISTS reservationfolioitems;

CREATE TABLE `reservationfolioitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` varchar(255) NOT NULL,
  `description` text,
  `plu_group` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `debit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vat` decimal(10,2) DEFAULT '0.00',
  `vatpercent` decimal(10,2) DEFAULT '0.00',
  `discount_unit_charged` decimal(10,2) DEFAULT '0.00',
  `pak` varchar(10) DEFAULT NULL,
  `sub_folio` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `account_number` int(11) NOT NULL,
  `links` varchar(100) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `terminal` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `charge` varchar(255) DEFAULT NULL,
  `audit` varchar(255) DEFAULT NULL,
  `action` enum('sale','payment') NOT NULL DEFAULT 'sale',
  `plu` int(11) DEFAULT NULL,
  `reason` text,
  `source_app` enum('fnb','hotel') NOT NULL DEFAULT 'hotel',
  `type` varchar(255) NOT NULL DEFAULT 'reservationfolio',
  `signature_created` varchar(255) NOT NULL,
  `signature_modified` varchar(255) DEFAULT NULL,
  `status` enum('active','closed','ledger') NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

INSERT INTO reservationfolioitems VALUES("1","000000000001","STANDARD ROOM","12","10000.00","0.00","10000.00","","0.00","0.00","","BILL1","5","","1","001","","","","sale","300","","hotel","reservationfolio","MAZ","","closed","2019-08-28 03:04:12","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("2","000000000001","CASH PAYMENT","0","0.00","50000.00","0.00","","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","closed","2019-08-28 03:04:57","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("3","000000000001","FOOD","0","1500.00","0.00","1500.00","","0.00","0.00","","BILL1","1","","3","001","","POS1","","sale","0","","fnb","reservationfolio","1535071336","","closed","2019-08-28 04:23:53","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("4","000000000001","FOOD","0","500.00","0.00","500.00","","0.00","0.00","","BILL1","1","","1","001","","POS1","","sale","0","","fnb","reservationfolio","1535071336","","closed","2019-08-28 13:29:53","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("5","000000000001","FOOD","0","2000.00","0.00","2000.00","","0.00","0.00","","BILL1","1","","1","001","","POS1","","sale","0","","fnb","reservationfolio","1535071336","","closed","2019-08-28 13:36:48","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("7","000000000001","FOOD","10","5000.00","0.00","5000.00","","0.00","0.00","","BILL1","13","","1","001","","","","sale","0","","hotel","reservationfolio","JBA","","closed","2019-08-28 15:55:05","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("11","000000000001","FOOD","10","7000.00","0.00","7000.00","","0.00","0.00","","BILL1","13","","1","001","","","","sale","100","","hotel","reservationfolio","JBA","","closed","2019-08-28 16:09:30","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("14","000000000001","FOOD","10","9000.00","0.00","9000.00","","0.00","0.00","","BILL1","13","","1","001","","","","sale","100","","hotel","reservationfolio","JBA","","closed","2019-08-28 16:17:03","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("15","000000000001","FOOD","10","9000.00","0.00","9000.00","","0.00","0.00","","BILL1","13","","1","001","","","","sale","100","","hotel","reservationfolio","JBA","","closed","2019-08-28 16:17:55","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("16","000000000001","FOOD23577","10","6500.00","0.00","6500.00","","0.00","0.00","","BILL1","13","","1","001","","","","sale","100","","hotel","reservationfolio","MAZ","","closed","2019-08-28 16:42:18","2019-08-28 22:20:50");
INSERT INTO reservationfolioitems VALUES("17","000000000001","DRINK","4","1200.00","0.00","1200.00","","0.00","0.00","","BILL1","14","","1","001","","","","sale","101","","hotel","reservationfolio","MAZ","","closed","2019-08-28 14:24:47","0001-01-01 00:00:00");
INSERT INTO reservationfolioitems VALUES("18","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-08-28 03:05:29","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("19","000000000013","CASH PAYMENT","0","0.00","50000.00","0.00","","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","closed","2019-08-29 21:29:51","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("20","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-08-29 21:31:46","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("21","000000000013","SUPER DELUXE","1","25000.00","0.00","25000.00","","0.00","0.00","A:","BILL1","23","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-08-29 21:31:46","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("22","000000000015","STANDARD ROOM","1","15000.00","0.00","15000.00","","0.00","0.00","A:","INV","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","ledger","2019-08-29 06:03:51","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("23","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-08-30 07:18:43","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("24","000000000013","SUPER DELUXE","1","25000.00","0.00","25000.00","","0.00","0.00","A:","BILL1","23","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-08-30 07:18:43","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("25","000000000018","0","1","0.00","0.00","0.00","","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-08-30 18:40:17","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("26","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-08-31 18:48:13","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("27","000000000016","STANDARD ROOM [COMPLEMENTARY]","1","0.00","0.00","0.00","","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-08-31 18:48:13","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("28","000000000018","STANDARD ROOM [COMPLEMENTARY]","1","0.00","0.00","0.00","","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-08-31 18:48:13","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("29","000000000013","SUPER DELUXE","1","25000.00","0.00","25000.00","","0.00","0.00","A:","BILL1","23","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-08-31 18:48:13","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("30","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","75000.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-01 21:54:44","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("31","000000000016","STANDARD ROOM","1","14333.33","0.00","14333.33","71666.65","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-01 21:54:44","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("32","000000000017","STANDARD ROOM [COMPLEMENTARY]","1","0.00","0.00","0.00","71666.65","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-01 21:54:44","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("33","000000000018","STANDARD ROOM","1","15000.00","0.00","15000.00","75000.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-01 21:54:44","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("34","000000000013","SUPER DELUXE","1","25000.00","0.00","25000.00","75000.00","0.00","0.00","A:","BILL1","23","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-01 21:54:44","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("35","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","750.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-02 21:56:58","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("36","000000000016","STANDARD ROOM","1","14333.33","0.00","14333.33","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-02 21:56:58","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("37","000000000017","STANDARD ROOM [COMPLEMENTARY]","1","0.00","0.00","0.00","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-02 21:56:58","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("38","000000000018","STANDARD ROOM [COMPLEMENTARY]","1","0.00","0.00","0.00","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-02 21:56:58","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("39","000000000013","SUPER DELUXE","1","25000.00","0.00","25000.00","716.67","0.00","0.00","A:","BILL1","23","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-02 21:56:58","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("40","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","750.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-03 22:00:55","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("41","000000000016","STANDARD ROOM","1","14333.33","0.00","14333.33","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-03 22:00:55","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("42","000000000017","STANDARD ROOM","1","15000.00","0.00","15000.00","750.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-03 22:00:55","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("43","000000000018","STANDARD ROOM [COMPLEMENTARY]","1","0.00","0.00","0.00","0.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-03 22:00:55","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("44","000000000013","SUPER DELUXE","1","25000.00","0.00","25000.00","0.00","0.00","0.00","A:","BILL1","23","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-03 22:00:55","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("45","000000000017","CASH PAYMENT","0","0.00","15000.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","closed","2019-09-04 23:55:44","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("46","000000000001","STANDARD ROOM","1","15000.00","0.00","15000.00","750.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-09-04 08:56:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("47","000000000016","STANDARD ROOM","1","14333.33","0.00","14333.33","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-04 08:56:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("48","000000000017","STANDARD ROOM","1","15000.00","0.00","15000.00","750.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-09-04 08:56:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("49","000000000018","0","1","0.00","0.00","0.00","0.00","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-09-04 08:56:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("50","000000000019","STANDARD ROOM","1","14250.00","0.00","14250.00","712.50","0.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-04 08:56:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("51","000000000013","SUPER DELUXE","1","25000.00","0.00","25000.00","0.00","0.00","0.00","A:","BILL1","23","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-09-04 08:56:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("52","000000000001","CASH PAYMENT","0","0.00","121700.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","closed","2019-09-05 09:08:52","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("53","000000000013","CASH PAYMENT","0","0.00","125000.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","closed","2019-09-05 09:09:09","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("54","000000000016","CASH PAYMENT","0","0.00","57333.33","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","active","2019-09-05 09:09:25","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("55","000000000017","CASH PAYMENT","0","0.00","15000.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","closed","2019-09-05 09:09:37","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("56","000000000018","CASH PAYMENT","0","0.00","15000.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","closed","2019-09-05 09:09:51","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("57","000000000016","CASH PAYMENT","0","0.00","0.33","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","active","2019-09-05 09:12:42","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("58","000000000016","CASH PAYMENT","0","0.00","2.33","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","active","2019-09-05 09:13:27","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("59","000000000016","STANDARD ROOM","1","15050.00","0.00","15050.00","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-05 09:28:25","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("60","000000000019","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","0.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-05 09:28:25","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("61","000000000020","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","0.00","750.00","A:","INV","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","ledger","2019-09-05 09:28:25","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("62","000000000020","CASH PAYMENT","0","0.00","14962.50","0.00","0.00","0.00","0.00","","INV","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","ledger","2019-09-06 09:33:15","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("63","000000000016","STANDARD ROOM","1","15050.00","0.00","15050.00","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-06 09:45:56","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("64","000000000019","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","0.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-06 09:45:56","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("65","000000000020","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","0.00","750.00","A:","INV","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","ledger","2019-09-06 09:45:56","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("66","000000000019","CASH PAYMENT","0","0.00","44175.50","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","active","2019-09-07 10:25:58","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("67","000000000020","SERVICE CHARGE","1","4488.75","0.00","4488.75","0.00","0.00","0.00","","INV","4","","1","001","","SC","","sale","1","yes","hotel","reservationfolio","MAZ","","ledger","2019-09-07 18:09:57","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("68","000000000016","STANDARD ROOM","1","15050.00","0.00","15050.00","716.67","0.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-07 18:09:04","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("69","000000000019","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","0.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-07 18:09:04","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("70","000000000020","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","0.00","750.00","A:","INV","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","ledger","2019-09-07 18:09:04","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("71","000000000016","STANDARD ROOM","1","15050.00","0.00","15050.00","716.67","5.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-08 18:27:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("72","000000000019","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","5.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-08 18:27:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("73","000000000020","STANDARD ROOM","1","14962.50","0.00","14962.50","712.50","5.00","750.00","A:","INV","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","ledger","2019-09-08 18:27:34","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("74","000000000020","CASH PAYMENT","0","0.00","14962.50","0.00","0.00","0.00","0.00","","INV","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","ledger","2019-09-09 18:33:54","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("75","000000000020","CASH PAYMENT","0","0.00","14962.50","0.00","0.00","0.00","0.00","","INV","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","ledger","2019-09-09 18:34:05","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("76","000000000020","CASH PAYMENT","0","0.00","14962.50","0.00","0.00","0.00","0.00","","INV","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","ledger","2019-09-09 18:34:12","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("77","000000000020","CASH PAYMENT","0","0.00","4489.50","0.00","0.00","0.00","0.00","","INV","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","ledger","2019-09-09 18:35:11","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("78","000000000020","CASH PAYMENT","0","0.00","1.50","0.00","0.00","0.00","0.00","","INV","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","ledger","2019-09-09 18:35:53","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("79","000000000016","STANDARD ROOM","1","14333.33","0.00","14333.33","716.67","5.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-09 09:09:02","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("80","000000000019","STANDARD ROOM","1","14250.00","0.00","14250.00","712.50","5.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","active","2019-09-09 09:09:02","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("81","000000000021","STANDARD ROOM","1","15000.00","0.00","15000.00","750.00","5.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","MAZ","","closed","2019-09-09 09:09:02","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("82","000000000021","CASH PAYMENT","0","0.00","15000.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","MAZ","","closed","2019-09-10 09:42:16","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("83","000000000016","STANDARD ROOM","1","14333.33","0.00","14333.33","716.67","5.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-10 10:01:16","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("84","000000000019","STANDARD ROOM","1","14250.00","0.00","14250.00","712.50","5.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-10 10:01:16","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("85","000000000022","MY ROOM DESC","1","14250.00","0.00","14250.00","712.50","5.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","closed","2019-09-10 10:01:16","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("86","000000000022","CASH PAYMENT","0","0.00","14250.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","closed","2019-09-11 10:02:02","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("87","000000000022","SERVICE CHARGE","1","1425.00","0.00","1425.00","0.00","0.00","0.00","","BILL1","4","","1","001","","SC","","sale","1","yes","hotel","reservationfolio","750","","closed","2019-09-11 10:02:43","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("88","000000000022","CASH PAYMENT","0","0.00","1425.00","0.00","0.00","0.00","0.00","","BILL1","1","","0","001","","","","payment","0","","hotel","reservationfolio","750","","closed","2019-09-11 10:05:47","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("89","000000000016","STANDARD ROOM","1","14333.33","0.00","14333.33","716.67","5.00","0.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-11 23:31:31","0000-00-00 00:00:00");
INSERT INTO reservationfolioitems VALUES("90","000000000019","STANDARD ROOM","1","14250.00","0.00","14250.00","712.50","5.00","750.00","A:","BILL1","5","","1","001","","ROOM","","sale","1","","hotel","reservationfolio","750","","active","2019-09-11 23:31:31","0000-00-00 00:00:00");



DROP TABLE IF EXISTS reservationitems;

CREATE TABLE `reservationitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` varchar(255) NOT NULL,
  `account_type` enum('ROOM','HOUSE','GROUP') NOT NULL DEFAULT 'ROOM',
  `master_id` varchar(255) DEFAULT NULL,
  `arrival` date NOT NULL,
  `nights` int(11) NOT NULL DEFAULT '1',
  `departure` date NOT NULL,
  `room_number` tinyint(3) NOT NULL DEFAULT '0',
  `roomtype` int(2) NOT NULL,
  `client_type` enum('person','group') NOT NULL DEFAULT 'person',
  `client_name` varchar(255) NOT NULL,
  `agency_name` varchar(255) DEFAULT NULL,
  `agency_contact` text,
  `guest1` varchar(255) DEFAULT NULL,
  `guest2` varchar(255) DEFAULT NULL,
  `guest_count` int(3) DEFAULT '0',
  `adults` int(2) DEFAULT '1',
  `children` int(2) DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT 'reservation',
  `remarks` text,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `signature_created` varchar(255) NOT NULL,
  `signature_modified` varchar(255) DEFAULT NULL,
  `status` enum('staying','confirmed','departed','cancelled','provisional','ledger') NOT NULL DEFAULT 'confirmed',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `actual_arrival` datetime DEFAULT '0000-00-00 00:00:00',
  `actual_departure` datetime DEFAULT '0000-00-00 00:00:00',
  `last_room_charge` datetime DEFAULT '0000-00-00 00:00:00',
  `last_account_close` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `reservations_id` (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

INSERT INTO reservationitems VALUES("1","000000000001","ROOM","","2019-08-28","8","2019-09-03","1","6","person","mark","","","mark","","1","1","0","reservation","","2019-08-28 02:14:15","0000-00-00 00:00:00","MAZ","","departed","0","2019-08-28 02:14:40","2019-09-05 09:10:21","2019-09-04 08:56:34","2019-09-06 09:28:38");
INSERT INTO reservationitems VALUES("2","000000000002","ROOM","","2019-08-28","3","2019-08-31","6","8","person","solomon gundi","","","solomon gundi","","1","1","0","reservation","yes","2019-08-28 04:32:32","0000-00-00 00:00:00","MAZ","","cancelled","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("3","000000000003","ROOM","","2019-08-28","1","2019-08-29","3","6","person","fredrick bolland","","","fredrick bolland","","1","1","0","reservation","guest","2019-08-28 16:43:32","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("4","000000000004","ROOM","","2019-08-28","1","2019-08-29","6","8","person","jackobo","field","","jackobo","","1","1","0","reservation","to test 0000000004 delete","2019-08-28 16:45:21","0000-00-00 00:00:00","MAZ","","cancelled","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("5","000000000005","ROOM","","2019-08-28","1","2019-08-29","13","7","person","fred butter","","","fred butter","","1","1","0","reservation","","2019-08-28 16:58:30","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("6","000000000006","ROOM","","2019-08-28","1","2019-08-29","10","9","person","hope","","","hope","","1","1","0","reservation","","2019-08-28 16:59:56","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("7","000000000007","ROOM","","2019-08-28","1","2019-08-29","6","8","person","silvia","","","silvia","","1","1","0","reservation","sil","2019-08-28 05:27:25","0000-00-00 00:00:00","MAZ","","cancelled","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("8","000000000008","ROOM","","2019-09-12","1","2019-09-13","15","8","person","adam lallana","","","adam lallana","","1","1","0","reservation","","2019-08-28 21:27:34","2019-08-28 21:59:29","MAZ","MAZ","confirmed","0","0001-01-01 00:00:00","0001-01-01 00:00:00","0001-01-01 00:00:00","0001-01-01 00:00:00");
INSERT INTO reservationitems VALUES("9","000000000009","ROOM","","2019-08-29","2","2019-08-31","12","7","person","collins brad","","","collins brad","","1","1","0","reservation","","2019-08-28 15:01:40","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("10","000000000010","ROOM","","2019-08-31","5","2019-09-05","13","7","person","ola","","","ola","","1","1","0","reservation","","2019-08-28 15:02:18","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("11","000000000011","ROOM","","2019-08-29","3","2019-09-01","15","8","person","obi","","","obi","","1","1","0","reservation","","2019-08-28 19:44:51","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("12","000000000012","ROOM","","2019-08-28","1","2019-08-29","12","7","person","bullus mark","","","bullus mark","","1","1","0","reservation","","2019-08-28 22:31:08","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("13","000000000013","ROOM","","2019-08-29","6","2019-09-03","15","8","person","solomon","","","solomon","","1","1","0","reservation","","2019-08-29 21:17:35","0000-00-00 00:00:00","MAZ","","departed","0","2019-08-29 21:29:15","2019-09-05 09:10:54","2019-09-04 08:56:34","2019-09-06 09:28:38");
INSERT INTO reservationitems VALUES("14","000000000014","ROOM","","2019-08-30","5","2019-09-04","12","7","person","jonathan","","","jonathan","","1","1","0","reservation","","2019-08-29 21:26:04","2019-08-29 21:26:35","MAZ","MAZ","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("15","000000000015","ROOM","","2019-08-29","1","2019-09-01","2","6","person","silas","","","silas","","1","1","0","reservation","","2019-08-29 07:10:12","0000-00-00 00:00:00","750","","ledger","0","2019-08-29 07:10:28","2019-08-30 10:01:40","2019-08-29 06:03:51","2019-08-30 06:04:12");
INSERT INTO reservationitems VALUES("16","000000000016","ROOM","","2019-08-30","11","2019-09-10","3","6","person","hope","","","hope","","1","1","0","reservation","","2019-08-30 17:06:36","0000-00-00 00:00:00","750","","staying","0","2019-08-30 17:06:49","0000-00-00 00:00:00","2019-09-11 23:31:31","2019-09-12 23:31:41");
INSERT INTO reservationitems VALUES("17","000000000017","ROOM","","2019-08-30","5","2019-09-03","4","6","person","sam","","","sam","","1","1","0","reservation","","2019-08-30 18:28:04","0000-00-00 00:00:00","750","","departed","0","2019-08-30 18:28:14","2019-09-05 09:13:35","2019-09-04 08:56:34","2019-09-06 09:28:38");
INSERT INTO reservationitems VALUES("18","000000000018","ROOM","","2019-08-30","5","2019-09-03","7","6","person","donald","","","donald","","1","1","0","reservation","","2019-08-30 18:38:50","0000-00-00 00:00:00","750","","departed","0","2019-08-30 18:38:59","2019-09-05 09:14:51","2019-09-04 08:56:34","2019-09-06 09:28:38");
INSERT INTO reservationitems VALUES("19","000000000019","ROOM","","2019-09-04","6","2019-09-10","8","6","person","samglock","","","samglock","","1","1","0","reservation","","2019-09-04 07:12:04","2019-09-04 07:25:26","750","750","staying","0","2019-09-04 07:12:06","0000-00-00 00:00:00","2019-09-11 23:31:31","2019-09-12 23:31:41");
INSERT INTO reservationitems VALUES("20","000000000020","ROOM","","2019-09-05","4","2019-09-08","11","6","person","vincent","","","vincent","","1","1","0","reservation","","2019-09-05 09:28:06","0000-00-00 00:00:00","750","","ledger","0","2019-09-05 09:28:13","2019-09-09 18:45:29","2019-09-08 18:27:34","2019-09-09 18:27:44");
INSERT INTO reservationitems VALUES("21","000000000021","ROOM","","2019-09-09","1","2019-09-12","17","6","person","takon","","","takon","","1","1","0","reservation","","2019-09-09 09:08:26","0000-00-00 00:00:00","MAZ","","departed","0","2019-09-09 09:08:35","2019-09-10 09:59:15","2019-09-09 09:09:02","2019-09-11 10:01:26");
INSERT INTO reservationitems VALUES("22","000000000022","ROOM","","2019-09-10","1","2019-09-13","20","6","person","sandra","","","sandra","","1","1","0","reservation","","2019-09-10 10:00:54","0000-00-00 00:00:00","750","","departed","0","2019-09-10 10:01:01","2019-09-11 10:05:58","2019-09-10 10:01:16","2019-09-12 23:31:41");
INSERT INTO reservationitems VALUES("23","000000000023","GROUP","","2019-09-11","3","2019-09-14","0","6","group","crystal palace","","","","","0","1","0","reservation","","2019-09-11 23:27:59","0000-00-00 00:00:00","MAZ","","confirmed","0","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO reservationitems VALUES("24","000000000024","GROUP","","2019-09-11","3","2019-09-14","0","6","group","birminham","","","","","0","1","0","reservation","","2019-09-11 23:30:17","0000-00-00 00:00:00","750","","staying","0","2019-09-11 23:30:50","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-09-12 23:31:41");
INSERT INTO reservationitems VALUES("25","000000000025","GROUP","","2019-09-11","3","2019-09-14","0","6","group","colo","","","","","0","1","0","reservation","","2019-09-11 23:31:12","0000-00-00 00:00:00","750","","staying","0","2019-09-11 23:31:18","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-09-12 23:31:41");



DROP TABLE IF EXISTS reservationpriceitems;

CREATE TABLE `reservationpriceitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` varchar(255) NOT NULL,
  `price_rate` tinyint(3) NOT NULL,
  `folio_room` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `folio_extra` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `folio_other` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `weekday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weekend` decimal(10,2) NOT NULL DEFAULT '0.00',
  `holiday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(255) NOT NULL DEFAULT 'reservationprice',
  `price_room` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_extra` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_type` enum('ratio','value','none') NOT NULL DEFAULT 'none',
  `discount_ratio` decimal(10,2) DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `max_discount_value` decimal(10,2) DEFAULT '0.00',
  `weekday_no_deductions` decimal(10,2) DEFAULT '0.00',
  `weekend_no_deductions` decimal(10,2) DEFAULT '0.00',
  `holiday_no_deductions` decimal(10,2) DEFAULT '0.00',
  `price_room_no_deductions` decimal(10,2) DEFAULT '0.00',
  `invoice` enum('none','client','agency') NOT NULL DEFAULT 'none',
  `comp_nights` int(3) NOT NULL DEFAULT '0',
  `comp_visits` enum('yes','no') NOT NULL DEFAULT 'no',
  `comp_nights_charged` int(3) DEFAULT NULL,
  `auto_deposit` enum('yes','no') NOT NULL DEFAULT 'no',
  `block_pos` enum('yes','no') NOT NULL DEFAULT 'no',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `charge_from_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `reservations_id` (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

INSERT INTO reservationpriceitems VALUES("1","000000000001","1","BILL1","BILL1","BILL1","15000.00","15000.00","15000.00","reservationprice","30000.00","0.00","30000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","2019-08-28");
INSERT INTO reservationpriceitems VALUES("2","000000000002","4","BILL1","BILL1","BILL1","25000.00","25000.00","25000.00","reservationprice","75000.00","0.00","75000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("3","000000000004","4","BILL1","BILL1","BILL1","25000.00","25000.00","25000.00","reservationprice","25000.00","0.00","25000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("4","000000000007","4","BILL1","BILL1","BILL1","25000.00","25000.00","25000.00","reservationprice","25000.00","0.00","25000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("5","000000000008","4","BILL1","BILL1","BILL1","25000.00","25000.00","25000.00","reservationprice","25000.00","0.00","25000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("6","000000000009","3","BILL1","BILL1","BILL1","20000.00","20000.00","20000.00","reservationprice","40000.00","0.00","40000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0001-01-01");
INSERT INTO reservationpriceitems VALUES("7","000000000010","3","BILL1","BILL1","BILL1","20000.00","20000.00","20000.00","reservationprice","100000.00","0.00","100000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0001-01-01");
INSERT INTO reservationpriceitems VALUES("8","000000000011","4","BILL1","BILL1","BILL1","25000.00","25000.00","25000.00","reservationprice","75000.00","0.00","75000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("9","000000000012","3","BILL1","BILL1","BILL1","20000.00","20000.00","20000.00","reservationprice","20000.00","0.00","20000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("10","000000000013","4","BILL1","BILL1","BILL1","25000.00","25000.00","25000.00","reservationprice","75000.00","0.00","70000.00","none","0.00","5000.00","0.00","0.00","0.00","0.00","0.00","none","0","no","4","no","no","0","2019-08-29");
INSERT INTO reservationpriceitems VALUES("11","000000000014","3","BILL1","BILL1","BILL1","20000.00","20000.00","20000.00","reservationprice","100000.00","0.00","58000.00","ratio","0.00","2000.00","0.00","0.00","0.00","0.00","0.00","none","2","yes","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("12","000000000015","1","BILL1","BILL1","BILL1","15000.00","15000.00","15000.00","reservationprice","45000.00","0.00","43650.00","none","0.03","1350.00","0.00","0.00","0.00","0.00","0.00","none","0","no","","no","no","0","2019-08-29");
INSERT INTO reservationpriceitems VALUES("13","000000000016","1","BILL1","BILL1","BILL1","14333.33","14333.33","14333.33","reservationprice","42999.99","0.00","27999.99","value","0.00","2000.00","0.00","0.00","0.00","0.00","0.00","none","1","yes","1","no","no","0","2019-08-31");
INSERT INTO reservationpriceitems VALUES("14","000000000017","1","BILL1","BILL1","BILL1","15000.00","15000.00","15000.00","reservationprice","45000.00","0.00","15000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","2","yes","2","no","no","0","2019-09-01");
INSERT INTO reservationpriceitems VALUES("15","000000000018","1","BILL1","BILL1","BILL1","15000.00","15000.00","15000.00","reservationprice","45000.00","0.00","15000.00","none","0.00","0.00","0.00","0.00","0.00","0.00","0.00","none","2","yes","6","no","no","0","2019-08-30");
INSERT INTO reservationpriceitems VALUES("16","000000000019","1","BILL1","BILL1","BILL1","14250.00","14250.00","14250.00","reservationprice","42750.00","0.00","42750.00","value","0.05","2250.00","2250.00","15000.00","15000.00","15000.00","45000.00","none","0","no","","no","no","0","2019-09-04");
INSERT INTO reservationpriceitems VALUES("17","000000000020","1","BILL1","BILL1","BILL1","14250.00","14250.00","14250.00","reservationprice","42750.00","0.00","42750.00","ratio","0.05","2250.00","2250.00","15000.00","15000.00","15000.00","45000.00","none","0","no","","no","no","0","2019-09-05");
INSERT INTO reservationpriceitems VALUES("18","000000000021","1","BILL1","BILL1","BILL1","15000.00","15000.00","15000.00","reservationprice","45000.00","0.00","45000.00","none","0.00","0.00","0.00","15000.00","15000.00","15000.00","45000.00","none","0","no","","no","no","0","2019-09-09");
INSERT INTO reservationpriceitems VALUES("19","000000000022","1","BILL1","BILL1","BILL1","14250.00","14250.00","14250.00","reservationprice","42750.00","0.00","42750.00","ratio","0.05","2250.00","2250.00","15000.00","15000.00","15000.00","45000.00","none","0","no","","no","no","0","2019-09-10");
INSERT INTO reservationpriceitems VALUES("20","000000000023","1","INV","INV","INV","15000.00","15000.00","15000.00","reservationprice","45000.00","0.00","45000.00","none","0.00","0.00","0.00","15000.00","15000.00","15000.00","45000.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("21","000000000024","1","INV","INV","INV","14250.00","14250.00","14250.00","reservationprice","42750.00","0.00","42750.00","ratio","0.05","2250.00","2250.00","15000.00","15000.00","15000.00","45000.00","none","0","no","","no","no","0","0000-00-00");
INSERT INTO reservationpriceitems VALUES("22","000000000025","1","INV","INV","INV","15000.00","15000.00","15000.00","reservationprice","45000.00","0.00","45000.00","none","0.00","0.00","0.00","15000.00","15000.00","15000.00","45000.00","none","1","no","","no","no","0","0000-00-00");



DROP TABLE IF EXISTS roleitems;

CREATE TABLE `roleitems` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `reserv_folio` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `reports` enum('1','2') NOT NULL DEFAULT '1',
  `utilities` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `maintenance` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `monitors` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `configuration` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `prices` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `overview` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `delete_group` enum('0','1') NOT NULL DEFAULT '0',
  `maximum_discount_allowed` int(3) DEFAULT '0',
  `cash_discount_allowed` enum('0','1') DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT 'role',
  `signature_created` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `usergroup_desc` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COMMENT='user roles';

INSERT INTO roleitems VALUES("1","F/O","FRONT OFFICE STAFF","3","2","3","3","1","1","1","2","0","5","1","role","","2017-03-02 21:33:35","2019-08-29 07:12:07");
INSERT INTO roleitems VALUES("2","F/M","FRONT OFFICE MANAGER","4","2","3","3","2","1","3","2","1","0","0","role","","2017-03-05 17:32:32","1970-01-01 11:05:15");
INSERT INTO roleitems VALUES("3","ACC","ACCOUNTANT","4","2","3","3","2","1","3","3","1","0","0","role","","2017-03-05 17:43:31","2017-09-01 11:28:52");
INSERT INTO roleitems VALUES("4","IT","IT MANAGERS","4","2","3","3","2","3","4","3","1","0","0","role","","2017-03-05 18:33:18","2017-03-09 14:35:47");
INSERT INTO roleitems VALUES("8","F/O_FB","FRONT OFFICE, WITH FOOD AND BAR","4","2","3","3","2","3","3","3","1","0","0","role","","2017-03-05 19:36:55","2017-08-16 08:54:21");
INSERT INTO roleitems VALUES("9","F/O_HK","front office with housekeeping","2","2","3","4","1","1","1","1","1","0","0","role","","2017-03-09 09:12:48","0000-00-00 00:00:00");
INSERT INTO roleitems VALUES("28","ADMIN","ADMIN","4","2","4","4","4","4","4","4","1","0","0","role","JBA","2017-03-09 16:02:46","2017-03-10 09:08:10");
INSERT INTO roleitems VALUES("29","SUPER","SUPER","4","2","4","4","4","4","4","4","1","0","0","role","JBA","2017-03-09 16:02:46","2017-03-10 08:41:51");



DROP TABLE IF EXISTS roomclassitems;

CREATE TABLE `roomclassitems` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `signature_created` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'roomclass',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `room_class` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO roomclassitems VALUES("2","STANDARD","STANDARD ROOM","JBA","roomclass","2017-09-01 11:30:46","2018-11-27 17:07:09");
INSERT INTO roomclassitems VALUES("3","DELUXE","DELUXE ROOM","JBA","roomclass","2018-09-28 16:59:33","2018-11-27 17:08:10");
INSERT INTO roomclassitems VALUES("4","SDELUXE","SUPER DELUXE","JBA","roomclass","2018-09-28 16:59:48","2018-11-27 18:39:25");
INSERT INTO roomclassitems VALUES("5","DIPLOMAT","DIPLOMATIC","JBA","roomclass","2018-09-28 17:00:13","2018-11-27 17:11:06");



DROP TABLE IF EXISTS roomitems;

CREATE TABLE `roomitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `roomtype` tinyint(3) NOT NULL,
  `roomclass` tinyint(3) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `description` text,
  `bed` int(3) NOT NULL DEFAULT '1',
  `firstfloor` enum('0','1') DEFAULT '0',
  `secondfloor` enum('0','1') DEFAULT '0',
  `thirdfloor` enum('0','1') DEFAULT '0',
  `groundfloor` enum('0','1') DEFAULT '0',
  `frontview` enum('0','1') DEFAULT '0',
  `backview` enum('0','1') DEFAULT '0',
  `remark` text,
  `acctname` tinyint(3) NOT NULL,
  `lock_room` enum('0','1') DEFAULT '0',
  `close_phone_tv` enum('0','1') DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT 'room',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `room_number` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO roomitems VALUES("1","101","6","2","2","STANDARD ROOM","1","0","0","0","1","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-09-28 17:37:34","2018-11-27 17:49:32");
INSERT INTO roomitems VALUES("2","102","6","2","2","STANDARD ROOM","1","0","0","0","1","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-09-28 17:38:15","2018-11-27 17:51:24");
INSERT INTO roomitems VALUES("3","103","6","5","4","STANDARD ROOM","1","0","0","0","1","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-09-28 17:38:51","2018-11-27 18:37:23");
INSERT INTO roomitems VALUES("4","104","6","2","2","STANDARD ROOM","1","0","0","0","1","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-09-28 17:39:23","2018-11-27 17:53:44");
INSERT INTO roomitems VALUES("5","304","8","4","1","SUPER DELUXE","1","0","0","0","1","0","0","SUPER DELUXE","23","0","0","room","JBA","2018-09-28 17:40:01","2018-11-27 18:11:08");
INSERT INTO roomitems VALUES("6","305","8","4","1","SUPER DELUXE","1","0","0","0","1","0","0","SUPER DELUXE","23","0","0","room","JBA","2018-09-28 17:40:29","2018-11-27 18:12:56");
INSERT INTO roomitems VALUES("7","401","6","2","2","STANDARD ROOM","1","0","0","0","1","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-09-28 17:41:07","2018-11-27 18:16:06");
INSERT INTO roomitems VALUES("8","402","6","2","4","STANDARD ROOM","1","0","0","0","1","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-09-28 17:41:35","2018-11-27 18:17:17");
INSERT INTO roomitems VALUES("9","201","7","3","1","DULUXE ROOM","1","1","0","0","0","0","0","DULUXE ROOM","17","0","0","room","JBA","2018-09-28 17:42:01","2018-11-27 17:57:26");
INSERT INTO roomitems VALUES("10","202","9","5","1","DIPLOMATIC SUITE","1","1","0","0","0","0","0","DIPLOMATIC SUITE","24","0","0","room","JBA","2018-09-28 17:42:34","2018-11-27 18:04:52");
INSERT INTO roomitems VALUES("11","203","6","2","2","STANDARD ROOM","1","1","0","0","0","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-09-28 17:43:01","2018-11-27 17:54:57");
INSERT INTO roomitems VALUES("12","204","7","3","1","DULUXE ROOM","1","1","0","0","0","0","0","DULUXE ROOM","17","0","0","room","JBA","2018-09-28 17:43:50","2018-11-27 18:02:12");
INSERT INTO roomitems VALUES("13","205","7","3","1","DULUXE ROOM","1","1","0","0","0","0","0","DULUXE ROOM","17","0","0","room","JBA","2018-09-28 17:44:31","2018-11-27 17:59:09");
INSERT INTO roomitems VALUES("14","206","7","3","1","DULUXE ROOM","1","1","0","0","0","0","0","DULUXE ROOM","17","0","0","room","JBA","2018-09-28 17:45:00","2018-11-27 18:00:29");
INSERT INTO roomitems VALUES("15","302","8","4","2","SUPER DELUXE","1","1","0","0","0","0","0","SUPER DELUXE","23","0","0","room","JBA","2018-09-28 17:45:30","2018-11-27 18:08:09");
INSERT INTO roomitems VALUES("16","303","8","4","1","SUPER DELUXE","1","1","0","0","0","0","0","SUPER DELUXE","23","0","0","room","JBA","2018-09-28 17:46:06","2018-11-27 18:09:34");
INSERT INTO roomitems VALUES("17","403","6","2","2","STANDARD ROOM","1","0","0","0","1","0","0","STANDARD ROOM","5","0","0","room","JBA","2018-11-27 18:19:46","0000-00-00 00:00:00");
INSERT INTO roomitems VALUES("20","501","6","2","2","MY ROOM DESC","1","0","0","0","0","1","0","my room","1","0","0","room","MAZ","2019-08-28 05:32:20","0000-00-00 00:00:00");



DROP TABLE IF EXISTS roomtypeitems;

CREATE TABLE `roomtypeitems` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `roomclass` tinyint(3) NOT NULL,
  `beds` int(3) NOT NULL DEFAULT '0',
  `description` text,
  `remark` text,
  `type` varchar(255) NOT NULL DEFAULT 'roomtype',
  `signature_created` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `room_type` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO roomtypeitems VALUES("6","STANDARD","2","1","STANDARD ROOM","","roomtype","JBA","2018-11-27 16:49:29","0000-00-00 00:00:00");
INSERT INTO roomtypeitems VALUES("7","DELUXE","3","1","DELUXE ROOM","DELUXE ROOM","roomtype","JBA","2018-11-27 17:02:04","0000-00-00 00:00:00");
INSERT INTO roomtypeitems VALUES("8","SDELUXE","4","1","SUPER DELUXE","SUPER DELUXE","roomtype","JBA","2018-11-27 17:03:41","2018-11-27 18:43:39");
INSERT INTO roomtypeitems VALUES("9","DIPLOMAT","5","1","DIPLOMATIC ROOM","DIPLOMATIC ROOM","roomtype","JBA","2018-11-27 17:05:22","0000-00-00 00:00:00");



DROP TABLE IF EXISTS siteitems;

CREATE TABLE `siteitems` (
  `ID` int(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `street1` varchar(100) DEFAULT NULL,
  `street2` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `tel1` varchar(15) DEFAULT NULL,
  `tel2` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `show_passwords` enum('0','1') DEFAULT '0',
  `type` varchar(100) DEFAULT 'site',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `signature` varchar(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO siteitems VALUES("1","GALPIN SUITES","N0. 1, Jafac Close Off Alhaji Jimoh Street,","ACO Bus Stop, Adeniyi Jones, Ikeja","Lagos","172","+234 903 861 87","+234 805 145 49","galpinsuites@gmail.com","","www.galpinsuites.com","hotel1.png","","","0","site","2017-09-01 07:52:36","2018-11-27 16:22:56","MAZ");



DROP TABLE IF EXISTS useritems;

CREATE TABLE `useritems` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `role` tinyint(2) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `hashed_p` varchar(255) NOT NULL,
  `last_login_ip` varchar(20) DEFAULT NULL,
  `last_login_time` datetime DEFAULT '0000-00-00 00:00:00',
  `last_logout_time` datetime DEFAULT '0000-00-00 00:00:00',
  `signature` varchar(50) NOT NULL,
  `signature_created` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'user',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `signature` (`signature`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO useritems VALUES("1","mark zucker","29","","sha256:1000:9iCcib68Vt+loKSgYIKkI+GKwCsLAmc/:6Ce+61huNhOTvQhNjFJdQBGNmh8fZ/4C","::1","2019-09-11 23:22:00","2019-09-11 23:28:29","MAZ","SAN","user","2015-10-18 20:44:55","2015-11-11 00:00:00");
INSERT INTO useritems VALUES("2","justin baker","28","","sha256:1000:c9izOV1dHB54SZKcE7yPFovqAo5QzWdW:wdS+PM5P2QVIr1PLctt9zTm4zJ/zZkhL","::1","2019-08-28 15:45:10","2018-09-29 16:38:31","JBA","MAZ","user","2015-10-19 02:34:17","2018-09-28 20:56:53");
INSERT INTO useritems VALUES("3","ACOUNTANT","3","","sha256:1000:WGIgUw/eT/cacmKqKRJU+Gg5N07sAGnj:KbRoIfeyFjEt17e/0l/Z20JumH99+1xe","192.168.0.184","2018-09-29 17:18:30","2018-09-29 10:59:44","ACC","JBA","user","2018-09-28 17:55:28","0000-00-00 00:00:00");
INSERT INTO useritems VALUES("4","emma_test","1","","sha256:1000:rp2zxAZMy+NQrgLV0cc86B8W9+fA93g5:Yvd65OAxINil4f06qXap96FZAt5a6Iqz","::1","2019-09-11 23:28:37","2019-09-07 11:18:21","750","MAZ","user","2019-08-29 06:39:54","0000-00-00 00:00:00");



