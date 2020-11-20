-- project type table
DROP TABLE IF EXISTS theia1_type;
CREATE TABLE theia1_type (
    typeID INT(10) auto_increment PRIMARY KEY,
    position SMALLINT(3) NOT NULL DEFAULT 0,
    name VARCHAR(191) NOT NULL DEFAULT '',
    icon VARCHAR(100) NOT NULL DEFAULT '',
    KEY (position)
);

-- project table
DROP TABLE IF EXISTS theia1_project;
CREATE TABLE theia1_project (
    projectID INT(10) auto_increment PRIMARY KEY,
    typeID INT(10) NULL,
    userID INT(10) NOT NULL,
    languageID INT(10) NULL DEFAULT NULL,
    visibility TINYINT(1) NOT NULL DEFAULT 2,
    status TINYINT(1) NOT NULL DEFAULT 1,
    creationTime INT(10) NOT NULL DEFAULT 0,
    updateTime INT(10) NOT NULL DEFAULT 0,
    deleteTime INT(10) NOT NULL DEFAULT 0,
    tasks MEDIUMINT(7) NOT NULL DEFAULT 0,
    name VARCHAR(191) NOT NULL DEFAULT '',
    icon VARCHAR(100) NOT NULL DEFAULT '',
    description MEDIUMTEXT,
    KEY (visibility, status),
    KEY (userID, status),
    KEY (languageID),
    KEY (updateTime),
    KEY (creationTime)
);

DROP TABLE IF EXISTS theia1_task;
CREATE TABLE theia1_task (
    taskID INT(10) NOT NULL auto_increment,
    projectID INT(10) NOT NULL,
    creationTime INT(10) NOT NULL DEFAULT 0,
    updateTime INT(10) NOT NULL DEFAULT 0,
    deadline INT(10) NOT NULL DEFAULT 0,
    status TINYINT(1) NOT NULL DEFAULT 0, -- 0: Open, 1: in progress, 2: aborted, 3: closed
    title VARCHAR(191) NOT NULL DEFAULT '',
    description MEDIUMTEXT,
    KEY (projectID, status),
    KEY (updateTime),
    KEY (deadline),
    KEY (creationTime)
);

-- foreign keys
ALTER TABLE theia1_project ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE theia1_project ADD FOREIGN KEY (typeID) REFERENCES theia1_type (typeID) ON DELETE SET NULL;
ALTER TABLE theia1_project ADD FOREIGN KEY (languageID) REFERENCES wcf1_language (languageID) ON DELETE SET NULL;
ALTER TABLE theia1_task ADD FOREIGN KEY (projectID) REFERENCES theia1_project (projectID) ON DELETE CASCADE;
