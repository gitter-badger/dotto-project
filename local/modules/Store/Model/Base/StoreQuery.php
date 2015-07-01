<?php

namespace Store\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Store\Model\Store as ChildStore;
use Store\Model\StoreI18nQuery as ChildStoreI18nQuery;
use Store\Model\StoreQuery as ChildStoreQuery;
use Store\Model\Map\StoreTableMap;
use Thelia\Model\Admin;

/**
 * Base class that represents a query for the 'store' table.
 *
 *
 *
 * @method     ChildStoreQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStoreQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildStoreQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildStoreQuery orderByAdminId($order = Criteria::ASC) Order by the admin_id column
 * @method     ChildStoreQuery orderByCompany($order = Criteria::ASC) Order by the company column
 * @method     ChildStoreQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildStoreQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     ChildStoreQuery orderByAddress1($order = Criteria::ASC) Order by the address1 column
 * @method     ChildStoreQuery orderByAddress2($order = Criteria::ASC) Order by the address2 column
 * @method     ChildStoreQuery orderByAddress3($order = Criteria::ASC) Order by the address3 column
 * @method     ChildStoreQuery orderByZipcode($order = Criteria::ASC) Order by the zipcode column
 * @method     ChildStoreQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildStoreQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildStoreQuery orderByCellphone($order = Criteria::ASC) Order by the cellphone column
 * @method     ChildStoreQuery orderByVatNumber($order = Criteria::ASC) Order by the vat_number column
 * @method     ChildStoreQuery orderByLat($order = Criteria::ASC) Order by the lat column
 * @method     ChildStoreQuery orderByLng($order = Criteria::ASC) Order by the lng column
 * @method     ChildStoreQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildStoreQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildStoreQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildStoreQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildStoreQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildStoreQuery groupById() Group by the id column
 * @method     ChildStoreQuery groupByVisible() Group by the visible column
 * @method     ChildStoreQuery groupByPosition() Group by the position column
 * @method     ChildStoreQuery groupByAdminId() Group by the admin_id column
 * @method     ChildStoreQuery groupByCompany() Group by the company column
 * @method     ChildStoreQuery groupByFirstname() Group by the firstname column
 * @method     ChildStoreQuery groupByLastname() Group by the lastname column
 * @method     ChildStoreQuery groupByAddress1() Group by the address1 column
 * @method     ChildStoreQuery groupByAddress2() Group by the address2 column
 * @method     ChildStoreQuery groupByAddress3() Group by the address3 column
 * @method     ChildStoreQuery groupByZipcode() Group by the zipcode column
 * @method     ChildStoreQuery groupByCity() Group by the city column
 * @method     ChildStoreQuery groupByPhone() Group by the phone column
 * @method     ChildStoreQuery groupByCellphone() Group by the cellphone column
 * @method     ChildStoreQuery groupByVatNumber() Group by the vat_number column
 * @method     ChildStoreQuery groupByLat() Group by the lat column
 * @method     ChildStoreQuery groupByLng() Group by the lng column
 * @method     ChildStoreQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildStoreQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildStoreQuery groupByVersion() Group by the version column
 * @method     ChildStoreQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildStoreQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildStoreQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStoreQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStoreQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStoreQuery leftJoinAdmin($relationAlias = null) Adds a LEFT JOIN clause to the query using the Admin relation
 * @method     ChildStoreQuery rightJoinAdmin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Admin relation
 * @method     ChildStoreQuery innerJoinAdmin($relationAlias = null) Adds a INNER JOIN clause to the query using the Admin relation
 *
 * @method     ChildStoreQuery leftJoinStoreI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the StoreI18n relation
 * @method     ChildStoreQuery rightJoinStoreI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StoreI18n relation
 * @method     ChildStoreQuery innerJoinStoreI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the StoreI18n relation
 *
 * @method     ChildStoreQuery leftJoinStoreVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the StoreVersion relation
 * @method     ChildStoreQuery rightJoinStoreVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StoreVersion relation
 * @method     ChildStoreQuery innerJoinStoreVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the StoreVersion relation
 *
 * @method     ChildStore findOne(ConnectionInterface $con = null) Return the first ChildStore matching the query
 * @method     ChildStore findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStore matching the query, or a new ChildStore object populated from the query conditions when no match is found
 *
 * @method     ChildStore findOneById(int $id) Return the first ChildStore filtered by the id column
 * @method     ChildStore findOneByVisible(int $visible) Return the first ChildStore filtered by the visible column
 * @method     ChildStore findOneByPosition(int $position) Return the first ChildStore filtered by the position column
 * @method     ChildStore findOneByAdminId(int $admin_id) Return the first ChildStore filtered by the admin_id column
 * @method     ChildStore findOneByCompany(string $company) Return the first ChildStore filtered by the company column
 * @method     ChildStore findOneByFirstname(string $firstname) Return the first ChildStore filtered by the firstname column
 * @method     ChildStore findOneByLastname(string $lastname) Return the first ChildStore filtered by the lastname column
 * @method     ChildStore findOneByAddress1(string $address1) Return the first ChildStore filtered by the address1 column
 * @method     ChildStore findOneByAddress2(string $address2) Return the first ChildStore filtered by the address2 column
 * @method     ChildStore findOneByAddress3(string $address3) Return the first ChildStore filtered by the address3 column
 * @method     ChildStore findOneByZipcode(string $zipcode) Return the first ChildStore filtered by the zipcode column
 * @method     ChildStore findOneByCity(string $city) Return the first ChildStore filtered by the city column
 * @method     ChildStore findOneByPhone(string $phone) Return the first ChildStore filtered by the phone column
 * @method     ChildStore findOneByCellphone(string $cellphone) Return the first ChildStore filtered by the cellphone column
 * @method     ChildStore findOneByVatNumber(string $vat_number) Return the first ChildStore filtered by the vat_number column
 * @method     ChildStore findOneByLat(string $lat) Return the first ChildStore filtered by the lat column
 * @method     ChildStore findOneByLng(string $lng) Return the first ChildStore filtered by the lng column
 * @method     ChildStore findOneByCreatedAt(string $created_at) Return the first ChildStore filtered by the created_at column
 * @method     ChildStore findOneByUpdatedAt(string $updated_at) Return the first ChildStore filtered by the updated_at column
 * @method     ChildStore findOneByVersion(int $version) Return the first ChildStore filtered by the version column
 * @method     ChildStore findOneByVersionCreatedAt(string $version_created_at) Return the first ChildStore filtered by the version_created_at column
 * @method     ChildStore findOneByVersionCreatedBy(string $version_created_by) Return the first ChildStore filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildStore objects filtered by the id column
 * @method     array findByVisible(int $visible) Return ChildStore objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildStore objects filtered by the position column
 * @method     array findByAdminId(int $admin_id) Return ChildStore objects filtered by the admin_id column
 * @method     array findByCompany(string $company) Return ChildStore objects filtered by the company column
 * @method     array findByFirstname(string $firstname) Return ChildStore objects filtered by the firstname column
 * @method     array findByLastname(string $lastname) Return ChildStore objects filtered by the lastname column
 * @method     array findByAddress1(string $address1) Return ChildStore objects filtered by the address1 column
 * @method     array findByAddress2(string $address2) Return ChildStore objects filtered by the address2 column
 * @method     array findByAddress3(string $address3) Return ChildStore objects filtered by the address3 column
 * @method     array findByZipcode(string $zipcode) Return ChildStore objects filtered by the zipcode column
 * @method     array findByCity(string $city) Return ChildStore objects filtered by the city column
 * @method     array findByPhone(string $phone) Return ChildStore objects filtered by the phone column
 * @method     array findByCellphone(string $cellphone) Return ChildStore objects filtered by the cellphone column
 * @method     array findByVatNumber(string $vat_number) Return ChildStore objects filtered by the vat_number column
 * @method     array findByLat(string $lat) Return ChildStore objects filtered by the lat column
 * @method     array findByLng(string $lng) Return ChildStore objects filtered by the lng column
 * @method     array findByCreatedAt(string $created_at) Return ChildStore objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildStore objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildStore objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildStore objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildStore objects filtered by the version_created_by column
 *
 */
