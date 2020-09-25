<?php

namespace wcf\data\task;

// imports
use wcf\data\DatabaseObjectList;
use wcf\system\exception\SystemException;

/**
 * Class        TaskList
 * @package     TaskList
 * @subpackage  wcf\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class TaskList extends DatabaseObjectList
{
    // inherit vars
    public $className = Task::class;

    /**
     * Set user sql condition.
     *
     * For optimal sql performance:
     * 1. fromUser()
     * 2. withAccessLevel()
     * 3. withPriorityLevel()
     * 4. withStatus()
     *
     * @param int $userID
     * @throws SystemException
     * @return static
     */
    public function fromUser(int $userID)
    {
        $this->getConditionBuilder()->add(
            $this->getDatabaseTableAlias() . '.userID = ?',
            [$userID]
        );

        return $this;
    }

    /**
     * Set access level sql condition
     *
     * For optimal sql performance:
     * 1. fromUser()
     * 2. withAccessLevel()
     * 3. withPriorityLevel()
     * 4. withStatus()
     *
     * @param int $accessLevel
     * @throws SystemException
     * @return static
     */
    public function withAccessLevel(int $accessLevel = Task::VISIBLE_PUBLIC)
    {
        $this->getConditionBuilder()->add(
            $this->getDatabaseTableAlias() . '.visibility >= ?',
            [$accessLevel]
        );

        return $this;
    }

    /**
     * Set priority sql condition.
     *
     * For optimal sql performance:
     * 1. fromUser()
     * 2. withAccessLevel()
     * 3. withPriorityLevel()
     * 4. withStatus()
     *
     * @param int $priorityLevel
     * @param bool $isMin Level is minimum border for show
     * @throws SystemException
     * @return static
     */
    public function withPriorityLevel(int $priorityLevel = Task::PRIORITY_NORMAL, bool $isMin = false)
    {
        $this->getConditionBuilder()->add(
            $this->getDatabaseTableAlias() . '.priority ' . (($isMin) ? '>=' : '=') . ' ?',
            [$priorityLevel]
        );

        return $this;
    }

    /**
     * Set status sql condition.
     *
     * For optimal sql performance:
     * 1. fromUser()
     * 2. withAccessLevel()
     * 3. withPriorityLevel()
     * 4. withStatus()
     *
     * @param int $status
     * @throws SystemException
     * @return static
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
