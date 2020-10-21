<?php

namespace wcf\page;

// imports
use wcf\data\user\project\ProjectList;

class ProjectListPage extends MultipleLinkPage
{
    // inherit variables
    public $objectListClassName = ProjectList::class;
}
