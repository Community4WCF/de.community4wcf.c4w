DROP TABLE IF EXISTS c4w1_1_user;
CREATE TABLE c4w1_1_user (
	userID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	c4w SMALLINT(5) NOT NULL DEFAULT 0,
	KEY (c4w)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;