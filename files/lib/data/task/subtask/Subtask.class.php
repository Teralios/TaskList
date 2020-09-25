<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\DatabaseObject;

/**
 * Class        Subtask
 * @package     TaskList
 * @subpackage  wcf\data\task\subtask
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @property-read int $subtaskID
 * @property-read int $taskID
 * @property-read int $created
 * @property-read int $updated
 * @property-read int $status
 * @property-read string $title
 * @property-read string $message
 */
class Subtask extends DatabaseObject
{
    // inherit vars
    protected static $databaseTableName = 'subtask';
    protected static $databaseTableIndexName = 'subtaskID';
}
