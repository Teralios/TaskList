<?php

namespace theia\data\project;

// imports
use wcf\data\DatabaseObjectEditor;
use wcf\system\exception\SystemException;
use wcf\system\file\upload\UploadFile;
use wcf\system\image\ImageHandler;

/**
 * Class        ProjectEditor
 * @package     TaskList
 * @subpackage  wcf\data\user\project
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @property-read int $projectID
 * @property-read int $userID
 * @property-read int $creationTime
 * @property-read int $updateTime
 * @property-read int $tasks
 * @property-read int $visibility
 * @property-read string $name
 * @property-read string $description
 * @property-read string $icon
 */
class ProjectEditor extends DatabaseObjectEditor
{
    // inherit variables
    protected static $baseClass = Project::class;

    /**
     * Set new icon for project.
     * @param UploadFile $uploadFile
     * @throws SystemException
     */
    public function setIcon(UploadFile $uploadFile): void
    {
        // resize image and save on origin location.
        $extension = substr($uploadFile->getFilename(), (strrpos($uploadFile->getFilename(), '.') + 1));
        $iconFile = /** @scrutinizer ignore-call */ImageHandler::getInstance()->getAdapter();
        $iconFile->loadFile($uploadFile->getLocation());
        $iconFile->writeImage(
            $iconFile->createThumbnail(Project::MIN_WIDTH, Project::MIN_HEIGHT, false),
            $this->buildFilename($extension)
        );

        // handle upload file
        $uploadFile->setProcessed($this->buildFilename($extension));

        // save icon name
        $this->update(['icon' => $this->buildFilename($extension, false)]);
    }

    /**
     * @param string $extension
     * @param bool $fullLocation
     * @return string
     */
    protected function buildFilename(string $extension, bool $fullLocation = true): string
    {
        return (($fullLocation) ? PROJECT_DIR . Project::ICON_LOCATION : '') . sprintf(Project::ICON_FILE_NAME, $this->projectID, $extension);
    }
}
