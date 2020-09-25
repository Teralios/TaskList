<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Class        SubtaskAction
 * @package     TaskList
 * @subpackage  wcf\data\task\subtask
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class SubtaskAction extends AbstractDatabaseObjectAction
{
    // inherit vars
    protected $permissionsCreate = ['user.taskList.canUse'];
    protected $permissionsUpdate = ['user.taskList.canUse'];
    protected $permissionsDelete = ['user.taskList.canUse'];
    protected $className = SubtaskEditor::class;
}
