<?php
namespace theia\data\task;

// imports
use wcf\data\DatabaseObject;

/**
 * Class        Task
 * @package     de.teralios.theia
 * @subpackage  theia\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class Task extends DatabaseObject
{
    protected static $databaseTableName = 'task';
    protected static $databaseTableIndexName = 'taskID';
}
