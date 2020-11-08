<?php

namespace theia\data\project;

// imports
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\html\input\node\HtmlInputNodeProcessor;
use wcf\system\WCF;

class ProjectAction extends AbstractDatabaseObjectAction
{
    // inherit variables
    protected $className = ProjectEditor::class;
    protected $permissionsCreate = ['user.theia.canUse'];
    protected $permissionsUpdate = ['user.theia.canUse', 'user.theia.canEdit'];
    protected $permissionsDelete = ['user.theia.canUse', 'user.theia.canDelete'];

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

        // create base object.
        $project = parent::create();

        // icon
        if ($this->parameters['iconType'] === 'file') {
            $projectEditor = new ProjectEditor($project);
            $projectEditor->setIcon($this->parameters['iconFile'][0]);
        }

        return $project;
    }
}
