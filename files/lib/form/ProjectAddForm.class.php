<?php

namespace wcf\form;

// imports
use wcf\data\user\project\Project;
use wcf\data\user\project\ProjectAction;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\data\processor\CustomFormDataProcessor;
use wcf\system\form\builder\field\dependency\ValueFormFieldDependency;
use wcf\system\form\builder\field\IconFormField;
use wcf\system\form\builder\field\RadioButtonFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\form\builder\field\UploadFormField;
use wcf\system\form\builder\field\wysiwyg\WysiwygFormField;
use wcf\system\form\builder\IFormDocument;

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

        // setting container
        $container = FormContainer::create('settings')->label('wcf.taskList.project.settings');
        $container->appendChildren([
            RadioButtonFormField::create('iconType')
                ->label('wcf.taskList.project.icon.type')
                ->options([
                    'default' => 'wcf.taskList.project.icon.default',
                    'fa' => 'wcf.taskList.project.icon.fontAwesome',
                    'file' => 'wcf.taskList.project.icon.file'
                ])
                ->value('default')
                ->required(),
            UploadFormField::create('iconFile')
                ->label('wcf.taskList.project.icon.file')
                ->imageOnly()
                ->maximum(1)
                ->minimumImageWidth(Project::MIN_WIDTH)
                ->minimumImageHeight(Project::MIN_HEIGHT),
            IconFormField::create('icon')
                ->label('wcf.taskList.project.icon.fontAwesome'),
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

        // icon dependencies
        $dependencyFile = ValueFormFieldDependency::create('iconIsFile')
            ->field($container->getNodeById('iconType'))
            ->values(['file']);
        $container->getNodeById('iconFile')->addDependency($dependencyFile);
        $dependencyFA = ValueFormFieldDependency::create('iconIsFA')
            ->field($container->getNodeById('iconType'))
            ->values(['fa']);
        $container->getNodeById('icon')->addDependency($dependencyFA);

        // add settings container
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

        // data processor for icons
        $iconDataProcessor = new CustomFormDataProcessor('iconFileOrFA', function(IFormDocument $document, array $parameters) {
            $parameters['iconType'] = $parameters['data']['iconType'] ?? 'default';
            unset($parameters['data']['iconType']);

            if ($parameters['iconType'] === 'file') {
                unset($parameters['data']['icon']);
            }

            return $parameters;
        });

        $this->form->getDataHandler()->addProcessor($iconDataProcessor);
    }
}
