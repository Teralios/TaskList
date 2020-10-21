-- project table
DROP TABLE IF EXISTS wcf1_user_project;
CREATE TABLE wcf1_user_project (
    projectID INT(10) auto_increment PRIMARY KEY,
    userID INT(10) NOT NULL,
    visibility TINYINT(1) NOT NULL DEFAULT 2,
    creationTime INT(10) NOT NULL DEFAULT 0,
    updateTime INT(10) NOT NULL DEFAULT 0,
    tasks MEDIUMINT(7) NOT NULL DEFAULT 0,
    name VARCHAR(191) NOT NULL,
    icon VARCHAR(100) NOT NULL,
    description MEDIUMTEXT,
    KEY (userID),
    KEY (updateTime)
);

-- foreign keys
ALTER TABLE wcf1_user_project ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
