<?php

namespace Store\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Store\Model\Store;
use Store\Model\StoreQuery;


/**
 * This class defines the structure of the 'store' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StoreTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Store.Model.Map.StoreTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'store';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Store\\Model\\Store';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Store.Model.Store';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 22;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 22;

    /**
     * the column name for the ID field
     */
    const ID = 'store.ID';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'store.VISIBLE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'store.POSITION';

    /**
     * the column name for the ADMIN_ID field
     */
    const ADMIN_ID = 'store.ADMIN_ID';

    /**
     * the column name for the COMPANY field
     */
    const COMPANY = 'store.COMPANY';

    /**
     * the column name for the FIRSTNAME field
     */
    const FIRSTNAME = 'store.FIRSTNAME';

    /**
     * the column name for the LASTNAME field
     */
    const LASTNAME = 'store.LASTNAME';

    /**
     * the column name for the ADDRESS1 field
     */
    const ADDRESS1 = 'store.ADDRESS1';

    /**
     * the column name for the ADDRESS2 field
     */
    const ADDRESS2 = 'store.ADDRESS2';

    /**
     * the column name for the ADDRESS3 field
     */
    const ADDRESS3 = 'store.ADDRESS3';

    /**
     * the column name for the ZIPCODE field
     */
    const ZIPCODE = 'store.ZIPCODE';

    /**
     * the column name for the CITY field
     */
    const CITY = 'store.CITY';

    /**
     * the column name for the PHONE field
     */
    const PHONE = 'store.PHONE';

    /**
     * the column name for the CELLPHONE field
     */
    const CELLPHONE = 'store.CELLPHONE';

    /**
     * the column name for the VAT_NUMBER field
     */
    const VAT_NUMBER = 'store.VAT_NUMBER';

    /**
     * the column name for the LAT field
     */
    const LAT = 'store.LAT';

    /**
     * the column name for the LNG field
     */
    const LNG = 'store.LNG';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'store.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'store.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'store.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'store.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'store.VERSION_CREATED_BY';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // i18n behavior

    /**
     * The default locale to use for translations.
     *
     * @var string
     */
    const DEFAULT_LOCALE = 'en_US';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Visible', 'Position', 'AdminId', 'Company', 'Firstname', 'Lastname', 'Address1', 'Address2', 'Address3', 'Zipcode', 'City', 'Phone', 'Cellphone', 'VatNumber', 'Lat', 'Lng', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'visible', 'position', 'adminId', 'company', 'firstname', 'lastname', 'address1', 'address2', 'address3', 'zipcode', 'city', 'phone', 'cellphone', 'vatNumber', 'lat', 'lng', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(StoreTableMap::ID, StoreTableMap::VISIBLE, StoreTableMap::POSITION, StoreTableMap::ADMIN_ID, StoreTableMap::COMPANY, StoreTableMap::FIRSTNAME, StoreTableMap::LASTNAME, StoreTableMap::ADDRESS1, StoreTableMap::ADDRESS2, StoreTableMap::ADDRESS3, StoreTableMap::ZIPCODE, StoreTableMap::CITY, StoreTableMap::PHONE, StoreTableMap::CELLPHONE, StoreTableMap::VAT_NUMBER, StoreTableMap::LAT, StoreTableMap::LNG, StoreTableMap::CREATED_AT, StoreTableMap::UPDATED_AT, StoreTableMap::VERSION, StoreTableMap::VERSION_CREATED_AT, StoreTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'VISIBLE', 'POSITION', 'ADMIN_ID', 'COMPANY', 'FIRSTNAME', 'LASTNAME', 'ADDRESS1', 'ADDRESS2', 'ADDRESS3', 'ZIPCODE', 'CITY', 'PHONE', 'CELLPHONE', 'VAT_NUMBER', 'LAT', 'LNG', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'visible', 'position', 'admin_id', 'company', 'firstname', 'lastname', 'address1', 'address2', 'address3', 'zipcode', 'city', 'phone', 'cellphone', 'vat_number', 'lat', 'lng', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Visible' => 1, 'Position' => 2, 'AdminId' => 3, 'Company' => 4, 'Firstname' => 5, 'Lastname' => 6, 'Address1' => 7, 'Address2' => 8, 'Address3' => 9, 'Zipcode' => 10, 'City' => 11, 'Phone' => 12, 'Cellphone' => 13, 'VatNumber' => 14, 'Lat' => 15, 'Lng' => 16, 'CreatedAt' => 17, 'UpdatedAt' => 18, 'Version' => 19, 'VersionCreatedAt' => 20, 'VersionCreatedBy' => 21, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'visible' => 1, 'position' => 2, 'adminId' => 3, 'company' => 4, 'firstname' => 5, 'lastname' => 6, 'address1' => 7, 'address2' => 8, 'address3' => 9, 'zipcode' => 10, 'city' => 11, 'phone' => 12, 'cellphone' => 13, 'vatNumber' => 14, 'lat' => 15, 'lng' => 16, 'createdAt' => 17, 'updatedAt' => 18, 'version' => 19, 'versionCreatedAt' => 20, 'versionCreatedBy' => 21, ),
        self::TYPE_COLNAME       => array(StoreTableMap::ID => 0, StoreTableMap::VISIBLE => 1, StoreTableMap::POSITION => 2, StoreTableMap::ADMIN_ID => 3, StoreTableMap::COMPANY => 4, StoreTableMap::FIRSTNAME => 5, StoreTableMap::LASTNAME => 6, StoreTableMap::ADDRESS1 => 7, StoreTableMap::ADDRESS2 => 8, StoreTableMap::ADDRESS3 => 9, StoreTableMap::ZIPCODE => 10, StoreTableMap::CITY => 11, StoreTableMap::PHONE => 12, StoreTableMap::CELLPHONE => 13, StoreTableMap::VAT_NUMBER => 14, StoreTableMap::LAT => 15, StoreTableMap::LNG => 16, StoreTableMap::CREATED_AT => 17, StoreTableMap::UPDATED_AT => 18, StoreTableMap::VERSION => 19, StoreTableMap::VERSION_CREATED_AT => 20, StoreTableMap::VERSION_CREATED_BY => 21, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'VISIBLE' => 1, 'POSITION' => 2, 'ADMIN_ID' => 3, 'COMPANY' => 4, 'FIRSTNAME' => 5, 'LASTNAME' => 6, 'ADDRESS1' => 7, 'ADDRESS2' => 8, 'ADDRESS3' => 9, 'ZIPCODE' => 10, 'CITY' => 11, 'PHONE' => 12, 'CELLPHONE' => 13, 'VAT_NUMBER' => 14, 'LAT' => 15, 'LNG' => 16, 'CREATED_AT' => 17, 'UPDATED_AT' => 18, 'VERSION' => 19, 'VERSION_CREATED_AT' => 20, 'VERSION_CREATED_BY' => 21, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'visible' => 1, 'position' => 2, 'admin_id' => 3, 'company' => 4, 'firstname' => 5, 'lastname' => 6, 'address1' => 7, 'address2' => 8, 'address3' => 9, 'zipcode' => 10, 'city' => 11, 'phone' => 12, 'cellphone' => 13, 'vat_number' => 14, 'lat' => 15, 'lng' => 16, 'created_at' => 17, 'updated_at' => 18, 'version' => 19, 'version_created_at' => 20, 'version_created_by' => 21, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('store');
        $this->setPhpName('Store');
        $this->setClassName('\\Store\\Model\\Store');
        $this->setPackage('Store.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, 0);
        $this->addColumn('POSITION', 'Position', 'INTEGER', true, null, 0);
        $this->addForeignKey('ADMIN_ID', 'AdminId', 'INTEGER', 'admin', 'ID', false, null, null);
        $this->addColumn('COMPANY', 'Company', 'VARCHAR', false, 255, null);
        $this->addColumn('FIRSTNAME', 'Firstname', 'VARCHAR', true, 255, null);
        $this->addColumn('LASTNAME', 'Lastname', 'VARCHAR', true, 255, null);
        $this->addColumn('ADDRESS1', 'Address1', 'VARCHAR', true, 255, null);
        $this->addColumn('ADDRESS2', 'Address2', 'VARCHAR', true, 255, null);
        $this->addColumn('ADDRESS3', 'Address3', 'VARCHAR', true, 255, null);
        $this->addColumn('ZIPCODE', 'Zipcode', 'VARCHAR', true, 10, null);
        $this->addColumn('CITY', 'City', 'VARCHAR', true, 255, null);
        $this->addColumn('PHONE', 'Phone', 'VARCHAR', false, 20, null);
        $this->addColumn('CELLPHONE', 'Cellphone', 'VARCHAR', false, 20, null);
        $this->addColumn('VAT_NUMBER', 'VatNumber', 'VARCHAR', false, 255, null);
        $this->addColumn('LAT', 'Lat', 'VARCHAR', false, 20, null);
        $this->addColumn('LNG', 'Lng', 'VARCHAR', false, 20, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Admin', '\\Thelia\\Model\\Admin', RelationMap::MANY_TO_ONE, array('admin_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('StoreI18n', '\\Store\\Model\\StoreI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'StoreI18ns');
        $this->addRelation('StoreVersion', '\\Store\\Model\\StoreVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'StoreVersions');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'title, description', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => '', 'locale_alias' => '', ),
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'true', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to store     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                StoreI18nTableMap::clearInstancePool();
                StoreVersionTableMap::clearInstancePool();
            }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? StoreTableMap::CLASS_DEFAULT : StoreTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (Store object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StoreTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StoreTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StoreTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StoreTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StoreTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = StoreTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StoreTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StoreTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(StoreTableMap::ID);
            $criteria->addSelectColumn(StoreTableMap::VISIBLE);
            $criteria->addSelectColumn(StoreTableMap::POSITION);
            $criteria->addSelectColumn(StoreTableMap::ADMIN_ID);
            $criteria->addSelectColumn(StoreTableMap::COMPANY);
            $criteria->addSelectColumn(StoreTableMap::FIRSTNAME);
            $criteria->addSelectColumn(StoreTableMap::LASTNAME);
            $criteria->addSelectColumn(StoreTableMap::ADDRESS1);
            $criteria->addSelectColumn(StoreTableMap::ADDRESS2);
            $criteria->addSelectColumn(StoreTableMap::ADDRESS3);
            $criteria->addSelectColumn(StoreTableMap::ZIPCODE);
            $criteria->addSelectColumn(StoreTableMap::CITY);
            $criteria->addSelectColumn(StoreTableMap::PHONE);
            $criteria->addSelectColumn(StoreTableMap::CELLPHONE);
            $criteria->addSelectColumn(StoreTableMap::VAT_NUMBER);
            $criteria->addSelectColumn(StoreTableMap::LAT);
            $criteria->addSelectColumn(StoreTableMap::LNG);
            $criteria->addSelectColumn(StoreTableMap::CREATED_AT);
            $criteria->addSelectColumn(StoreTableMap::UPDATED_AT);
            $criteria->addSelectColumn(StoreTableMap::VERSION);
            $criteria->addSelectColumn(StoreTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(StoreTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.VISIBLE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.ADMIN_ID');
            $criteria->addSelectColumn($alias . '.COMPANY');
            $criteria->addSelectColumn($alias . '.FIRSTNAME');
            $criteria->addSelectColumn($alias . '.LASTNAME');
            $criteria->addSelectColumn($alias . '.ADDRESS1');
            $criteria->addSelectColumn($alias . '.ADDRESS2');
            $criteria->addSelectColumn($alias . '.ADDRESS3');
            $criteria->addSelectColumn($alias . '.ZIPCODE');
            $criteria->addSelectColumn($alias . '.CITY');
            $criteria->addSelectColumn($alias . '.PHONE');
            $criteria->addSelectColumn($alias . '.CELLPHONE');
            $criteria->addSelectColumn($alias . '.VAT_NUMBER');
            $criteria->addSelectColumn($alias . '.LAT');
            $criteria->addSelectColumn($alias . '.LNG');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_BY');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(StoreTableMap::DATABASE_NAME)->getTable(StoreTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(StoreTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(StoreTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new StoreTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Store or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Store object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Store\Model\Store) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StoreTableMap::DATABASE_NAME);
            $criteria->add(StoreTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = StoreQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { StoreTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { StoreTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the store table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StoreQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Store or Criteria object.
     *
     * @param mixed               $criteria Criteria or Store object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Store object
        }

        if ($criteria->containsKey(StoreTableMap::ID) && $criteria->keyContainsValue(StoreTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StoreTableMap::ID.')');
        }


        // Set the correct dbName
        $query = StoreQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // StoreTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StoreTableMap::buildTableMap();
