<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\DatabaseObjectList;

/**
 * Class        SubtaskList
 * @package     TaskList
 * @subpackage  wcf\data\task\subtask
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class SubtaskList extends DatabaseObjectList
{
    public $className = Subtask::class;
}
