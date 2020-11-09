<?php

namespace theia\data\project;

// imports
use wcf\data\DatabaseObjectDecorator;
use wcf\data\user\UserProfile;
use wcf\system\cache\runtime\UserProfileRuntimeCache;
use wcf\system\exception\SystemException;
use wcf\system\template\plugin\TimeModifierTemplatePlugin;

/**
 * Class        ViewableProject
 * @package     de.teralios.theia
 * @subpackage  theia\data\project
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @property-read int $projectID
 * @property-read int $userID
 * @property-read int $creationTime
 * @property-read int $updateTime
 * @property-read int $tasks
 * @property-read int $visibility
 * @property-read int $status
 * @property-read int $deleteTime
 * @property-read string $name
 * @property-read string $description
 * @property-read string $icon
 */
class ViewableProject extends DatabaseObjectDecorator
{
    // inherit variables
    protected static $baseClass = Project::class;

    /**
     * @var int Represents all open tasks.
     */
    protected $openTasks = 0;

    /**
     * @var int Represents all closed/finished tasks.
     */
    protected $closedTasks = 0;

    /**
     * @var int Represents all aborted tasks.
     */
    protected $abortedTasks = 0;

    /**
     * @var int Represents all tasks in progress.
     */
    protected $tasksInProgress = 0;

    /**
     * @var UserProfile|null
     */
    protected $userProfile = null;

    /**
     * Set statistic information for tasks.
     * @param int $tasksInProgress
     * @param int $closedTasks
     * @param int $abortedTasks
     * @return $this
     */
    public function setTaskInformation(int $tasksInProgress, int $closedTasks, int $abortedTasks): self
    {
        // check count of tasks statistic.
        if (($closedTasks + $abortedTasks + $tasksInProgress) > $this->tasks) {
            throw new \InvalidArgumentException('$tasksInProgress + $closedTasks + $abortedTasks > $tasks');
        }

        // assign task status.
        $this->closedTasks = $closedTasks;
        $this->abortedTasks = $abortedTasks;
        $this->tasksInProgress = $tasksInProgress;

        // calculate open tasks.
        $this->openTasks = $this->tasks - ($this->closedTasks + $this->abortedTasks + $this->tasksInProgress);

        return $this;
    }

    /**
     * @return UserProfile|null
     * @throws SystemException
     */
    public function getUserProfile(): ?UserProfile
    {
        if ($this->userProfile !== null) {
            return $this->userProfile;
        }

        return $this->userProfile = UserProfileRuntimeCache::getInstance()->getObject($this->userID);
    }

    /**
     * Returns open tasks.
     * @return int
     */
    public function getOpenTasks(): int
    {
        return $this->openTasks;
    }

    /**
     * Returns closed/finished tasks.
     * @return int
     */
    public function getClosedTasks(): int
    {
        return $this->closedTasks;
    }

    /**
     * Return aborted tasks.
     * @return int
     */
    public function getAbortedTasks(): int
    {
        return $this->abortedTasks;
    }

    /**
     * Returns tasks in progress.
     * @return int
     */
    public function getTasksInProgress(): int
    {
        return $this->tasksInProgress;
    }

    /**
     * Calculate width of bar for given tasks.
     * @param string $type
     * @return string|null
     */
    public function getWidth(string $type = 'closed'): ?string
    {
        $tasks = 0;
        switch ($type) {
            case 'closed':
                $tasks = $this->closedTasks;
                break;
            case 'aborted':
                $tasks = $this->abortedTasks;
                break;
            case 'progress':
                $tasks = $this->tasksInProgress;
                break;
            default:
                $tasks = $this->openTasks;
        }

        return ($tasks > 0) ? ceil(($tasks / $this->tasks) * (float) 100) . '%' : null;
    }
}
