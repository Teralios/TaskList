<?php

namespace theia\data\type;

// imports
use wcf\data\DatabaseObjectList;

/**
 * Class        TypeList
 * @package     de.teralios.theia
 * @subpackage  theia\data\type
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class TypeList extends DatabaseObjectList
{
    public $className = Type::class;
}
