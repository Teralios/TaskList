<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\DatabaseObjectList;
use wcf\data\task\Task;
use wcf\data\task\TaskList;
use wcf\system\exception\SystemException;

/**
 * Class        SubtaskList
 * @package     TaskList
 * @subpackage  wcf\data\task\subtask
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class SubtaskList extends DatabaseObjectList
{
    public $className = Subtask::class;

    /**
     * Set task sql condition.
     * @param Task $task
     * @return $this
     * @throws SystemException
     */
    public function forTask(Task $task)
    {
        $this->getConditionBuilder()->add(
            $this->getDatabaseTableAlias() . '.taskID = ?',
            [$task->getObjectID()]
        );


        return $this;
    }

    /**
     * Set tasks sql condition.
     * @param TaskList $taskList
     * @return $this
     * @throws SystemException
     */
    public function forTasks(TaskList $taskList)
    {
        $this->getConditionBuilder()->add(
            $this->getDatabaseTableAlias() . '.taskID IN (?)',
            [$taskList->getObjectIDs()]
        );

        return $this;
    }

    /**
     * Set status sql condition.
     * @param int $status
     * @return $this
     * @throws SystemException
     */
    public function withStatus(int $status = Task::STATUS_OPEN)
    {
        $this->getConditionBuilder()->add(
            $this->getDatabaseTableAlias() . '.status = ?',
            [$status]
        );

        return $this;
    }
}
