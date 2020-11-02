<?php

namespace wcf\page;

// imports
use wcf\data\user\project\Project;
use wcf\data\user\project\ProjectList;
use wcf\system\WCF;

class ProjectListPage extends MultipleLinkPage
{
    // inherit variables
    public $objectListClassName = ProjectList::class;

    public function assignVariables()
    {
        WCF::getTPL()->assign('project', new Project(12));
    }
}
