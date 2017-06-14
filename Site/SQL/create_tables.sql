CREATE TABLE IF NOT EXISTS ARTICLE(
	ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	TITLE VARCHAR(255) NOT NULL,
	CONTENT VARCHAR(2048) NOT NULL,
	DATE_TIME DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ARTICLE_IMAGE VARCHAR(255) NULL,
	FULLTEXT (TITLE,CONTENT)
) ENGINE=InnoDB;;


CREATE TABLE IF NOT EXISTS ARTICLE_COMMENT(
	ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	ARTICLE_ID INT NOT NULL,
	COMMENT_ID INT NULL,
	USERNAME VARCHAR(255) NOT NULL,
	EMAIL VARCHAR(255) NOT NULL,
	CONTENT VARCHAR(2048) NOT NULL,
	DATE_TIME DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

/*
CREATE TABLE IF NOT EXISTS ARTICLE_COMMENT_REPLY{
	ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	ARTICLE_ID INT NOT NULL,
	COMMENT_ID INT NOT NULL,
	USERNAME VARCHAR(255) NOT NULL,
	EMAIL VARCHAR(255) NOT NULL,
	CONTENT VARCHAR(2048) NOT NULL,
	DATE_TIME DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (ARTICLE_ID) REFERENCES ARTICLE (ID),
	FOREIGN KEY (COMMENT_ID) REFERENCES ARTICLE_COMMENT (ID)
};
*/


