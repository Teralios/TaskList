<?php
namespace wcf\data\task;

// imports
use wcf\data\DatabaseObjectDecorator;
use wcf\data\task\subtask\ViewableSubtaskList;
use wcf\system\exception\SystemException;

/**
 * Class        ViewableTask
 * @package     TaskList
 * @subpackage  wcf\data\task
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @property-read int $taskID
 * @property-read int $userID
 * @property-read int $created
 * @property-read int $deadline
 * @property-read int $updated
 * @property-read int $visibility
 * @property-read int $priority
 * @property-read int $status
 * @property-read string $title
 * @property-read string $message
 * @property-read int $subtask
 * @property-read int $completed
 */
class ViewableTask extends DatabaseObjectDecorator
{
    // inherit doc
    protected static $baseClass = Task::class;

    /**
     * @var null|ViewableSubtaskList
     */
    protected $subtaskList = null;

    /**
     * Icon map for viewable task.
     */
    const ICON_MAP = [
        Task::STATUS_OPEN => 'fa-square-o',
        Task::STATUS_IN_PROGRESS => 'fa-pencil-square-o',
        Task::STATUS_CLOSED => 'fa-check-square-o'
    ];

    const PRIORITY_CLASS = [
        Task::PRIORITY_ALERT => 'alert',
        Task::PRIORITY_HIGH => 'high',
        Task::PRIORITY_NORMAL => 'normal',
        Task::PRIORITY_LOW => 'low'
    ];

    const STATUS_CLASS = [
        Task::STATUS_OPEN => 'open',
        Task::STATUS_IN_PROGRESS => 'inProgress',
        Task::STATUS_CLOSED => 'closed'
    ];

    /**
     * Return fa icon name.
     * @return string
     */
    public function getIcon(): string
    {
        return ViewableTask::ICON_MAP[$this->status];
    }

    /**
     * @return string
     */
    public function getStatusClass(): string
    {
        return ViewableTask::STATUS_CLASS[$this->status];
    }

    /**
     * @return string
     */
    public function getPriorityClass(): string
    {
        return ViewableTask::PRIORITY_CLASS[$this->priority];
    }

    /**
     * Set subtask list.
     * @param ViewableSubtaskList $subtaskList
     */
    public function setSubtasks(ViewableSubtaskList $subtaskList)
    {
        $this->subtaskList = $subtaskList;
    }

    /**
     * Return subtask list.
     * @return ViewableSubtaskList|null
     */
    public function getSubtasks()//: ?SubtaskList
    {
        return $this->subtaskList;
    }

    /**
     * Read subtasks.
     * @throws SystemException
     */
    public function readSubtasks()//: void
    {
        if ($this->subtaskList !== null) {
            throw new SystemException('Subtask list is already initialized.');
        }
    }
}
