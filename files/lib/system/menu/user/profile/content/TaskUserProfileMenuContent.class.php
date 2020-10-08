<?php

namespace wcf\system\menu\user\profile;

// imports
use wcf\data\task\Task;
use wcf\data\task\ViewableTaskList;
use wcf\system\cache\runtime\UserProfileRuntimeCache;
use wcf\system\menu\user\profile\content\IUserProfileMenuContent;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class TaskUserProfileMenuContent extends SingletonFactory implements IUserProfileMenuContent
{

    public function getContent($userID)
    {
        // access level
        $visible = Task::VISIBLE_PUBLIC;
        if ($userID == WCF::getUser()->userID) {
            $visible = Task::VISIBLE_PRIVATE;
        } else {
            $userProfile = /** @scrutinizer ignore-call */UserProfileRuntimeCache::getInstance()->getObject($userID);
            $visible = ($userProfile->isFollowing(WCF::getUser()->userID)) ? Task::VISIBLE_FOLLOWER : $visible;
        }

        // build list and read data.
        $taskList = new ViewableTaskList();
        $taskList->fromUser($userID)
            ->withAccessLevel($visible)
            ->withSubtasks();
        $taskList->readObjects();

        WCF::getTPL()->assign('tasks', $taskList);

        return WCF::getTPL()->fetch('__userProfileTaskList');
    }

    public function isVisible($userID)
    {
        return true; // @todo implement user options.
    }
}
