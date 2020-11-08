<?php

namespace theia\data\project;

// imports
use wcf\data\DatabaseObject;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Class        Project
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
class Project extends DatabaseObject
{
    // const
    public const VISIBILITY_PRIVATE = 0;
    public const VISIBILITY_FOLLOW  = 1;
    public const VISIBILITY_PUBLIC  = 2;
    public const OBJECT_TYPE = 'de.teralios.theia.project';
    public const MIN_WIDTH = 144;
    public const MIN_HEIGHT = 144;
    public const ICON_FILE_NAME = 'project_icon_%s.%s';
    public const ICON_LOCATION = 'images/projects/';

    // inherit variables
    protected static $databaseTableName = 'project';
    protected static $databaseTableIndexName = 'projectID';

    /**
     * Returns icon tag.
     * @param int $size
     * @return string
     */
    public function getIconTag(int $size = 16): string
    {
        if (empty($this->icon)) {
            return '<span class="icon ' . $this->getIconSizeClass($size) . ' file-text-o"></span>';
        }

        if (StringUtil::startsWith($this->icon, 'fa-')) {
            return '<span class="icon ' . $this->getIconSizeClass($size) . ' ' . $this->icon . '"></span>';
        }

        return '<img src="' . $this->getIconFile() . '" class="' . $this->getIconSizeClass($size) . '">';
    }

    /**
     * Return path to icon.
     * @return string|null
     */
    public function getIconFile(): ?string
    {
        if (!$this->icon || StringUtil::startsWith($this->icon, 'fa-')) {
            return null;
        }

        return WCF::getPath('projects') . self::ICON_LOCATION . $this->icon;
    }

    /**
     * Return valid icon classes.
     * @param int $size
     * @return string
     */
    protected function getIconSizeClass(int $size): string
    {
        $iconClasses = [
            16 => 'icon16',
            24 => 'icon24',
            32 => 'icon32',
            48 => 'icon48',
            64 => 'icon64',
            96 => 'icon96',
            128 => 'icon128',
            144 => 'icon144'
        ];

        return $iconClasses[$size] ?? 'icon64';
    }
}
