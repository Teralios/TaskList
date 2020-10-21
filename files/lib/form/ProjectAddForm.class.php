<?php

namespace wcf\form;

// imports
use wcf\data\user\project\Project;
use wcf\data\user\project\ProjectAction;
use wcf\system\exception\SystemException;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\IconFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\form\builder\field\wysiwyg\WysiwygFormField;
use wcf\system\page\PageLocationManager;

/**
 * Class        ProjectAddForm
 * @package     TaskList
 * @subpackage  wcf\form
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class ProjectAddForm extends AbstractFormBuilderForm
{
    // inherit variables
    public $loginRequired = true;
    public $neededPermissions = ['user.taskList.canUse'];
    public $objectActionClass = ProjectAction::class;

    /**
     * @inheritdoc
     */
    public function createForm()
    {
        parent::createForm();

        // settings container
        $container = FormContainer::create('settings')->label('wcf.taskList.project.settings');
        $container->appendChildren([
            IconFormField::create('icon')
                ->label('wcf.taskList.project.icon'),
            SingleSelectionFormField::create('visibility')
                ->label('wcf.taskList.project.visibility')
                ->required()
                ->options([
                    Project::VISIBILITY_PRIVATE => 'wcf.taskList.project.visibility.private',
                    Project::VISIBILITY_FOLLOW  => 'wcf.taskList.project.visibility.follow',
                    Project::VISIBILITY_PUBLIC  => 'wcf.taskList.project.visibility.public'
                ])
                ->value(0)
        ]);
        $this->form->appendChild($container);

        // data container
        $container = FormContainer::create('data')->label('wcf.taskList.project.data');
        $container->appendChildren([
            TitleFormField::create('name')
                ->maximumLength(191)
                ->required(),
            WysiwygFormField::create('description')
                ->label('wcf.taskList.project.description')
                ->objectType(Project::OBJECT_TYPE)
                ->maximumLength(2500) // @todo user option
                ->required()
                ->supportAttachments(false)
                ->supportMentions(false)
                ->supportQuotes(false),
        ]);
        $this->form->appendChild($container);
    }
}
