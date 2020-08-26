<?php

namespace wcf\form;

// imports
use wcf\data\task\TaskAction;

/**
 * Class        TaskAddForm
 * @package     TaskList
 * @subpackage  wcf\form
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class TaskAddForm extends AbstractFormBuilderForm
{
    // inherit vars
    public $objectActionClass = TaskAction::class;
    public $formAction = 'create';
}