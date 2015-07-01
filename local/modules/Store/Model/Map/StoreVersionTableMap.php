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
use Store\Model\StoreVersion;
use Store\Model\StoreVersionQuery;


/**
 * This class defines the structure of the 'store_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StoreVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Store.Model.Map.StoreVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'store_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Store\\Model\\StoreVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Store.Model.StoreVersion';

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
    const ID = 'store_version.ID';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'store_version.VISIBLE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'store_version.POSITION';

    /**
     * the column name for the ADMIN_ID field
     */
    const ADMIN_ID = 'store_version.ADMIN_ID';

    /**
     * the column name for the COMPANY field
     */
    const COMPANY = 'store_version.COMPANY';

    /**
     * the column name for the FIRSTNAME field
     */
    const FIRSTNAME = 'store_version.FIRSTNAME';

    /**
     * the column name for the LASTNAME field
     */
    const LASTNAME = 'store_version.LASTNAME';

    /**
     * the column name for the ADDRESS1 field
     */
    const ADDRESS1 = 'store_version.ADDRESS1';

    /**
     * the column name for the ADDRESS2 field
     */
    const ADDRESS2 = 'store_version.ADDRESS2';

    /**
     * the column name for the ADDRESS3 field
     */
    const ADDRESS3 = 'store_version.ADDRESS3';

    /**
     * the column name for the ZIPCODE field
     */
    const ZIPCODE = 'store_version.ZIPCODE';

    /**
     * the column name for the CITY field
     */
    const CITY = 'store_version.CITY';

    /**
     * the column name for the PHONE field
     */
    const PHONE = 'store_version.PHONE';

    /**
     * the column name for the CELLPHONE field
     */
    const CELLPHONE = 'store_version.CELLPHONE';

    /**
     * the column name for the VAT_NUMBER field
     */
    const VAT_NUMBER = 'store_version.VAT_NUMBER';

    /**
     * the column name for the LAT field
     */
    const LAT = 'store_version.LAT';

    /**
     * the column name for the LNG field
     */
    const LNG = 'store_version.LNG';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'store_version.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'store_version.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'store_version.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'store_version.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'store_version.VERSION_CREATED_BY';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Visible', 'Position', 'AdminId', 'Company', 'Firstname', 'Lastname', 'Address1', 'Address2', 'Address3', 'Zipcode', 'City', 'Phone', 'Cellphone', 'VatNumber', 'Lat', 'Lng', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'visible', 'position', 'adminId', 'company', 'firstname', 'lastname', 'address1', 'address2', 'address3', 'zipcode', 'city', 'phone', 'cellphone', 'vatNumber', 'lat', 'lng', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(StoreVersionTableMap::ID, StoreVersionTableMap::VISIBLE, StoreVersionTableMap::POSITION, StoreVersionTableMap::ADMIN_ID, StoreVersionTableMap::COMPANY, StoreVersionTableMap::FIRSTNAME, StoreVersionTableMap::LASTNAME, StoreVersionTableMap::ADDRESS1, StoreVersionTableMap::ADDRESS2, StoreVersionTableMap::ADDRESS3, StoreVersionTableMap::ZIPCODE, StoreVersionTableMap::CITY, StoreVersionTableMap::PHONE, StoreVersionTableMap::CELLPHONE, StoreVersionTableMap::VAT_NUMBER, StoreVersionTableMap::LAT, StoreVersionTableMap::LNG, StoreVersionTableMap::CREATED_AT, StoreVersionTableMap::UPDATED_AT, StoreVersionTableMap::VERSION, StoreVersionTableMap::VERSION_CREATED_AT, StoreVersionTableMap::VERSION_CREATED_BY, ),
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
        self::TYPE_COLNAME       => array(StoreVersionTableMap::ID => 0, StoreVersionTableMap::VISIBLE => 1, StoreVersionTableMap::POSITION => 2, StoreVersionTableMap::ADMIN_ID => 3, StoreVersionTableMap::COMPANY => 4, StoreVersionTableMap::FIRSTNAME => 5, StoreVersionTableMap::LASTNAME => 6, StoreVersionTableMap::ADDRESS1 => 7, StoreVersionTableMap::ADDRESS2 => 8, StoreVersionTableMap::ADDRESS3 => 9, StoreVersionTableMap::ZIPCODE => 10, StoreVersionTableMap::CITY => 11, StoreVersionTableMap::PHONE => 12, StoreVersionTableMap::CELLPHONE => 13, StoreVersionTableMap::VAT_NUMBER => 14, StoreVersionTableMap::LAT => 15, StoreVersionTableMap::LNG => 16, StoreVersionTableMap::CREATED_AT => 17, StoreVersionTableMap::UPDATED_AT => 18, StoreVersionTableMap::VERSION => 19, StoreVersionTableMap::VERSION_CREATED_AT => 20, StoreVersionTableMap::VERSION_CREATED_BY => 21, ),
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
        $this->setName('store_version');
        $this->setPhpName('StoreVersion');
        $this->setClassName('\\Store\\Model\\StoreVersion');
        $this->setPackage('Store.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'store', 'ID', true, null, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, 0);
        $this->addColumn('POSITION', 'Position', 'INTEGER', true, null, 0);
        $this->addColumn('ADMIN_ID', 'AdminId', 'INTEGER', false, null, null);
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
        $this->addPrimaryKey('VERSION', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Store', '\\Store\\Model\\Store', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Store\Model\StoreVersion $obj A \Store\Model\StoreVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getVersion()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Store\Model\StoreVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Store\Model\StoreVersion) {
                $key = serialize(array((string) $value->getId(), (string) $value->getVersion()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Store\Model\StoreVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 19 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 19 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]));
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

            return $pks;
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
        return $withPrefix ? StoreVersionTableMap::CLASS_DEFAULT : StoreVersionTableMap::OM_CLASS;
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
     * @return array (StoreVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StoreVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StoreVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StoreVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StoreVersionTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StoreVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = StoreVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StoreVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StoreVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(StoreVersionTableMap::ID);
            $criteria->addSelectColumn(StoreVersionTableMap::VISIBLE);
            $criteria->addSelectColumn(StoreVersionTableMap::POSITION);
            $criteria->addSelectColumn(StoreVersionTableMap::ADMIN_ID);
            $criteria->addSelectColumn(StoreVersionTableMap::COMPANY);
            $criteria->addSelectColumn(StoreVersionTableMap::FIRSTNAME);
            $criteria->addSelectColumn(StoreVersionTableMap::LASTNAME);
            $criteria->addSelectColumn(StoreVersionTableMap::ADDRESS1);
            $criteria->addSelectColumn(StoreVersionTableMap::ADDRESS2);
            $criteria->addSelectColumn(StoreVersionTableMap::ADDRESS3);
            $criteria->addSelectColumn(StoreVersionTableMap::ZIPCODE);
            $criteria->addSelectColumn(StoreVersionTableMap::CITY);
            $criteria->addSelectColumn(StoreVersionTableMap::PHONE);
            $criteria->addSelectColumn(StoreVersionTableMap::CELLPHONE);
            $criteria->addSelectColumn(StoreVersionTableMap::VAT_NUMBER);
            $criteria->addSelectColumn(StoreVersionTableMap::LAT);
            $criteria->addSelectColumn(StoreVersionTableMap::LNG);
            $criteria->addSelectColumn(StoreVersionTableMap::CREATED_AT);
            $criteria->addSelectColumn(StoreVersionTableMap::UPDATED_AT);
            $criteria->addSelectColumn(StoreVersionTableMap::VERSION);
            $criteria->addSelectColumn(StoreVersionTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(StoreVersionTableMap::VERSION_CREATED_BY);
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
        return Propel::getServiceContainer()->getDatabaseMap(StoreVersionTableMap::DATABASE_NAME)->getTable(StoreVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(StoreVersionTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(StoreVersionTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new StoreVersionTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a StoreVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or StoreVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StoreVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Store\Model\StoreVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StoreVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(StoreVersionTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(StoreVersionTableMap::VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = StoreVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { StoreVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { StoreVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the store_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StoreVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a StoreVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or StoreVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from StoreVersion object
        }


        // Set the correct dbName
        $query = StoreVersionQuery::create()->mergeWith($criteria);

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

} // StoreVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StoreVersionTableMap::buildTableMap();