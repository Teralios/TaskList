<?php

namespace theia\acp\form;

// imports
use theia\data\type\Type;
use theia\data\type\TypeAction;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\IconFormField;
use wcf\system\form\builder\field\ShowOrderFormField;
use wcf\system\form\builder\field\TitleFormField;

class TypeAddForm extends AbstractFormBuilderForm
{
    public $activeMenuItem = 'theia.acp.menu.TypeAdd';
    public $neededPermissions = ['admin.theia.type.canManage'];
    public $objectActionClass = TypeAction::class;

    public function createForm()
    {
        parent::createForm();

        $lastPosition = Type::getLastPosition();
        $positions = [];
        for ($i = 1; $i <= $lastPosition; $i++) {
            $positions[$i] = $i + 1;
        }

        $container = FormContainer::create('main');
        $container->appendChildren([
            TitleFormField::create('name')
                ->i18nRequired(),
            IconFormField::create('icon')
                ->required(),
            ShowOrderFormField::create('position')
                ->options($positions)
                ->value($lastPosition),
        ]);

        $this->form->appendChild($container);
    }

    public function readData()
    {
        parent::readData();
    }
}
