-- project type table
DROP TABLE IF EXISTS theia1_type;
CREATE TABLE theia1_type (
    typeID INT(10) auto_increment PRIMARY KEY,
    name VARCHAR(191) NOT NULL DEFAULT '',
    icon VARCHAR(100) NOT NULL DEFAULT '',
    position SMALLINT(3) NOT NULL DEFAULT 0,
    KEY (position)
);

-- project table
DROP TABLE IF EXISTS theia1_project;
CREATE TABLE theia1_project (
    projectID INT(10) auto_increment PRIMARY KEY,
    typeID INT(10) NULL,
    userID INT(10) NOT NULL,
    visibility TINYINT(1) NOT NULL DEFAULT 2,
    creationTime INT(10) NOT NULL DEFAULT 0,
    updateTime INT(10) NOT NULL DEFAULT 0,
    tasks MEDIUMINT(7) NOT NULL DEFAULT 0,
    name VARCHAR(191) NOT NULL DEFAULT '',
    icon VARCHAR(100) NOT NULL DEFAULT '',
    description MEDIUMTEXT,
    KEY (visibility),
    KEY (userID),
    KEY (updateTime)
);

-- foreign keys
ALTER TABLE theia1_project ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE theia1_project ADD FOREIGN KEY (typeID) REFERENCES theia1_type (typeID) ON DELETE SET NULL;
