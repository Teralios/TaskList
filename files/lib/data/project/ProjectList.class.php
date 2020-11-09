<?php

namespace theia\data\project;

// imports
use wcf\data\DatabaseObjectList;

/**
 * Class        ProjectList
 * @package     theia
 * @subpackage  theia\data\project
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class ProjectList extends DatabaseObjectList
{
    // inherit variables
    public $className = Project::class;
}
