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
use Store\Model\StoreVersion as ChildStoreVersion;
use Store\Model\StoreVersionQuery as ChildStoreVersionQuery;
use Store\Model\Map\StoreVersionTableMap;

/**
 * Base class that represents a query for the 'store_version' table.
 *
 *
 *
 * @method     ChildStoreVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStoreVersionQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildStoreVersionQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildStoreVersionQuery orderByAdminId($order = Criteria::ASC) Order by the admin_id column
 * @method     ChildStoreVersionQuery orderByCompany($order = Criteria::ASC) Order by the company column
 * @method     ChildStoreVersionQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildStoreVersionQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     ChildStoreVersionQuery orderByAddress1($order = Criteria::ASC) Order by the address1 column
 * @method     ChildStoreVersionQuery orderByAddress2($order = Criteria::ASC) Order by the address2 column
 * @method     ChildStoreVersionQuery orderByAddress3($order = Criteria::ASC) Order by the address3 column
 * @method     ChildStoreVersionQuery orderByZipcode($order = Criteria::ASC) Order by the zipcode column
 * @method     ChildStoreVersionQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildStoreVersionQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildStoreVersionQuery orderByCellphone($order = Criteria::ASC) Order by the cellphone column
 * @method     ChildStoreVersionQuery orderByVatNumber($order = Criteria::ASC) Order by the vat_number column
 * @method     ChildStoreVersionQuery orderByLat($order = Criteria::ASC) Order by the lat column
 * @method     ChildStoreVersionQuery orderByLng($order = Criteria::ASC) Order by the lng column
 * @method     ChildStoreVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildStoreVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildStoreVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildStoreVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildStoreVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildStoreVersionQuery groupById() Group by the id column
 * @method     ChildStoreVersionQuery groupByVisible() Group by the visible column
 * @method     ChildStoreVersionQuery groupByPosition() Group by the position column
 * @method     ChildStoreVersionQuery groupByAdminId() Group by the admin_id column
 * @method     ChildStoreVersionQuery groupByCompany() Group by the company column
 * @method     ChildStoreVersionQuery groupByFirstname() Group by the firstname column
 * @method     ChildStoreVersionQuery groupByLastname() Group by the lastname column
 * @method     ChildStoreVersionQuery groupByAddress1() Group by the address1 column
 * @method     ChildStoreVersionQuery groupByAddress2() Group by the address2 column
 * @method     ChildStoreVersionQuery groupByAddress3() Group by the address3 column
 * @method     ChildStoreVersionQuery groupByZipcode() Group by the zipcode column
 * @method     ChildStoreVersionQuery groupByCity() Group by the city column
 * @method     ChildStoreVersionQuery groupByPhone() Group by the phone column
 * @method     ChildStoreVersionQuery groupByCellphone() Group by the cellphone column
 * @method     ChildStoreVersionQuery groupByVatNumber() Group by the vat_number column
 * @method     ChildStoreVersionQuery groupByLat() Group by the lat column
 * @method     ChildStoreVersionQuery groupByLng() Group by the lng column
 * @method     ChildStoreVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildStoreVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildStoreVersionQuery groupByVersion() Group by the version column
 * @method     ChildStoreVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildStoreVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildStoreVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStoreVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStoreVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStoreVersionQuery leftJoinStore($relationAlias = null) Adds a LEFT JOIN clause to the query using the Store relation
 * @method     ChildStoreVersionQuery rightJoinStore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Store relation
 * @method     ChildStoreVersionQuery innerJoinStore($relationAlias = null) Adds a INNER JOIN clause to the query using the Store relation
 *
 * @method     ChildStoreVersion findOne(ConnectionInterface $con = null) Return the first ChildStoreVersion matching the query
 * @method     ChildStoreVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStoreVersion matching the query, or a new ChildStoreVersion object populated from the query conditions when no match is found
 *
 * @method     ChildStoreVersion findOneById(int $id) Return the first ChildStoreVersion filtered by the id column
 * @method     ChildStoreVersion findOneByVisible(int $visible) Return the first ChildStoreVersion filtered by the visible column
 * @method     ChildStoreVersion findOneByPosition(int $position) Return the first ChildStoreVersion filtered by the position column
 * @method     ChildStoreVersion findOneByAdminId(int $admin_id) Return the first ChildStoreVersion filtered by the admin_id column
 * @method     ChildStoreVersion findOneByCompany(string $company) Return the first ChildStoreVersion filtered by the company column
 * @method     ChildStoreVersion findOneByFirstname(string $firstname) Return the first ChildStoreVersion filtered by the firstname column
 * @method     ChildStoreVersion findOneByLastname(string $lastname) Return the first ChildStoreVersion filtered by the lastname column
 * @method     ChildStoreVersion findOneByAddress1(string $address1) Return the first ChildStoreVersion filtered by the address1 column
 * @method     ChildStoreVersion findOneByAddress2(string $address2) Return the first ChildStoreVersion filtered by the address2 column
 * @method     ChildStoreVersion findOneByAddress3(string $address3) Return the first ChildStoreVersion filtered by the address3 column
 * @method     ChildStoreVersion findOneByZipcode(string $zipcode) Return the first ChildStoreVersion filtered by the zipcode column
 * @method     ChildStoreVersion findOneByCity(string $city) Return the first ChildStoreVersion filtered by the city column
 * @method     ChildStoreVersion findOneByPhone(string $phone) Return the first ChildStoreVersion filtered by the phone column
 * @method     ChildStoreVersion findOneByCellphone(string $cellphone) Return the first ChildStoreVersion filtered by the cellphone column
 * @method     ChildStoreVersion findOneByVatNumber(string $vat_number) Return the first ChildStoreVersion filtered by the vat_number column
 * @method     ChildStoreVersion findOneByLat(string $lat) Return the first ChildStoreVersion filtered by the lat column
 * @method     ChildStoreVersion findOneByLng(string $lng) Return the first ChildStoreVersion filtered by the lng column
 * @method     ChildStoreVersion findOneByCreatedAt(string $created_at) Return the first ChildStoreVersion filtered by the created_at column
 * @method     ChildStoreVersion findOneByUpdatedAt(string $updated_at) Return the first ChildStoreVersion filtered by the updated_at column
 * @method     ChildStoreVersion findOneByVersion(int $version) Return the first ChildStoreVersion filtered by the version column
 * @method     ChildStoreVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildStoreVersion filtered by the version_created_at column
 * @method     ChildStoreVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildStoreVersion filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildStoreVersion objects filtered by the id column
 * @method     array findByVisible(int $visible) Return ChildStoreVersion objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildStoreVersion objects filtered by the position column
 * @method     array findByAdminId(int $admin_id) Return ChildStoreVersion objects filtered by the admin_id column
 * @method     array findByCompany(string $company) Return ChildStoreVersion objects filtered by the company column
 * @method     array findByFirstname(string $firstname) Return ChildStoreVersion objects filtered by the firstname column
 * @method     array findByLastname(string $lastname) Return ChildStoreVersion objects filtered by the lastname column
 * @method     array findByAddress1(string $address1) Return ChildStoreVersion objects filtered by the address1 column
 * @method     array findByAddress2(string $address2) Return ChildStoreVersion objects filtered by the address2 column
 * @method     array findByAddress3(string $address3) Return ChildStoreVersion objects filtered by the address3 column
 * @method     array findByZipcode(string $zipcode) Return ChildStoreVersion objects filtered by the zipcode column
 * @method     array findByCity(string $city) Return ChildStoreVersion objects filtered by the city column
 * @method     array findByPhone(string $phone) Return ChildStoreVersion objects filtered by the phone column
 * @method     array findByCellphone(string $cellphone) Return ChildStoreVersion objects filtered by the cellphone column
 * @method     array findByVatNumber(string $vat_number) Return ChildStoreVersion objects filtered by the vat_number column
 * @method     array findByLat(string $lat) Return ChildStoreVersion objects filtered by the lat column
 * @method     array findByLng(string $lng) Return ChildStoreVersion objects filtered by the lng column
 * @method     array findByCreatedAt(string $created_at) Return ChildStoreVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildStoreVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildStoreVersion objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildStoreVersion objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildStoreVersion objects filtered by the version_created_by column
 *
 */
