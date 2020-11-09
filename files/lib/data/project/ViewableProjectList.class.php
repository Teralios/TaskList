<?php

namespace theia\data\project;

use theia\data\task\Task;
use wcf\system\cache\runtime\UserProfileRuntimeCache;
use wcf\system\WCF;

class ViewableProjectList extends ProjectList
{
    // inherit variables
    public $decoratorClassName = ViewableProject::class;
    /**
     * @var ViewableProject[]
     */
    public $objects = [];

    protected $loadStatistic = false;
    protected $loadUser = false;

    public function withStatistic(bool $loadStatistic = true): self
    {
        $this->loadStatistic = $loadStatistic;

        return $this;
    }

    public function withUser(bool $withUser = true): self
    {
        $this->loadUser = $withUser;

        return $this;
    }

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

    protected function loadTaskStatistic(): void
    {
        $sqlSelects = Task::getDatabaseTableAlias() . '.projectID, ';
        $sqlSelects .= '(SELECT COUNT(taskID) FROM ' . Task::getDatabaseTableNAme() . ' WHERE projectID = ' . Task::getDatabaseTableAlias() . '.projectID AND status = 1) as progress';
        $sqlSelects .= '(SELECT COUNT(taskID) FROM ' . Task::getDatabaseTableNAme() . ' WHERE projectID = ' . Task::getDatabaseTableAlias() . '.projectID AND status = 2) as aborted';
        $sqlSelects .= '(SELECT COUNT(taskID) FROM ' . Task::getDatabaseTableNAme() . ' WHERE projectID = ' . Task::getDatabaseTableAlias() . '.projectID AND status = 3) as closed';

        $sql = 'SELECT ' . $sqlSelects .'
                FROM   ' . Task::getDatabaseTableName() . ' ' . Task::getDatabaseTAbleAlias() . '
                WHERE  projectID IN (?' . str_repeat(', ?', count($this->objectIDs) - 1) . ')';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute($this->objectIDs);

        while(($row = $statement->fetchArray()) !== false) {
            $projectID = $row['projectID'];

            if (isset($this->objects[$projectID])) {
                $this->objects[$projectID]->setTaskInformation($row['progress'], $row['closed'], $row['aborted']);
            }
        }
    }
}
