<?php

namespace wcf\form;

// imports
use wcf\data\task\Task;
use wcf\data\task\TaskAction;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\container\wysiwyg\WysiwygFormContainer;
use wcf\system\form\builder\field\DateFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\TitleFormField;

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

    public function createForm()
    {
        parent::createForm();

        // general container
        $containerGeneral = FormContainer::create('general');
        $containerGeneral->label('wcf.user.taskList.general');
        $containerGeneral->appendChildren([
            TitleFormField::create('title')
                ->required()
                ->maximumLength(191),
            DateFormField::create('deadline')
                ->label('wcf.user.taskList.deadline')
                ->required()
                ->earliestDate(TIME_NOW),
            SingleSelectionFormField::create('visibility')
                ->label('wcf.user.taskList.visibility')
                ->required()
                ->options([
                    Task::VISIBLE_PRIVATE   => 'wcf.user.taskList.visibility.private',
                    Task::VISIBLE_FOLLOWER  => 'wcf.user.taskList.visibility.follower',
                    Task::VISIBLE_PUBLIC    => 'wcf.user.taskList.visibility.public'
                ]),
            SingleSelectionFormField::create('priority')
                ->label('wcf.user.taskList.priority')
                ->required()
                ->options([
                    Task::PRIORITY_LOW      => 'wcf.user.taskList.priority.low',
                    Task::PRIORITY_NORMAL   => 'wcf.user.taskList.priority.normal',
                    Task::PRIORITY_HIGH     => 'wcf.user.taskList.priority.high',
                    Task::PRIORITY_ALERT    => 'wcf.user.taskList.priority.alert'
                ])
                ->value(Task::PRIORITY_NORMAL)
        ]);
        $this->form->appendChild($containerGeneral);

        // message
        $messageContainer = WysiwygFormContainer::create('message')
            ->required();
        $this->form->appendChild($messageContainer);
    }
}