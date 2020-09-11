-- task table
DROP TABLE IF EXISTS wcf1_task;
CREATE TABLE wcf1_task(
    taskID INT(10) NOT NULL auto_increment PRIMARY KEY,
    userID INT(10) NOT NULL,
    created INT(10) NOT NULL DEFAULT 0,
    deadline INT(10) NOT NULL DEFAULT 0,
    updated INT(10) NOT NULL DEFAULT 0,
    noticeTime INT(10) NOT NULL DEFAULT 0,
    sendNotice TINYINT(1) NOT NULL DEFAULT 0,
    visibility TINYINT(1) NOT NULL DEFAULT 0,
    priority TINYINT(1) NOT NULL DEFAULT 1,
    status TINYINT(1) NOT NULL DEFAULT 0,
    title VARCHAR(191) NOT NULL DEFAULT '',
    message MEDIUMTEXT,
    subtasks MEDIUMINT(4) NOT NULL DEFAULT 0,
    completed MEDIUMINT(4) NOT NULL DEFAULT 0,
    KEY (userID),
    KEY (visibility),
    KEY (status),
    KEY (created),
    KEY (deadline),
    KEY (userID, visibility),
    KEY (userID, status),
    KEY (userID, visibility, status)
);

-- subtask table
DROP TABLE IF EXISTS wcf1_subtask;
CREATE TABLE wcf1_subtask(
    subtaskID INT(10) NOT NULL auto_increment PRIMARY KEY,
    taskID INT(10) NOT NULL,
    created INT(10) NOT NULL DEFAULT 0,
    updated INT(10) NOT NULL DEFAULT 0,
    status TINYINT(1) NOT NULL DEFAULT 0,
    title VARCHAR(191) NOT NULL DEFAULT '',
    message MEDIUMTEXT,
    KEY (taskID),
    KEY (created)
);

-- keys
ALTER TABLE wcf1_task ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE wcf1_subtask ADD FOREIGN KEY (taskID) REFERENCES wcf1_task (taskID) ON DELETE CASCADE;
