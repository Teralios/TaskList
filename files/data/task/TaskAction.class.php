<?php

namespace wcf\data\task;

// imports
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Class        TaskAction
 * @package     TaskList
 * @subpackage  wcf\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class TaskAction extends AbstractDatabaseObjectAction
{
    // inherit vars
    protected $permissionsCreate = ['user.taskList.canUse'];
    protected $permissionsUpdate = ['user.taskList.canUse'];
    protected $permissionsDelete = ['user.taskList.canUse'];
    protected $className = TaskEditor::class;
}
