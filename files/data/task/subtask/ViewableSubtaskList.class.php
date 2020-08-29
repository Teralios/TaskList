<?php

namespace wcf\data\task\subtask;

// imports
use wcf\data\task\ViewableTask;
use wcf\system\exception\SystemException;

/**
 * Class        ViewableSubtaskList
 * @package     TaskList
 * @subpackage  wcf\data\task\subtask
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class ViewableSubtaskList extends SubtaskList
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

        // reset objects
        $this->objectIDs = $this->indexToObject = null;
        $this->objects = [];

        // set objects from main subtask list.
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
}
