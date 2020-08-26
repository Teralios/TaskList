<?php

namespace wcf\data\task;

// imports
use wcf\data\DatabaseObjectList;

/**
 * Class        TaskList
 * @package     TaskList
 * @subpackage  wcf\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class TaskList extends DatabaseObjectList
{
    // inherit vars
    public $className = Task::class;
}
