<?php

namespace wcf\form;

// imports
use wcf\data\task\Task;
use wcf\data\task\TaskAction;
use wcf\system\exception\SystemException;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\container\wysiwyg\WysiwygFormContainer;
use wcf\system\form\builder\field\DateFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\menu\user\UserMenu;

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
    public $activeUserMenuItem = 'wcf.user.menu.taskList.list';

    /**
     * @inheritdoc
     * @throws SystemException
     */
    public function readParameters()
    {
        parent::readParameters();

        /** @scrutinizer ignore-call */UserMenu::getInstance()->setActiveMenuItem($this->activeMenuItem);
    }

    /**
     * @inheritdoc
     */
    public function createForm()
    {
        parent::createForm();

        // general container
        $containerGeneral = FormContainer::create('general')
            ->label('wcf.user.taskList.general')
            ->appendChildren([
                TitleFormField::create('title')
                    ->required()
                    ->maximumLength(191),
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

        // time container
        $containerTime = FormContainer::create('time')
            ->label('wcf.user.taskList.time')
            ->appendChildren([
                DateFormField::create('deadline')
                    ->label('wcf.user.taskList.deadline')
                    ->required()
                    ->earliestDate(TIME_NOW)
                    ->supportsTime(),
                SingleSelectionFormField::create('notice')
                    ->label('wcf.user.taskList.notice')
                    ->options([
                        0 => 'wcf.user.taskList.notice.not',
                        1 => 'wcf.user.taskList.notice.hour',
                        2 => 'wcf.user.taskList.notice.day',
                        3 => 'wcf.user.taskList.notice.week'
                    ])
                    ->value(0)
            ]);
        $this->form->appendChild($containerTime);

        // message
        $messageContainer = WysiwygFormContainer::create('message')
            ->messageObjectType('de.teralios.taskList.message')
            ->supportSmilies()
            ->maximumLength(5000) // @todo implement group option.
            ->required();
        $this->form->appendChild($messageContainer);

        // additional data
        // @todo url to a thread, bugtracker or other maybe?
    }
}
