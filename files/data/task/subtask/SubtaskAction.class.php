<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\AbstractDatabaseObjectAction;

class SubtaskAction extends AbstractDatabaseObjectAction
{
    protected $permissionsCreate = ['user.taskList.canUse'];
    protected $permissionsUpdate = ['user.taskList.canUse'];
    protected $permissionsDelete = ['user.taskList.canUse'];
    protected $className = SubtaskEditor::class;
}