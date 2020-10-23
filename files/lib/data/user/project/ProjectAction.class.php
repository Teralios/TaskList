<?php

namespace wcf\data\user\project;

// imports
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\html\input\node\HtmlInputNodeProcessor;
use wcf\system\WCF;

class ProjectAction extends AbstractDatabaseObjectAction
{
    // inherit variables
    protected $className = ProjectEditor::class;
    protected $permissionsCreate = ['user.taskList.canUse'];
    protected $permissionsUpdate = ['user.taskList.canUse', 'user.taskList.canEdit'];
    protected $permissionsDelete = ['user.taskList.canUse', 'user.taskList.canDelete'];

    public function create()
    {
        // set description from wysiwyg field.
        /** @var HtmlInputNodeProcessor $description */
        $description = $this->parameters['description_htmlInputProcessor'];
        $this->parameters['data']['description'] = $description->getHtml();

        // user id
        $this->parameters['data']['userID'] = WCF::getUser()->userID;

        // time
        $this->parameters['data']['creationTime'] = $this->parameters['data']['updateTime'] = TIME_NOW;

        parent::create();
    }
}
