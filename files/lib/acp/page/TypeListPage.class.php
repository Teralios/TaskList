<?php

namespace theia\acp\page;

// imports
use theia\data\type\TypeList;
use wcf\page\MultipleLinkPage;

class TypeListPage extends MultipleLinkPage
{
    public $activeMenuItem = 'theia.acp.menu.TypeList';
    public $neededPermissions = ['admin.theia.type.canManage'];
    public $objectListClassName = TypeList::class;
}
