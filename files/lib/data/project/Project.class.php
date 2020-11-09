<?php

namespace theia\data\project;

// imports
use theia\data\TIconObject;
use wcf\data\DatabaseObject;
use wcf\system\html\output\HtmlOutputProcessor;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Class        Project
 * @package     de.teralios.theia
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
 * @property-read int $status
 * @property-read int $deleteTime
 * @property-read string $name
 * @property-read string $description
 * @property-read string $icon
 */
class Project extends DatabaseObject
{
    use TIconObject;
    // const visibility
    public const VISIBILITY_PRIVATE = 0;
    public const VISIBILITY_FOLLOW  = 1;
    public const VISIBILITY_PUBLIC  = 2;

    // const status
    public const STATUS_OPEN = 0;
    public const STATUS_ABORT = 1;
    public const STATUS_CLOSED = 2;
    public const STATUS_DELETED = 3;

    // const object type
    public const OBJECT_TYPE = 'de.teralios.theia.project';

    // const icon
    public const MIN_WIDTH = 144;
    public const MIN_HEIGHT = 144;
    public const ICON_FILE_NAME = 'project_icon_%s.%s';
    public const ICON_LOCATION = 'images/projects/';

    // inherit variables
    protected static $databaseTableName = 'project';
    protected static $databaseTableIndexName = 'projectID';

    /**
     * Returns raw or formatted description.
     * @param bool $raw
     * @return string
     */
    public function getDescription(bool $raw = false): string
    {
        // raw html code.
        if ($raw === true) {
            return $this->description;
        }

        // html output processor.
        $processor = new HtmlOutputProcessor();
        $processor->process($this->description, self::OBJECT_TYPE, $this->projectID);
        return $processor->getHtml();
    }

    /**
     * Returns truncated description.
     * @param int $length
     * @return string
     */
    public function getPreview(int $length = 250): string
    {
        return StringUtil::truncateHTML($this->getDescription(), $length);
    }

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
}
