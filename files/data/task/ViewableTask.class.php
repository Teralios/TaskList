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
            throw new SystemException('Subtask list ist already initialized.');
        }
    }
}
