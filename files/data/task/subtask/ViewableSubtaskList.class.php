<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\DatabaseObjectList;
use wcf\data\task\ViewableTask;
use wcf\data\task\ViewableTaskList;
use wcf\system\exception\SystemException;

/**
 * Class        ViewableSubtaskList
 * @package     TaskList
 * @subpackage  wcf\data\task\subtask
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class ViewableSubtaskList extends DatabaseObjectList
{
    // inherit vars
    public $decoratorClassName = ViewableSubtask::class;

    /**
     * @var ViewableTask
     */
    public $task = null;

    /**
     * Set task id.
     * @param ViewableTask $task
     * @return static
     */
    public function setTask(ViewableTask $task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Turns general taken general subtask list and takes subtask for task.
     * @param static $subtaskList
     * @return static
     * @throws SystemException
     */
    public function setObjects(ViewableSubtaskList $subtaskList)
    {
        if ($this->task === null) {
            throw new SystemException('setObjects is only supported when "' . ViewableTask::class . '" is set.');
        }
        /** @var ViewableSubtask $subtask */
        foreach ($subtaskList as $subtask)
        {
            if ($subtask->taskID == $this->task->getObjectID()) {
                $this->objectIDs[] = $subtask->getObjectID();
                $this->objects[$subtask->getObjectID()] = $subtask;
                $this->indexToObject[] = $subtask->getObjectID();
            }
        }

        return $this;
    }

    /**
     * Return a prepared subtask list for one task.
     * @param ViewableTask $task
     * @return static
     * @throws SystemException
     */
    public static function buildForTask(ViewableTask $task)//: ViewableSubtaskList
    {
        $subtaskList = new ViewableSubtaskList();
        $subtaskList->getConditionBuilder()->add(
            $subtaskList->getDatabaseTableAlias() . '.taskID = ?',
            [$task->getObjectID()]
        );

        return $subtaskList;
    }

    /**
     * Returns a prepared subtask list for a list of tasks.
     * @param ViewableTaskList $taskList
     * @return static|null
     * @throws SystemException
     */
    public static function buildForTasks(ViewableTaskList $taskList)
    {
        $taskIDs = $taskList->getObjectIDs();

        if (!count($taskIDs)) {
            return null;
        }

        $subtaskList = new ViewableSubtaskList();
        $subtaskList->getConditionBuilder()->add(
            $subtaskList->getDatabaseTableAlias() . '.taskID IN (?' . str_repeat(', ?', count($taskIDs) - 1) . ')',
            $taskIDs
        );

        return $subtaskList;
    }
}