<?php

namespace theia\data\type;

// imports
use wcf\data\AbstractDatabaseObjectAction;

class TypeAction extends AbstractDatabaseObjectAction
{
    protected $permissionsCreate = ['admin.theia.type.canManage'];
}
