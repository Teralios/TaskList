<?php

namespace wcf\data\user\project;

// imports
use wcf\data\DatabaseObject;

/**
 * Class        Project
 * @package     TaskList
 * @subpackage  wcf\data\user\project
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @property-read int $projectID
 * @property-read int $userID
 * @property-read int $creationTime
 * @property-read int $updateTime
 * @property-read int $tasks
 * @property-read int $visibility
 * @property-read string $name
 * @property-read string $description
 */
class Project extends DatabaseObject
{
    // const
    const VISIBILITY_PRIVATE = 0;
    const VISIBILITY_FOLLOW  = 1;
    const VISIBILITY_PUBLIC  = 2;
    const OBJECT_TYPE = 'de.teralios.taskList.project';#

    // inherit variables
    protected static $databaseTableName = 'user_project';
    protected static $databaseTableIndexName = 'projectID';
}
