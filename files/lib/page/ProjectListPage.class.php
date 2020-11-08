<?php

namespace theia\page;

// imports
use theia\data\project\Project;
use theia\data\project\ProjectList;
use wcf\page\MultipleLinkPage;
use wcf\system\WCF;

class ProjectListPage extends MultipleLinkPage
{
    // inherit variables
    public $objectListClassName = ProjectList::class;

    public function assignVariables()
    {
        WCF::getTPL()->assign('project', new Project(1));
    }
}
