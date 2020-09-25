<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\DatabaseObjectEditor;

/**
 * Class        SubtaskEditor
 * @package     TaskList
 * @subpackage  wcf\data\task\subtask
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class SubtaskEditor extends DatabaseObjectEditor
{
    // inherit doc
    protected static $baseClass = Subtask::class;
}