abstract class StoreQuery extends ModelCriteria
{

    // versionable behavior

    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \Store\Model\Base\StoreQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Store\\Model\\Store', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStoreQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStoreQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Store\Model\StoreQuery) {
            return $criteria;
        }
        $query = new \Store\Model\StoreQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildStore|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StoreTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StoreTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildStore A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, VISIBLE, POSITION, ADMIN_ID, COMPANY, FIRSTNAME, LASTNAME, ADDRESS1, ADDRESS2, ADDRESS3, ZIPCODE, CITY, PHONE, CELLPHONE, VAT_NUMBER, LAT, LNG, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM store WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildStore();
            $obj->hydrate($row);
            StoreTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildStore|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StoreTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StoreTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StoreTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StoreTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the visible column
     *
     * Example usage:
     * <code>
     * $query->filterByVisible(1234); // WHERE visible = 1234
     * $query->filterByVisible(array(12, 34)); // WHERE visible IN (12, 34)
     * $query->filterByVisible(array('min' => 12)); // WHERE visible > 12
     * </code>
     *
     * @param     mixed $visible The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(StoreTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(StoreTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::VISIBLE, $visible, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position > 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(StoreTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(StoreTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the admin_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdminId(1234); // WHERE admin_id = 1234
     * $query->filterByAdminId(array(12, 34)); // WHERE admin_id IN (12, 34)
     * $query->filterByAdminId(array('min' => 12)); // WHERE admin_id > 12
     * </code>
     *
     * @see       filterByAdmin()
     *
     * @param     mixed $adminId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByAdminId($adminId = null, $comparison = null)
    {
        if (is_array($adminId)) {
            $useMinMax = false;
            if (isset($adminId['min'])) {
                $this->addUsingAlias(StoreTableMap::ADMIN_ID, $adminId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($adminId['max'])) {
                $this->addUsingAlias(StoreTableMap::ADMIN_ID, $adminId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::ADMIN_ID, $adminId, $comparison);
    }

    /**
     * Filter the query on the company column
     *
     * Example usage:
     * <code>
     * $query->filterByCompany('fooValue');   // WHERE company = 'fooValue'
     * $query->filterByCompany('%fooValue%'); // WHERE company LIKE '%fooValue%'
     * </code>
     *
     * @param     string $company The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByCompany($company = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($company)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $company)) {
                $company = str_replace('*', '%', $company);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::COMPANY, $company, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%'); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstname)) {
                $firstname = str_replace('*', '%', $firstname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%'); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastname)) {
                $lastname = str_replace('*', '%', $lastname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the address1 column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress1('fooValue');   // WHERE address1 = 'fooValue'
     * $query->filterByAddress1('%fooValue%'); // WHERE address1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByAddress1($address1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address1)) {
                $address1 = str_replace('*', '%', $address1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::ADDRESS1, $address1, $comparison);
    }

    /**
     * Filter the query on the address2 column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress2('fooValue');   // WHERE address2 = 'fooValue'
     * $query->filterByAddress2('%fooValue%'); // WHERE address2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByAddress2($address2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address2)) {
                $address2 = str_replace('*', '%', $address2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::ADDRESS2, $address2, $comparison);
    }

    /**
     * Filter the query on the address3 column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress3('fooValue');   // WHERE address3 = 'fooValue'
     * $query->filterByAddress3('%fooValue%'); // WHERE address3 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address3 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByAddress3($address3 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address3)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address3)) {
                $address3 = str_replace('*', '%', $address3);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::ADDRESS3, $address3, $comparison);
    }

    /**
     * Filter the query on the zipcode column
     *
     * Example usage:
     * <code>
     * $query->filterByZipcode('fooValue');   // WHERE zipcode = 'fooValue'
     * $query->filterByZipcode('%fooValue%'); // WHERE zipcode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $zipcode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByZipcode($zipcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($zipcode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $zipcode)) {
                $zipcode = str_replace('*', '%', $zipcode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::ZIPCODE, $zipcode, $comparison);
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%'); // WHERE city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $city The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $city)) {
                $city = str_replace('*', '%', $city);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::CITY, $city, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the cellphone column
     *
     * Example usage:
     * <code>
     * $query->filterByCellphone('fooValue');   // WHERE cellphone = 'fooValue'
     * $query->filterByCellphone('%fooValue%'); // WHERE cellphone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cellphone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByCellphone($cellphone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cellphone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cellphone)) {
                $cellphone = str_replace('*', '%', $cellphone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::CELLPHONE, $cellphone, $comparison);
    }

    /**
     * Filter the query on the vat_number column
     *
     * Example usage:
     * <code>
     * $query->filterByVatNumber('fooValue');   // WHERE vat_number = 'fooValue'
     * $query->filterByVatNumber('%fooValue%'); // WHERE vat_number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vatNumber The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByVatNumber($vatNumber = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vatNumber)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vatNumber)) {
                $vatNumber = str_replace('*', '%', $vatNumber);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::VAT_NUMBER, $vatNumber, $comparison);
    }

    /**
     * Filter the query on the lat column
     *
     * Example usage:
     * <code>
     * $query->filterByLat('fooValue');   // WHERE lat = 'fooValue'
     * $query->filterByLat('%fooValue%'); // WHERE lat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lat The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByLat($lat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lat)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lat)) {
                $lat = str_replace('*', '%', $lat);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::LAT, $lat, $comparison);
    }

    /**
     * Filter the query on the lng column
     *
     * Example usage:
     * <code>
     * $query->filterByLng('fooValue');   // WHERE lng = 'fooValue'
     * $query->filterByLng('%fooValue%'); // WHERE lng LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lng The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByLng($lng = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lng)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lng)) {
                $lng = str_replace('*', '%', $lng);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::LNG, $lng, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StoreTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StoreTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StoreTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StoreTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(StoreTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(StoreTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(StoreTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(StoreTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
                $versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StoreTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Admin object
     *
     * @param \Thelia\Model\Admin|ObjectCollection $admin The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByAdmin($admin, $comparison = null)
    {
        if ($admin instanceof \Thelia\Model\Admin) {
            return $this
                ->addUsingAlias(StoreTableMap::ADMIN_ID, $admin->getId(), $comparison);
        } elseif ($admin instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StoreTableMap::ADMIN_ID, $admin->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdmin() only accepts arguments of type \Thelia\Model\Admin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Admin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function joinAdmin($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Admin');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Admin');
        }

        return $this;
    }

    /**
     * Use the Admin relation Admin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\AdminQuery A secondary query class using the current class as primary query
     */
    public function useAdminQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdmin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Admin', '\Thelia\Model\AdminQuery');
    }

    /**
     * Filter the query by a related \Store\Model\StoreI18n object
     *
     * @param \Store\Model\StoreI18n|ObjectCollection $storeI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByStoreI18n($storeI18n, $comparison = null)
    {
        if ($storeI18n instanceof \Store\Model\StoreI18n) {
            return $this
                ->addUsingAlias(StoreTableMap::ID, $storeI18n->getId(), $comparison);
        } elseif ($storeI18n instanceof ObjectCollection) {
            return $this
                ->useStoreI18nQuery()
                ->filterByPrimaryKeys($storeI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStoreI18n() only accepts arguments of type \Store\Model\StoreI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StoreI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function joinStoreI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StoreI18n');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'StoreI18n');
        }

        return $this;
    }

    /**
     * Use the StoreI18n relation StoreI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Store\Model\StoreI18nQuery A secondary query class using the current class as primary query
     */
    public function useStoreI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinStoreI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StoreI18n', '\Store\Model\StoreI18nQuery');
    }

    /**
     * Filter the query by a related \Store\Model\StoreVersion object
     *
     * @param \Store\Model\StoreVersion|ObjectCollection $storeVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function filterByStoreVersion($storeVersion, $comparison = null)
    {
        if ($storeVersion instanceof \Store\Model\StoreVersion) {
            return $this
                ->addUsingAlias(StoreTableMap::ID, $storeVersion->getId(), $comparison);
        } elseif ($storeVersion instanceof ObjectCollection) {
            return $this
                ->useStoreVersionQuery()
                ->filterByPrimaryKeys($storeVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStoreVersion() only accepts arguments of type \Store\Model\StoreVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StoreVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function joinStoreVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StoreVersion');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'StoreVersion');
        }

        return $this;
    }

    /**
     * Use the StoreVersion relation StoreVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Store\Model\StoreVersionQuery A secondary query class using the current class as primary query
     */
    public function useStoreVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStoreVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StoreVersion', '\Store\Model\StoreVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStore $store Object to remove from the list of results
     *
     * @return ChildStoreQuery The current query, for fluid interface
     */
    public function prune($store = null)
    {
        if ($store) {
            $this->addUsingAlias(StoreTableMap::ID, $store->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the store table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StoreTableMap::clearInstancePool();
            StoreTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildStore or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildStore object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StoreTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        StoreTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StoreTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildStoreQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(StoreTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildStoreQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(StoreTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildStoreQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(StoreTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildStoreQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(StoreTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildStoreQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(StoreTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildStoreQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(StoreTableMap::CREATED_AT);
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildStoreQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'StoreI18n';

        return $this
            ->joinStoreI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildStoreQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('StoreI18n');
        $this->with['StoreI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildStoreI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StoreI18n', '\Store\Model\StoreI18nQuery');
    }

    // versionable behavior

    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }

    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }

    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // StoreQuery
