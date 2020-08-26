<?php

namespace wcf\data\task;

// imports
use wcf\data\DatabaseObjectEditor;

/**
 * Class        TaskEditor
 * @package     TaskList
 * @subpackage  wcf\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class TaskEditor extends DatabaseObjectEditor
{
    // inherit vars
    protected static $baseClass = Task::class;
}
