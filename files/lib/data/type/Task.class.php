<?php
namespace theia\data\task;

// imports
use wcf\data\DatabaseObject;

class Task extends DatabaseObject
{
    protected static $databaseTableName = 'task';
    protected static $databaseTableIndexName = 'taskID';
}
