<?php

namespace theia\data\type;

// imports
use wcf\data\DatabaseObjectEditor;
use wcf\system\database\exception\DatabaseQueryException;
use wcf\system\database\exception\DatabaseQueryExecutionException;
use wcf\system\database\exception\DatabaseTransactionException;
use wcf\system\WCF;

/**
 * Class        TypeEditor
 * @package     de.teralios.theia
 * @subpackage  theia\data\type
 * @author      Karsten (Teralios) Achterrath
 * @copyright   ©2020 Teralios.de
 * @license     GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class TypeEditor extends DatabaseObjectEditor
{
    // inherit variables
    protected static $baseClass = Type::class;

    /**
     * @inheritdoc
     */
    public function update(array $parameters = [])
    {
        if ($this->position != $parameters['position']) {
            static::updateOtherPositions($parameters['position'], $this->position);
        }

        parent::update($parameters);
    }

    /**
     * @inheritdoc
     * @throws DatabaseQueryException|DatabaseQueryExecutionException|DatabaseTransactionException
     */
    public static function create(array $parameters = []): Type
    {
        if (!isset($parameters['position']) || $parameters['position'] == 0) {
            $parameters['position'] = 1;
        }

        static::updateOtherPositions($parameters['position']);

        return parent::create($parameters);
    }

    /**
     * @inheritdoc
     * @throws DatabaseQueryException|DatabaseQueryExecutionException|DatabaseTransactionException
     */
    public static function deleteAll(array $objectIDs = []): int
    {
        $returnValues = parent::deleteAll($objectIDs);
        static::updateAllPositions();

        return $returnValues;
    }

    /**
     * @param int $newPosition
     * @param int|null $oldPosition
     * @throws DatabaseQueryException|DatabaseQueryExecutionException|DatabaseTransactionException
     */
    protected static function updateOtherPositions(int $newPosition, ?int $oldPosition = null): void
    {
        WCF::getDB()->beginTransaction();

        if ($oldPosition === null) {
            $sql = 'UPDATE ' . Type::getDatabaseTableName() . '
                    SET     position = position + 1
                    WHERE   position >= ?';
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute([$newPosition]);
        } elseif ($oldPosition > $newPosition) {
            $sql = 'UPDATE ' . Type::getDatabaseTableName() . '
                    SET     position = position + 1
                    WHERE   position BETWEEN ? AND ?';
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute([$newPosition, $oldPosition]);
        } else {
            $sql = 'UPDATE ' . Type::getDatabaseTableName() . '
                    SET     position = position - 1
                    WHERE   position BETWEEN ? AND ?';
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute([$oldPosition, $newPosition]);
        }

        WCF::getDB()->commitTransaction();
    }

    /**
     * Update all positions.
     *
     * Prevents problems when there are many gaps in the positions.
     *
     * @throws DatabaseQueryException|DatabaseQueryExecutionException|DatabaseTransactionException
     */
    protected static function updateAllPositions(): void
    {
        $typeList = new TypeList();
        $typeList->sqlOrderBy = Type::getDatabaseTableAlias() . '.position';
        $typeList->readObjectIDs();
        $typeIDs = $typeList->getObjectIDs();

        if (count($typeIDs)) {
            WCF::getDB()->beginTransaction();
            $sql = 'UPDATE ' . Type::getDatabaseTableName() . '
                    SET     position = ?
                    WHERE   typeID = ?';
            $statement = WCF::getDB()->prepareStatement($sql);
            $position = 1;
            foreach ($typeIDs as $typeID) {
                $statement->execute([$position, $typeID]);
                ++$position;
            }
            WCF::getDB()->commitTransaction();
        }
    }
}
