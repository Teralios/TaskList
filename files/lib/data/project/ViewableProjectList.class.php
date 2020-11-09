<?php

namespace theia\data\project;

// imports
use theia\data\task\Task;
use wcf\system\cache\runtime\UserProfileRuntimeCache;
use wcf\system\database\exception\DatabaseQueryException;
use wcf\system\database\exception\DatabaseQueryExecutionException;
use wcf\system\exception\SystemException;
use wcf\system\WCF;

/**
 * Class        ViewableProjectList
 * @package     de.teralios.theia
 * @subpackage  theia\data\project
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class ViewableProjectList extends ProjectList
{
    // inherit variables
    public $decoratorClassName = ViewableProject::class;
    /**
     * @var ViewableProject[]
     */
    public $objects = [];

    /**
     * @var bool Load statistic.
     */
    protected $loadStatistic = false;

    /**
     * @var bool Load user
     */
    protected $loadUser = false;

    /**
     * @param bool $loadStatistic
     * @return $this
     */
    public function withStatistic(bool $loadStatistic = true): self
    {
        $this->loadStatistic = $loadStatistic;

        return $this;
    }

    /**
     * @param bool $withUser
     * @return $this
     */
    public function withUser(bool $withUser = true): self
    {
        $this->loadUser = $withUser;

        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     * @throws SystemException
     */
    public function readObjects(): self
    {
        parent::readObjects();

        // load user profiles
        if ($this->loadUser) {
            $userIDs = [];
            /** @var Project $project */
            foreach ($this->objects as $project) {
                $userIDs[] = $project->userID;
            }

            UserProfileRuntimeCache::getInstance()->cacheObjectIDs($userIDs);
        }

        // load
        if ($this->loadStatistic && !empty($this->objectIDs)) {
            $this->loadTaskStatistic();
        }

        return $this;
    }

    /**
     * Load statistics for tasks.
     * @throws DatabaseQueryException
     * @throws DatabaseQueryExecutionException
     */
    protected function loadTaskStatistic(): void
    {
        $sqlSelects = Task::getDatabaseTableAlias() . '.projectID, ';
        $sqlSelects .= '(SELECT COUNT(taskID) FROM ' . Task::getDatabaseTableNAme() . ' WHERE projectID = ' . Task::getDatabaseTableAlias() . '.projectID AND status = 1) as progress';
        $sqlSelects .= '(SELECT COUNT(taskID) FROM ' . Task::getDatabaseTableNAme() . ' WHERE projectID = ' . Task::getDatabaseTableAlias() . '.projectID AND status = 2) as aborted';
        $sqlSelects .= '(SELECT COUNT(taskID) FROM ' . Task::getDatabaseTableNAme() . ' WHERE projectID = ' . Task::getDatabaseTableAlias() . '.projectID AND status = 3) as closed';

        $sql = 'SELECT ' . $sqlSelects .'
                FROM   ' . Task::getDatabaseTableName() . ' ' . Task::getDatabaseTableAlias() . '
                WHERE  projectID IN (?' . str_repeat(', ?', count($this->objectIDs) - 1) . ')';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute($this->objectIDs);

        while (($row = $statement->fetchArray()) !== false) {
            $projectID = $row['projectID'];

            if (isset($this->objects[$projectID])) {
                $this->objects[$projectID]->setTaskInformation($row['progress'], $row['closed'], $row['aborted']);
            }
        }
    }
}