abstract class StoreVersionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Store\Model\Base\StoreVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Store\\Model\\StoreVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStoreVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStoreVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Store\Model\StoreVersionQuery) {
            return $criteria;
        }
        $query = new \Store\Model\StoreVersionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildStoreVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StoreVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StoreVersionTableMap::DATABASE_NAME);
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
     * @return   ChildStoreVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, VISIBLE, POSITION, ADMIN_ID, COMPANY, FIRSTNAME, LASTNAME, ADDRESS1, ADDRESS2, ADDRESS3, ZIPCODE, CITY, PHONE, CELLPHONE, VAT_NUMBER, LAT, LNG, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM store_version WHERE ID = :p0 AND VERSION = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildStoreVersion();
            $obj->hydrate($row);
            StoreVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildStoreVersion|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(StoreVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(StoreVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(StoreVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(StoreVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByStore()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::ID, $id, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::POSITION, $position, $comparison);
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
     * @param     mixed $adminId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByAdminId($adminId = null, $comparison = null)
    {
        if (is_array($adminId)) {
            $useMinMax = false;
            if (isset($adminId['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::ADMIN_ID, $adminId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($adminId['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::ADMIN_ID, $adminId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::ADMIN_ID, $adminId, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::COMPANY, $company, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::FIRSTNAME, $firstname, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::LASTNAME, $lastname, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::ADDRESS1, $address1, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::ADDRESS2, $address2, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::ADDRESS3, $address3, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::ZIPCODE, $zipcode, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::CITY, $city, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::PHONE, $phone, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::CELLPHONE, $cellphone, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::VAT_NUMBER, $vatNumber, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::LAT, $lat, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::LNG, $lng, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::VERSION, $version, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(StoreVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(StoreVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StoreVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return ChildStoreVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StoreVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Store\Model\Store object
     *
     * @param \Store\Model\Store|ObjectCollection $store The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function filterByStore($store, $comparison = null)
    {
        if ($store instanceof \Store\Model\Store) {
            return $this
                ->addUsingAlias(StoreVersionTableMap::ID, $store->getId(), $comparison);
        } elseif ($store instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StoreVersionTableMap::ID, $store->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStore() only accepts arguments of type \Store\Model\Store or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Store relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function joinStore($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Store');

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
            $this->addJoinObject($join, 'Store');
        }

        return $this;
    }

    /**
     * Use the Store relation Store object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Store\Model\StoreQuery A secondary query class using the current class as primary query
     */
    public function useStoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Store', '\Store\Model\StoreQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStoreVersion $storeVersion Object to remove from the list of results
     *
     * @return ChildStoreVersionQuery The current query, for fluid interface
     */
    public function prune($storeVersion = null)
    {
        if ($storeVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(StoreVersionTableMap::ID), $storeVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(StoreVersionTableMap::VERSION), $storeVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the store_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreVersionTableMap::DATABASE_NAME);
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
            StoreVersionTableMap::clearInstancePool();
            StoreVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildStoreVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildStoreVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StoreVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StoreVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        StoreVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StoreVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // StoreVersionQuery
