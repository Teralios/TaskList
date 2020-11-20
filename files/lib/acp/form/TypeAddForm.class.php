<?php

namespace theia\acp\form;

// imports
use theia\data\type\TypeAction;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\TitleFormField;

class TypeAddForm extends AbstractFormBuilderForm
{
    public $activeMenuItem = 'theia.acp.menu.TypeAdd';
    public $neededPermissions = ['admin.theia.type.canManage'];
    public $objectActionClass = TypeAction::class;

    public function createForm()
    {
        parent::createForm();

        $container = FormContainer::create('main');
        $container->appendChildren([
            TitleFormField::create('name')
                ->i18nRequired()
        ]);
    }

    public function readData()
    {
        parent::readData();

        // position set position options:
    }
}
