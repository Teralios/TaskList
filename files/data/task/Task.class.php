<?php

namespace wcf\data\task;

// imports
use wcf\data\DatabaseObject;

/**
 * Class        Task
 * @package     TaskList
 * @subpackage  wcf\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class Task extends DatabaseObject
{
    // inherit var
    protected static $databaseTableName = 'task';
    protected static $databaseTableIndexName = 'taskID';

    // visible status
    const VISIBLE_PRIVATE = 0;
    const VISIBLE_FOLLOWER = 1;
    const VISIBLE_PUBLIC = 2;

    // task status
    const STATUS_OPEN = 0;
    const STATUS_IN_PROCESS = 1;
    const STATUS_FINISHED = 2;
}
