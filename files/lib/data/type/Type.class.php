<?php

namespace theia\data\type;

// imports
use theia\data\TIconObject;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

/**
 * Class        Type
 * @package     de.teralios.theia
 * @subpackage  theia\data\type
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @property-read int $typeID
 * @property-read int $position
 * @property-read string $name
 * @property-read string $icon
 */
class Type extends DatabaseObject
{
    use TIconObject;

    // inherit variables
    protected static $databaseTableName = 'typeID';
    protected static $databaseTableIndexName = 'typeID';

    // default icon
    public const DEFAULT_ICON = 'fa-briefcase';

    /**
     * Returns icon tag for template.
     * @param int $size
     * @return string
     */
    public function getIconTag(int $size = 64): string
    {
        return '<span class="icon ' . $this->getIconSizeClass($size) . ' ' . ((!empty($this->icon)) ? $this->icon : self::DEFAULT_ICON) . '"></span>';
    }

    public static function getLastPosition(): int
    {
        $sql = 'SELECT  COUNT(typeID) as lastPosition
                FROM    ' . Type::getDatabaseTableName();
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute();
        $row = $statement->fetchSingleRow();

        return $row['lastPosition'] ?? 0;
    }
}
