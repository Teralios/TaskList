<?php
namespace wcf\data\task;

// imports
use wcf\data\DatabaseObjectList;
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
class ViewableTaskList extends DatabaseObjectList
{
    /**
     * @var bool
     */
    protected $withSubtask = false;

    /**
     * Set access level for tasks
     * @param int $accessLevel
     * @throws SystemException
     */
    public function accessLevel($accessLevel = Task::VISIBLE_PUBLIC)
    {
        $this->getConditionBuilder()->add(
            $this->getDatabaseTableAlias() . '.visibility >= ?',
            [$accessLevel]
        );
    }

    /**
     * Set load subtasks.
     */
    public function withSubtask()
    {
        $this->withSubtask = true;
    }

    /**
     * @inheritdoc
     * @throws SystemException
     */
    public function readObjects()
    {
        parent::readObjects();

        if ($this->withSubtask === true) {
            $subtaskList = ViewableSubtaskList::buildForTasks($this);
            $subtaskList->readObjects();

            /** @var ViewableTask $object */
            foreach ($this->objects as $object) {
                $objectSubtaskList = new ViewableSubtaskList();
                $objectSubtaskList->setTask($object)->setObjects($subtaskList);
                $object->setSubtasks($objectSubtaskList);
            }
        }
    }
}
