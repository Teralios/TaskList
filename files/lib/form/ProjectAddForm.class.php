<?php

namespace theia\form;

// imports
use theia\data\project\Project;
use theia\data\project\ProjectAction;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\data\processor\CustomFormDataProcessor;
use wcf\system\form\builder\field\dependency\ValueFormFieldDependency;
use wcf\system\form\builder\field\IconFormField;
use wcf\system\form\builder\field\language\ContentLanguageFormField;
use wcf\system\form\builder\field\RadioButtonFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\form\builder\field\UploadFormField;
use wcf\system\form\builder\field\wysiwyg\WysiwygFormField;
use wcf\system\form\builder\IFormDocument;

/**
 * Class        ProjectAddForm
 * @package     de.teralios.theia
 * @subpackage  wcf\form
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class ProjectAddForm extends AbstractFormBuilderForm
{
    // inherit variables
    public $loginRequired = true;
    public $neededPermissions = ['user.theia.canUse'];
    public $objectActionClass = ProjectAction::class;

    /**
     * @inheritdoc
     */
    public function createForm()
    {
        parent::createForm();

        // setting container
        $container = FormContainer::create('settings')->label('theia.project.settings');
        $container->appendChildren([
            RadioButtonFormField::create('iconType')
                ->label('theia.project.icon.type')
                ->options([
                    'default' => 'theia.project.icon.default',
                    'fa' => 'theia.project.icon.fontAwesome',
                    'file' => 'theia.project.icon.file'
                ])
                ->value('default')
                ->required(),
            UploadFormField::create('iconFile')
                ->label('theia.project.icon.file')
                ->imageOnly()
                ->maximum(1)
                ->minimumImageWidth(Project::MIN_WIDTH)
                ->minimumImageHeight(Project::MIN_HEIGHT),
            IconFormField::create('icon')
                ->label('theia.project.icon.fontAwesome'),
            SingleSelectionFormField::create('visibility')
                ->label('theia.project.visibility')
                ->required()
                ->options([
                    Project::VISIBILITY_PRIVATE => 'theia.project.visibility.private',
                    Project::VISIBILITY_FOLLOW  => 'theia.project.visibility.follow',
                    Project::VISIBILITY_PUBLIC  => 'theia.project.visibility.public'
                ])
                ->value(0),
            ContentLanguageFormField::create('languageID')
                ->required(),
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
        $container = FormContainer::create('data')->label('theia.project.data');
        $container->appendChildren([
            TitleFormField::create('name')
                ->maximumLength(191)
                ->required(),
            WysiwygFormField::create('description')
                ->label('theia.project.description')
                ->objectType(Project::OBJECT_TYPE)
                ->maximumLength(2500) // @todo user option
                ->required()
                ->supportAttachments(false)
                ->supportMentions(false)
                ->supportQuotes(false),
        ]);
        $this->form->appendChild($container);

        // data processor for icons
        $iconDataProcessor = new CustomFormDataProcessor('iconFileOrFA', function (IFormDocument $document, array $parameters) {
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
