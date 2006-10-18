<?php
/**
 * File containing the ezcPersistentManyToOneRelation.
 *
 * @package PersistentObject
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Relation class to reflect a many-to-one table relation (m:1).
 *
 * @property bool $cascade
 *           Wether to cascade delete action from the source table to the
 *           destination table.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @todo ManyToOne relations are only reverse versions of OneToMany one. Should
 *       they therefore be marked "reverse" by default and this be made a
 *       read-only property?
 */
class ezcPersistentManyToOneRelation extends ezcPersistentRelation
{
   
    private $properties = array(
        "cascade" => false,
        "reverse" => true,
    );

    /**
     * Validates an {@see ezcPersistentRelation::$columnMap} property.
     * Checks is the given array represents a valid $columnMap property. Column
     * maps for this kind of relation may only contain instances of
     * {@see ezcPersistentSingleTableMap} and have to at least contain 1
     * instance.
     *  
     * @param array $columnMap The column map to check.
     *
     * @throws ezcBaseValueException On an invalid column map.
     */
    protected function validateColumnMap( array $columnMap )
    {
        if ( sizeof( $columnMap ) < 1 )
        {
            throw new ezcBaseValueException(
                "colmunMap",
                $columnMap,
                "array(ezcPersistentSingleTableMap) > 0 elements"
            );
        }
        foreach ( $columnMap as $relation )
        {
            if ( !( $relation instanceof ezcPersistentSingleTableMap ) )
            {
                throw new ezcBaseValueException(
                    "columnMap",
                    $columnMap,
                    "array(ezcPersistentSingleTableMap) > 0 elements"
                );
            }
        }
    }

    /**
     * Property read access.
     * 
     * @param string $key Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     * @ignore
     */
    public function __get( $propertyName )
    {
        switch ( $propertyName )
        {
            case "cascade":
            case "reverse":
                return $this->properties[$propertyName];
            default:
                return parent::__get( $propertyName );
        }

    }

    /**
     * Property write access.
     * 
     * @param string $key Name of the property.
     * @param mixed $val  The value for the property.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "cascade":
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        "bool"
                    );
                }
                $this->properties[$propertyName] = $propertyValue;
                break;
            case "reverse":
               throw new ezcBasePropertyPermissionException( $propertyName, ezcBasePropertyPermissionException::READ );
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Property isset access.
     * 
     * @param string $key Name of the property.
     * @return bool True is the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $propertyName )
    {
        if ( array_key_exists( $propertyName, $this->properties ) )
        {
            return true;
        }
        return parent::__isset( ( $propertyName ) );
    }
}

?>
