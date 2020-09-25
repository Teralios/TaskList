<?php

namespace wcf\data\task;

// imports
use wcf\data\DatabaseObjectEditor;
use wcf\data\IStorableObject;
use wcf\system\WCF;

/**
 * Class        TaskEditor
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
class TaskEditor extends DatabaseObjectEditor
{
    // inherit vars
    protected static $baseClass = Task::class;

    /**
     * @inheritdoc
     * @param array $parameters
     * @return mixed|IStorableObject
     */
    public static function create(array $parameters = [])
    {
        $parameters['userID'] = WCF::getUser()->getUserID();
        return parent::create($parameters);
    }

    /**
     * Cast for update counters.
     * @param int $num
     */
    public function updateSubtaskCounter(int $num)
    {
        $this->updateCounters(['subtasks' => $num]);
    }

    /**
     * Cast for update counters.
     * @param int $num
     */
    public function updateCompletedCounter(int $num)
    {
        $this->updateCounters(['completed' => $num]);
    }

}
