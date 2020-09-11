<?php
namespace wcf\data\task;

// imports
use wcf\data\task\subtask\ViewableSubtaskList;
use wcf\system\exception\SystemException;

/**
 * Class        ViewableTaskList
 * @package     TaskList
 * @subpackage  wcf\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class ViewableTaskList extends TaskList
{
    // inherit vars
    public $decoratorClassName = ViewableTask::class;

    /**
     * @var bool
     */
    protected $withSubtask = false;

    /**
     * Set load subtasks.
     */
    public function withSubtask()
    {
        $this->withSubtask = true;

        return $this;
    }

    /**
     * @inheritdoc
     * @throws SystemException
     */
    public function readObjects()
    {
        parent::readObjects();

        if ($this->withSubtask === true) {
            $subtaskList = new ViewableSubtaskList();
            $subtaskList->forTasks($this)->readObjects();

            /** @var ViewableTask $object */
            foreach ($this->objects as $object) {
                $objectSubtaskList = new ViewableSubtaskList();
                $objectSubtaskList->setTask($object)->setObjects($subtaskList);
                /** @scrutinizer ignore-call */$object->setSubtasks($objectSubtaskList);
            }
        }
    }
}
