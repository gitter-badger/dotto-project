<?php

namespace Store\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Store\Model\Store as ChildStore;
use Store\Model\StoreI18n as ChildStoreI18n;
use Store\Model\StoreI18nQuery as ChildStoreI18nQuery;
use Store\Model\StoreQuery as ChildStoreQuery;
use Store\Model\StoreVersion as ChildStoreVersion;
use Store\Model\StoreVersionQuery as ChildStoreVersionQuery;
use Store\Model\Map\StoreTableMap;
use Store\Model\Map\StoreVersionTableMap;
use Thelia\Model\AdminQuery;
use Thelia\Model\Admin as ChildAdmin;

abstract class Store implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Store\\Model\\Map\\StoreTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the visible field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $visible;

    /**
     * The value for the position field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $position;

    /**
     * The value for the admin_id field.
     * @var        int
     */
    protected $admin_id;

    /**
     * The value for the company field.
     * @var        string
     */
    protected $company;

    /**
     * The value for the firstname field.
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the address1 field.
     * @var        string
     */
    protected $address1;

    /**
     * The value for the address2 field.
     * @var        string
     */
    protected $address2;

    /**
     * The value for the address3 field.
     * @var        string
     */
    protected $address3;

    /**
     * The value for the zipcode field.
     * @var        string
     */
    protected $zipcode;

    /**
     * The value for the city field.
     * @var        string
     */
    protected $city;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the cellphone field.
     * @var        string
     */
    protected $cellphone;

    /**
     * The value for the vat_number field.
     * @var        string
     */
    protected $vat_number;

    /**
     * The value for the lat field.
     * @var        string
     */
    protected $lat;

    /**
     * The value for the lng field.
     * @var        string
     */
    protected $lng;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * The value for the version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * The value for the version_created_at field.
     * @var        string
     */
    protected $version_created_at;

    /**
     * The value for the version_created_by field.
     * @var        string
     */
    protected $version_created_by;

    /**
     * @var        Admin
     */
    protected $aAdmin;

    /**
     * @var        ObjectCollection|ChildStoreI18n[] Collection to store aggregation of ChildStoreI18n objects.
     */
    protected $collStoreI18ns;
    protected $collStoreI18nsPartial;

    /**
     * @var        ObjectCollection|ChildStoreVersion[] Collection to store aggregation of ChildStoreVersion objects.
     */
    protected $collStoreVersions;
    protected $collStoreVersionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'en_US';

    /**
     * Current translation objects
     * @var        array[ChildStoreI18n]
     */
    protected $currentTranslations;

    // versionable behavior


    /**
     * @var bool
     */
    protected $enforceVersion = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $storeI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $storeVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->visible = 0;
        $this->position = 0;
        $this->version = 0;
    }

    /**
     * Initializes internal state of Store\Model\Base\Store object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Store</code> instance.  If
     * <code>obj</code> is an instance of <code>Store</code>, delegates to
     * <code>equals(Store)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return Store The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return Store The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [visible] column value.
     *
     * @return   int
     */
    public function getVisible()
    {

        return $this->visible;
    }

    /**
     * Get the [position] column value.
     *
     * @return   int
     */
    public function getPosition()
    {

        return $this->position;
    }

    /**
     * Get the [admin_id] column value.
     *
     * @return   int
     */
    public function getAdminId()
    {

        return $this->admin_id;
    }

    /**
     * Get the [company] column value.
     *
     * @return   string
     */
    public function getCompany()
    {

        return $this->company;
    }

    /**
     * Get the [firstname] column value.
     *
     * @return   string
     */
    public function getFirstname()
    {

        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     *
     * @return   string
     */
    public function getLastname()
    {

        return $this->lastname;
    }

    /**
     * Get the [address1] column value.
     *
     * @return   string
     */
    public function getAddress1()
    {

        return $this->address1;
    }

    /**
     * Get the [address2] column value.
     *
     * @return   string
     */
    public function getAddress2()
    {

        return $this->address2;
    }

    /**
     * Get the [address3] column value.
     *
     * @return   string
     */
    public function getAddress3()
    {

        return $this->address3;
    }

    /**
     * Get the [zipcode] column value.
     *
     * @return   string
     */
    public function getZipcode()
    {

        return $this->zipcode;
    }

    /**
     * Get the [city] column value.
     *
     * @return   string
     */
    public function getCity()
    {

        return $this->city;
    }

    /**
     * Get the [phone] column value.
     *
     * @return   string
     */
    public function getPhone()
    {

        return $this->phone;
    }

    /**
     * Get the [cellphone] column value.
     *
     * @return   string
     */
    public function getCellphone()
    {

        return $this->cellphone;
    }

    /**
     * Get the [vat_number] column value.
     *
     * @return   string
     */
    public function getVatNumber()
    {

        return $this->vat_number;
    }

    /**
     * Get the [lat] column value.
     *
     * @return   string
     */
    public function getLat()
    {

        return $this->lat;
    }

    /**
     * Get the [lng] column value.
     *
     * @return   string
     */
    public function getLng()
    {

        return $this->lng;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Get the [version] column value.
     *
     * @return   int
     */
    public function getVersion()
    {

        return $this->version;
    }

    /**
     * Get the [optionally formatted] temporal [version_created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getVersionCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->version_created_at;
        } else {
            return $this->version_created_at instanceof \DateTime ? $this->version_created_at->format($format) : null;
        }
    }

    /**
     * Get the [version_created_by] column value.
     *
     * @return   string
     */
    public function getVersionCreatedBy()
    {

        return $this->version_created_by;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[StoreTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [visible] column.
     *
     * @param      int $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setVisible($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible !== $v) {
            $this->visible = $v;
            $this->modifiedColumns[StoreTableMap::VISIBLE] = true;
        }


        return $this;
    } // setVisible()

    /**
     * Set the value of [position] column.
     *
     * @param      int $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[StoreTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [admin_id] column.
     *
     * @param      int $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setAdminId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->admin_id !== $v) {
            $this->admin_id = $v;
            $this->modifiedColumns[StoreTableMap::ADMIN_ID] = true;
        }

        if ($this->aAdmin !== null && $this->aAdmin->getId() !== $v) {
            $this->aAdmin = null;
        }


        return $this;
    } // setAdminId()

    /**
     * Set the value of [company] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setCompany($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->company !== $v) {
            $this->company = $v;
            $this->modifiedColumns[StoreTableMap::COMPANY] = true;
        }


        return $this;
    } // setCompany()

    /**
     * Set the value of [firstname] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[StoreTableMap::FIRSTNAME] = true;
        }


        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[StoreTableMap::LASTNAME] = true;
        }


        return $this;
    } // setLastname()

    /**
     * Set the value of [address1] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setAddress1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address1 !== $v) {
            $this->address1 = $v;
            $this->modifiedColumns[StoreTableMap::ADDRESS1] = true;
        }


        return $this;
    } // setAddress1()

    /**
     * Set the value of [address2] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setAddress2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address2 !== $v) {
            $this->address2 = $v;
            $this->modifiedColumns[StoreTableMap::ADDRESS2] = true;
        }


        return $this;
    } // setAddress2()

    /**
     * Set the value of [address3] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setAddress3($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address3 !== $v) {
            $this->address3 = $v;
            $this->modifiedColumns[StoreTableMap::ADDRESS3] = true;
        }


        return $this;
    } // setAddress3()

    /**
     * Set the value of [zipcode] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setZipcode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->zipcode !== $v) {
            $this->zipcode = $v;
            $this->modifiedColumns[StoreTableMap::ZIPCODE] = true;
        }


        return $this;
    } // setZipcode()

    /**
     * Set the value of [city] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->city !== $v) {
            $this->city = $v;
            $this->modifiedColumns[StoreTableMap::CITY] = true;
        }


        return $this;
    } // setCity()

    /**
     * Set the value of [phone] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[StoreTableMap::PHONE] = true;
        }


        return $this;
    } // setPhone()

    /**
     * Set the value of [cellphone] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setCellphone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cellphone !== $v) {
            $this->cellphone = $v;
            $this->modifiedColumns[StoreTableMap::CELLPHONE] = true;
        }


        return $this;
    } // setCellphone()

    /**
     * Set the value of [vat_number] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setVatNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->vat_number !== $v) {
            $this->vat_number = $v;
            $this->modifiedColumns[StoreTableMap::VAT_NUMBER] = true;
        }


        return $this;
    } // setVatNumber()

    /**
     * Set the value of [lat] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setLat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lat !== $v) {
            $this->lat = $v;
            $this->modifiedColumns[StoreTableMap::LAT] = true;
        }


        return $this;
    } // setLat()

    /**
     * Set the value of [lng] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setLng($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lng !== $v) {
            $this->lng = $v;
            $this->modifiedColumns[StoreTableMap::LNG] = true;
        }


        return $this;
    } // setLng()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[StoreTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[StoreTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     *
     * @param      int $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[StoreTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[StoreTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param      string $v new value
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[StoreTableMap::VERSION_CREATED_BY] = true;
        }


        return $this;
    } // setVersionCreatedBy()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->visible !== 0) {
                return false;
            }

            if ($this->position !== 0) {
                return false;
            }

            if ($this->version !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : StoreTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : StoreTableMap::translateFieldName('Visible', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : StoreTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : StoreTableMap::translateFieldName('AdminId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->admin_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : StoreTableMap::translateFieldName('Company', TableMap::TYPE_PHPNAME, $indexType)];
            $this->company = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : StoreTableMap::translateFieldName('Firstname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firstname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : StoreTableMap::translateFieldName('Lastname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lastname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : StoreTableMap::translateFieldName('Address1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : StoreTableMap::translateFieldName('Address2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : StoreTableMap::translateFieldName('Address3', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address3 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : StoreTableMap::translateFieldName('Zipcode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->zipcode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : StoreTableMap::translateFieldName('City', TableMap::TYPE_PHPNAME, $indexType)];
            $this->city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : StoreTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : StoreTableMap::translateFieldName('Cellphone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cellphone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : StoreTableMap::translateFieldName('VatNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vat_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : StoreTableMap::translateFieldName('Lat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : StoreTableMap::translateFieldName('Lng', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lng = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : StoreTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : StoreTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : StoreTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : StoreTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : StoreTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 22; // 22 = StoreTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Store\Model\Store object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aAdmin !== null && $this->admin_id !== $this->aAdmin->getId()) {
            $this->aAdmin = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StoreTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildStoreQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAdmin = null;
            $this->collStoreI18ns = null;

            $this->collStoreVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Store::setDeleted()
     * @see Store::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildStoreQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StoreTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(StoreTableMap::VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(StoreTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(StoreTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(StoreTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                // versionable behavior
                if (isset($createVersion)) {
                    $this->addVersion($con);
                }
                StoreTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAdmin !== null) {
                if ($this->aAdmin->isModified() || $this->aAdmin->isNew()) {
                    $affectedRows += $this->aAdmin->save($con);
                }
                $this->setAdmin($this->aAdmin);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->storeI18nsScheduledForDeletion !== null) {
                if (!$this->storeI18nsScheduledForDeletion->isEmpty()) {
                    \Store\Model\StoreI18nQuery::create()
                        ->filterByPrimaryKeys($this->storeI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->storeI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collStoreI18ns !== null) {
            foreach ($this->collStoreI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->storeVersionsScheduledForDeletion !== null) {
                if (!$this->storeVersionsScheduledForDeletion->isEmpty()) {
                    \Store\Model\StoreVersionQuery::create()
                        ->filterByPrimaryKeys($this->storeVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->storeVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collStoreVersions !== null) {
            foreach ($this->collStoreVersions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[StoreTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StoreTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StoreTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(StoreTableMap::VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE';
        }
        if ($this->isColumnModified(StoreTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(StoreTableMap::ADMIN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ADMIN_ID';
        }
        if ($this->isColumnModified(StoreTableMap::COMPANY)) {
            $modifiedColumns[':p' . $index++]  = 'COMPANY';
        }
        if ($this->isColumnModified(StoreTableMap::FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'FIRSTNAME';
        }
        if ($this->isColumnModified(StoreTableMap::LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'LASTNAME';
        }
        if ($this->isColumnModified(StoreTableMap::ADDRESS1)) {
            $modifiedColumns[':p' . $index++]  = 'ADDRESS1';
        }
        if ($this->isColumnModified(StoreTableMap::ADDRESS2)) {
            $modifiedColumns[':p' . $index++]  = 'ADDRESS2';
        }
        if ($this->isColumnModified(StoreTableMap::ADDRESS3)) {
            $modifiedColumns[':p' . $index++]  = 'ADDRESS3';
        }
        if ($this->isColumnModified(StoreTableMap::ZIPCODE)) {
            $modifiedColumns[':p' . $index++]  = 'ZIPCODE';
        }
        if ($this->isColumnModified(StoreTableMap::CITY)) {
            $modifiedColumns[':p' . $index++]  = 'CITY';
        }
        if ($this->isColumnModified(StoreTableMap::PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'PHONE';
        }
        if ($this->isColumnModified(StoreTableMap::CELLPHONE)) {
            $modifiedColumns[':p' . $index++]  = 'CELLPHONE';
        }
        if ($this->isColumnModified(StoreTableMap::VAT_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'VAT_NUMBER';
        }
        if ($this->isColumnModified(StoreTableMap::LAT)) {
            $modifiedColumns[':p' . $index++]  = 'LAT';
        }
        if ($this->isColumnModified(StoreTableMap::LNG)) {
            $modifiedColumns[':p' . $index++]  = 'LNG';
        }
        if ($this->isColumnModified(StoreTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(StoreTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(StoreTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(StoreTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(StoreTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO store (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE':
                        $stmt->bindValue($identifier, $this->visible, PDO::PARAM_INT);
                        break;
                    case 'POSITION':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'ADMIN_ID':
                        $stmt->bindValue($identifier, $this->admin_id, PDO::PARAM_INT);
                        break;
                    case 'COMPANY':
                        $stmt->bindValue($identifier, $this->company, PDO::PARAM_STR);
                        break;
                    case 'FIRSTNAME':
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case 'LASTNAME':
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case 'ADDRESS1':
                        $stmt->bindValue($identifier, $this->address1, PDO::PARAM_STR);
                        break;
                    case 'ADDRESS2':
                        $stmt->bindValue($identifier, $this->address2, PDO::PARAM_STR);
                        break;
                    case 'ADDRESS3':
                        $stmt->bindValue($identifier, $this->address3, PDO::PARAM_STR);
                        break;
                    case 'ZIPCODE':
                        $stmt->bindValue($identifier, $this->zipcode, PDO::PARAM_STR);
                        break;
                    case 'CITY':
                        $stmt->bindValue($identifier, $this->city, PDO::PARAM_STR);
                        break;
                    case 'PHONE':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case 'CELLPHONE':
                        $stmt->bindValue($identifier, $this->cellphone, PDO::PARAM_STR);
                        break;
                    case 'VAT_NUMBER':
                        $stmt->bindValue($identifier, $this->vat_number, PDO::PARAM_STR);
                        break;
                    case 'LAT':
                        $stmt->bindValue($identifier, $this->lat, PDO::PARAM_STR);
                        break;
                    case 'LNG':
                        $stmt->bindValue($identifier, $this->lng, PDO::PARAM_STR);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'VERSION':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case 'VERSION_CREATED_AT':
                        $stmt->bindValue($identifier, $this->version_created_at ? $this->version_created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'VERSION_CREATED_BY':
                        $stmt->bindValue($identifier, $this->version_created_by, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StoreTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getVisible();
                break;
            case 2:
                return $this->getPosition();
                break;
            case 3:
                return $this->getAdminId();
                break;
            case 4:
                return $this->getCompany();
                break;
            case 5:
                return $this->getFirstname();
                break;
            case 6:
                return $this->getLastname();
                break;
            case 7:
                return $this->getAddress1();
                break;
            case 8:
                return $this->getAddress2();
                break;
            case 9:
                return $this->getAddress3();
                break;
            case 10:
                return $this->getZipcode();
                break;
            case 11:
                return $this->getCity();
                break;
            case 12:
                return $this->getPhone();
                break;
            case 13:
                return $this->getCellphone();
                break;
            case 14:
                return $this->getVatNumber();
                break;
            case 15:
                return $this->getLat();
                break;
            case 16:
                return $this->getLng();
                break;
            case 17:
                return $this->getCreatedAt();
                break;
            case 18:
                return $this->getUpdatedAt();
                break;
            case 19:
                return $this->getVersion();
                break;
            case 20:
                return $this->getVersionCreatedAt();
                break;
            case 21:
                return $this->getVersionCreatedBy();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Store'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Store'][$this->getPrimaryKey()] = true;
        $keys = StoreTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getVisible(),
            $keys[2] => $this->getPosition(),
            $keys[3] => $this->getAdminId(),
            $keys[4] => $this->getCompany(),
            $keys[5] => $this->getFirstname(),
            $keys[6] => $this->getLastname(),
            $keys[7] => $this->getAddress1(),
            $keys[8] => $this->getAddress2(),
            $keys[9] => $this->getAddress3(),
            $keys[10] => $this->getZipcode(),
            $keys[11] => $this->getCity(),
            $keys[12] => $this->getPhone(),
            $keys[13] => $this->getCellphone(),
            $keys[14] => $this->getVatNumber(),
            $keys[15] => $this->getLat(),
            $keys[16] => $this->getLng(),
            $keys[17] => $this->getCreatedAt(),
            $keys[18] => $this->getUpdatedAt(),
            $keys[19] => $this->getVersion(),
            $keys[20] => $this->getVersionCreatedAt(),
            $keys[21] => $this->getVersionCreatedBy(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAdmin) {
                $result['Admin'] = $this->aAdmin->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collStoreI18ns) {
                $result['StoreI18ns'] = $this->collStoreI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStoreVersions) {
                $result['StoreVersions'] = $this->collStoreVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StoreTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setVisible($value);
                break;
            case 2:
                $this->setPosition($value);
                break;
            case 3:
                $this->setAdminId($value);
                break;
            case 4:
                $this->setCompany($value);
                break;
            case 5:
                $this->setFirstname($value);
                break;
            case 6:
                $this->setLastname($value);
                break;
            case 7:
                $this->setAddress1($value);
                break;
            case 8:
                $this->setAddress2($value);
                break;
            case 9:
                $this->setAddress3($value);
                break;
            case 10:
                $this->setZipcode($value);
                break;
            case 11:
                $this->setCity($value);
                break;
            case 12:
                $this->setPhone($value);
                break;
            case 13:
                $this->setCellphone($value);
                break;
            case 14:
                $this->setVatNumber($value);
                break;
            case 15:
                $this->setLat($value);
                break;
            case 16:
                $this->setLng($value);
                break;
            case 17:
                $this->setCreatedAt($value);
                break;
            case 18:
                $this->setUpdatedAt($value);
                break;
            case 19:
                $this->setVersion($value);
                break;
            case 20:
                $this->setVersionCreatedAt($value);
                break;
            case 21:
                $this->setVersionCreatedBy($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = StoreTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setVisible($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPosition($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAdminId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCompany($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setFirstname($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setLastname($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setAddress1($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setAddress2($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setAddress3($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setZipcode($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setCity($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setPhone($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setCellphone($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setVatNumber($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setLat($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setLng($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setCreatedAt($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setUpdatedAt($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setVersion($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setVersionCreatedAt($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setVersionCreatedBy($arr[$keys[21]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(StoreTableMap::DATABASE_NAME);

        if ($this->isColumnModified(StoreTableMap::ID)) $criteria->add(StoreTableMap::ID, $this->id);
        if ($this->isColumnModified(StoreTableMap::VISIBLE)) $criteria->add(StoreTableMap::VISIBLE, $this->visible);
        if ($this->isColumnModified(StoreTableMap::POSITION)) $criteria->add(StoreTableMap::POSITION, $this->position);
        if ($this->isColumnModified(StoreTableMap::ADMIN_ID)) $criteria->add(StoreTableMap::ADMIN_ID, $this->admin_id);
        if ($this->isColumnModified(StoreTableMap::COMPANY)) $criteria->add(StoreTableMap::COMPANY, $this->company);
        if ($this->isColumnModified(StoreTableMap::FIRSTNAME)) $criteria->add(StoreTableMap::FIRSTNAME, $this->firstname);
        if ($this->isColumnModified(StoreTableMap::LASTNAME)) $criteria->add(StoreTableMap::LASTNAME, $this->lastname);
        if ($this->isColumnModified(StoreTableMap::ADDRESS1)) $criteria->add(StoreTableMap::ADDRESS1, $this->address1);
        if ($this->isColumnModified(StoreTableMap::ADDRESS2)) $criteria->add(StoreTableMap::ADDRESS2, $this->address2);
        if ($this->isColumnModified(StoreTableMap::ADDRESS3)) $criteria->add(StoreTableMap::ADDRESS3, $this->address3);
        if ($this->isColumnModified(StoreTableMap::ZIPCODE)) $criteria->add(StoreTableMap::ZIPCODE, $this->zipcode);
        if ($this->isColumnModified(StoreTableMap::CITY)) $criteria->add(StoreTableMap::CITY, $this->city);
        if ($this->isColumnModified(StoreTableMap::PHONE)) $criteria->add(StoreTableMap::PHONE, $this->phone);
        if ($this->isColumnModified(StoreTableMap::CELLPHONE)) $criteria->add(StoreTableMap::CELLPHONE, $this->cellphone);
        if ($this->isColumnModified(StoreTableMap::VAT_NUMBER)) $criteria->add(StoreTableMap::VAT_NUMBER, $this->vat_number);
        if ($this->isColumnModified(StoreTableMap::LAT)) $criteria->add(StoreTableMap::LAT, $this->lat);
        if ($this->isColumnModified(StoreTableMap::LNG)) $criteria->add(StoreTableMap::LNG, $this->lng);
        if ($this->isColumnModified(StoreTableMap::CREATED_AT)) $criteria->add(StoreTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(StoreTableMap::UPDATED_AT)) $criteria->add(StoreTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(StoreTableMap::VERSION)) $criteria->add(StoreTableMap::VERSION, $this->version);
        if ($this->isColumnModified(StoreTableMap::VERSION_CREATED_AT)) $criteria->add(StoreTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(StoreTableMap::VERSION_CREATED_BY)) $criteria->add(StoreTableMap::VERSION_CREATED_BY, $this->version_created_by);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(StoreTableMap::DATABASE_NAME);
        $criteria->add(StoreTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Store\Model\Store (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setVisible($this->getVisible());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setAdminId($this->getAdminId());
        $copyObj->setCompany($this->getCompany());
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setAddress1($this->getAddress1());
        $copyObj->setAddress2($this->getAddress2());
        $copyObj->setAddress3($this->getAddress3());
        $copyObj->setZipcode($this->getZipcode());
        $copyObj->setCity($this->getCity());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setCellphone($this->getCellphone());
        $copyObj->setVatNumber($this->getVatNumber());
        $copyObj->setLat($this->getLat());
        $copyObj->setLng($this->getLng());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getStoreI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStoreI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStoreVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStoreVersion($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \Store\Model\Store Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildAdmin object.
     *
     * @param                  ChildAdmin $v
     * @return                 \Store\Model\Store The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdmin(ChildAdmin $v = null)
    {
        if ($v === null) {
            $this->setAdminId(NULL);
        } else {
            $this->setAdminId($v->getId());
        }

        $this->aAdmin = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAdmin object, it will not be re-added.
        if ($v !== null) {
            $v->addStore($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAdmin object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildAdmin The associated ChildAdmin object.
     * @throws PropelException
     */
    public function getAdmin(ConnectionInterface $con = null)
    {
        if ($this->aAdmin === null && ($this->admin_id !== null)) {
            $this->aAdmin = AdminQuery::create()->findPk($this->admin_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdmin->addStores($this);
             */
        }

        return $this->aAdmin;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('StoreI18n' == $relationName) {
            return $this->initStoreI18ns();
        }
        if ('StoreVersion' == $relationName) {
            return $this->initStoreVersions();
        }
    }

    /**
     * Clears out the collStoreI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStoreI18ns()
     */
    public function clearStoreI18ns()
    {
        $this->collStoreI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStoreI18ns collection loaded partially.
     */
    public function resetPartialStoreI18ns($v = true)
    {
        $this->collStoreI18nsPartial = $v;
    }

    /**
     * Initializes the collStoreI18ns collection.
     *
     * By default this just sets the collStoreI18ns collection to an empty array (like clearcollStoreI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStoreI18ns($overrideExisting = true)
    {
        if (null !== $this->collStoreI18ns && !$overrideExisting) {
            return;
        }
        $this->collStoreI18ns = new ObjectCollection();
        $this->collStoreI18ns->setModel('\Store\Model\StoreI18n');
    }

    /**
     * Gets an array of ChildStoreI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStore is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildStoreI18n[] List of ChildStoreI18n objects
     * @throws PropelException
     */
    public function getStoreI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStoreI18nsPartial && !$this->isNew();
        if (null === $this->collStoreI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStoreI18ns) {
                // return empty collection
                $this->initStoreI18ns();
            } else {
                $collStoreI18ns = ChildStoreI18nQuery::create(null, $criteria)
                    ->filterByStore($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStoreI18nsPartial && count($collStoreI18ns)) {
                        $this->initStoreI18ns(false);

                        foreach ($collStoreI18ns as $obj) {
                            if (false == $this->collStoreI18ns->contains($obj)) {
                                $this->collStoreI18ns->append($obj);
                            }
                        }

                        $this->collStoreI18nsPartial = true;
                    }

                    reset($collStoreI18ns);

                    return $collStoreI18ns;
                }

                if ($partial && $this->collStoreI18ns) {
                    foreach ($this->collStoreI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collStoreI18ns[] = $obj;
                        }
                    }
                }

                $this->collStoreI18ns = $collStoreI18ns;
                $this->collStoreI18nsPartial = false;
            }
        }

        return $this->collStoreI18ns;
    }

    /**
     * Sets a collection of StoreI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $storeI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildStore The current object (for fluent API support)
     */
    public function setStoreI18ns(Collection $storeI18ns, ConnectionInterface $con = null)
    {
        $storeI18nsToDelete = $this->getStoreI18ns(new Criteria(), $con)->diff($storeI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->storeI18nsScheduledForDeletion = clone $storeI18nsToDelete;

        foreach ($storeI18nsToDelete as $storeI18nRemoved) {
            $storeI18nRemoved->setStore(null);
        }

        $this->collStoreI18ns = null;
        foreach ($storeI18ns as $storeI18n) {
            $this->addStoreI18n($storeI18n);
        }

        $this->collStoreI18ns = $storeI18ns;
        $this->collStoreI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StoreI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StoreI18n objects.
     * @throws PropelException
     */
    public function countStoreI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStoreI18nsPartial && !$this->isNew();
        if (null === $this->collStoreI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStoreI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStoreI18ns());
            }

            $query = ChildStoreI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStore($this)
                ->count($con);
        }

        return count($this->collStoreI18ns);
    }

    /**
     * Method called to associate a ChildStoreI18n object to this object
     * through the ChildStoreI18n foreign key attribute.
     *
     * @param    ChildStoreI18n $l ChildStoreI18n
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function addStoreI18n(ChildStoreI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collStoreI18ns === null) {
            $this->initStoreI18ns();
            $this->collStoreI18nsPartial = true;
        }

        if (!in_array($l, $this->collStoreI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStoreI18n($l);
        }

        return $this;
    }

    /**
     * @param StoreI18n $storeI18n The storeI18n object to add.
     */
    protected function doAddStoreI18n($storeI18n)
    {
        $this->collStoreI18ns[]= $storeI18n;
        $storeI18n->setStore($this);
    }

    /**
     * @param  StoreI18n $storeI18n The storeI18n object to remove.
     * @return ChildStore The current object (for fluent API support)
     */
    public function removeStoreI18n($storeI18n)
    {
        if ($this->getStoreI18ns()->contains($storeI18n)) {
            $this->collStoreI18ns->remove($this->collStoreI18ns->search($storeI18n));
            if (null === $this->storeI18nsScheduledForDeletion) {
                $this->storeI18nsScheduledForDeletion = clone $this->collStoreI18ns;
                $this->storeI18nsScheduledForDeletion->clear();
            }
            $this->storeI18nsScheduledForDeletion[]= clone $storeI18n;
            $storeI18n->setStore(null);
        }

        return $this;
    }

    /**
     * Clears out the collStoreVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStoreVersions()
     */
    public function clearStoreVersions()
    {
        $this->collStoreVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStoreVersions collection loaded partially.
     */
    public function resetPartialStoreVersions($v = true)
    {
        $this->collStoreVersionsPartial = $v;
    }

    /**
     * Initializes the collStoreVersions collection.
     *
     * By default this just sets the collStoreVersions collection to an empty array (like clearcollStoreVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStoreVersions($overrideExisting = true)
    {
        if (null !== $this->collStoreVersions && !$overrideExisting) {
            return;
        }
        $this->collStoreVersions = new ObjectCollection();
        $this->collStoreVersions->setModel('\Store\Model\StoreVersion');
    }

    /**
     * Gets an array of ChildStoreVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStore is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildStoreVersion[] List of ChildStoreVersion objects
     * @throws PropelException
     */
    public function getStoreVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStoreVersionsPartial && !$this->isNew();
        if (null === $this->collStoreVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStoreVersions) {
                // return empty collection
                $this->initStoreVersions();
            } else {
                $collStoreVersions = ChildStoreVersionQuery::create(null, $criteria)
                    ->filterByStore($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStoreVersionsPartial && count($collStoreVersions)) {
                        $this->initStoreVersions(false);

                        foreach ($collStoreVersions as $obj) {
                            if (false == $this->collStoreVersions->contains($obj)) {
                                $this->collStoreVersions->append($obj);
                            }
                        }

                        $this->collStoreVersionsPartial = true;
                    }

                    reset($collStoreVersions);

                    return $collStoreVersions;
                }

                if ($partial && $this->collStoreVersions) {
                    foreach ($this->collStoreVersions as $obj) {
                        if ($obj->isNew()) {
                            $collStoreVersions[] = $obj;
                        }
                    }
                }

                $this->collStoreVersions = $collStoreVersions;
                $this->collStoreVersionsPartial = false;
            }
        }

        return $this->collStoreVersions;
    }

    /**
     * Sets a collection of StoreVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $storeVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildStore The current object (for fluent API support)
     */
    public function setStoreVersions(Collection $storeVersions, ConnectionInterface $con = null)
    {
        $storeVersionsToDelete = $this->getStoreVersions(new Criteria(), $con)->diff($storeVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->storeVersionsScheduledForDeletion = clone $storeVersionsToDelete;

        foreach ($storeVersionsToDelete as $storeVersionRemoved) {
            $storeVersionRemoved->setStore(null);
        }

        $this->collStoreVersions = null;
        foreach ($storeVersions as $storeVersion) {
            $this->addStoreVersion($storeVersion);
        }

        $this->collStoreVersions = $storeVersions;
        $this->collStoreVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StoreVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StoreVersion objects.
     * @throws PropelException
     */
    public function countStoreVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStoreVersionsPartial && !$this->isNew();
        if (null === $this->collStoreVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStoreVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStoreVersions());
            }

            $query = ChildStoreVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStore($this)
                ->count($con);
        }

        return count($this->collStoreVersions);
    }

    /**
     * Method called to associate a ChildStoreVersion object to this object
     * through the ChildStoreVersion foreign key attribute.
     *
     * @param    ChildStoreVersion $l ChildStoreVersion
     * @return   \Store\Model\Store The current object (for fluent API support)
     */
    public function addStoreVersion(ChildStoreVersion $l)
    {
        if ($this->collStoreVersions === null) {
            $this->initStoreVersions();
            $this->collStoreVersionsPartial = true;
        }

        if (!in_array($l, $this->collStoreVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStoreVersion($l);
        }

        return $this;
    }

    /**
     * @param StoreVersion $storeVersion The storeVersion object to add.
     */
    protected function doAddStoreVersion($storeVersion)
    {
        $this->collStoreVersions[]= $storeVersion;
        $storeVersion->setStore($this);
    }

    /**
     * @param  StoreVersion $storeVersion The storeVersion object to remove.
     * @return ChildStore The current object (for fluent API support)
     */
    public function removeStoreVersion($storeVersion)
    {
        if ($this->getStoreVersions()->contains($storeVersion)) {
            $this->collStoreVersions->remove($this->collStoreVersions->search($storeVersion));
            if (null === $this->storeVersionsScheduledForDeletion) {
                $this->storeVersionsScheduledForDeletion = clone $this->collStoreVersions;
                $this->storeVersionsScheduledForDeletion->clear();
            }
            $this->storeVersionsScheduledForDeletion[]= clone $storeVersion;
            $storeVersion->setStore(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->visible = null;
        $this->position = null;
        $this->admin_id = null;
        $this->company = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->address1 = null;
        $this->address2 = null;
        $this->address3 = null;
        $this->zipcode = null;
        $this->city = null;
        $this->phone = null;
        $this->cellphone = null;
        $this->vat_number = null;
        $this->lat = null;
        $this->lng = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collStoreI18ns) {
                foreach ($this->collStoreI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStoreVersions) {
                foreach ($this->collStoreVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        $this->collStoreI18ns = null;
        $this->collStoreVersions = null;
        $this->aAdmin = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StoreTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildStore The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[StoreTableMap::UPDATED_AT] = true;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    ChildStore The current object (for fluent API support)
     */
    public function setLocale($locale = 'en_US')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildStoreI18n */
    public function getTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collStoreI18ns) {
                foreach ($this->collStoreI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildStoreI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildStoreI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addStoreI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    ChildStore The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildStoreI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collStoreI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collStoreI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildStoreI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [title] column value.
         *
         * @return   string
         */
        public function getTitle()
        {
        return $this->getCurrentTranslation()->getTitle();
    }


        /**
         * Set the value of [title] column.
         *
         * @param      string $v new value
         * @return   \Store\Model\StoreI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);

        return $this;
    }


        /**
         * Get the [description] column value.
         *
         * @return   string
         */
        public function getDescription()
        {
        return $this->getCurrentTranslation()->getDescription();
    }


        /**
         * Set the value of [description] column.
         *
         * @param      string $v new value
         * @return   \Store\Model\StoreI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

        return $this;
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \Store\Model\Store
     */
    public function enforceVersioning()
    {
        $this->enforceVersion = true;

        return $this;
    }

    /**
     * Checks whether the current state must be recorded as a version
     *
     * @return  boolean
     */
    public function isVersioningNecessary($con = null)
    {
        if ($this->alreadyInSave) {
            return false;
        }

        if ($this->enforceVersion) {
            return true;
        }

        if (ChildStoreQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }

        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildStoreVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildStoreVersion();
        $version->setId($this->getId());
        $version->setVisible($this->getVisible());
        $version->setPosition($this->getPosition());
        $version->setAdminId($this->getAdminId());
        $version->setCompany($this->getCompany());
        $version->setFirstname($this->getFirstname());
        $version->setLastname($this->getLastname());
        $version->setAddress1($this->getAddress1());
        $version->setAddress2($this->getAddress2());
        $version->setAddress3($this->getAddress3());
        $version->setZipcode($this->getZipcode());
        $version->setCity($this->getCity());
        $version->setPhone($this->getPhone());
        $version->setCellphone($this->getCellphone());
        $version->setVatNumber($this->getVatNumber());
        $version->setLat($this->getLat());
        $version->setLng($this->getLng());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setStore($this);
        $version->save($con);

        return $version;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  ChildStore The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildStore object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildStoreVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildStore The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildStore'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setVisible($version->getVisible());
        $this->setPosition($version->getPosition());
        $this->setAdminId($version->getAdminId());
        $this->setCompany($version->getCompany());
        $this->setFirstname($version->getFirstname());
        $this->setLastname($version->getLastname());
        $this->setAddress1($version->getAddress1());
        $this->setAddress2($version->getAddress2());
        $this->setAddress3($version->getAddress3());
        $this->setZipcode($version->getZipcode());
        $this->setCity($version->getCity());
        $this->setPhone($version->getPhone());
        $this->setCellphone($version->getCellphone());
        $this->setVatNumber($version->getVatNumber());
        $this->setLat($version->getLat());
        $this->setLng($version->getLng());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());

        return $this;
    }

    /**
     * Gets the latest persisted version number for the current object
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  integer
     */
    public function getLastVersionNumber($con = null)
    {
        $v = ChildStoreVersionQuery::create()
            ->filterByStore($this)
            ->orderByVersion('desc')
            ->findOne($con);
        if (!$v) {
            return 0;
        }

        return $v->getVersion();
    }

    /**
     * Checks whether the current object is the latest one
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  Boolean
     */
    public function isLastVersion($con = null)
    {
        return $this->getLastVersionNumber($con) == $this->getVersion();
    }

    /**
     * Retrieves a version object for this entity and a version number
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildStoreVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildStoreVersionQuery::create()
            ->filterByStore($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildStoreVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(StoreVersionTableMap::VERSION);

        return $this->getStoreVersions($criteria, $con);
    }

    /**
     * Compares the current object with another of its version.
     * <code>
     * print_r($book->compareVersion(1));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $versionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersion($versionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->toArray();
        $toVersion = $this->getOneVersion($versionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Compares two versions of the current object.
     * <code>
     * print_r($book->compareVersions(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $fromVersionNumber
     * @param   integer             $toVersionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersions($fromVersionNumber, $toVersionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->getOneVersion($fromVersionNumber, $con)->toArray();
        $toVersion = $this->getOneVersion($toVersionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Computes the diff between two versions.
     * <code>
     * print_r($book->computeDiff(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   array     $fromVersion     An array representing the original version.
     * @param   array     $toVersion       An array representing the destination version.
     * @param   string    $keys            Main key used for the result diff (versions|columns).
     * @param   array     $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    protected function computeDiff($fromVersion, $toVersion, $keys = 'columns', $ignoredColumns = array())
    {
        $fromVersionNumber = $fromVersion['Version'];
        $toVersionNumber = $toVersion['Version'];
        $ignoredColumns = array_merge(array(
            'Version',
            'VersionCreatedAt',
            'VersionCreatedBy',
        ), $ignoredColumns);
        $diff = array();
        foreach ($fromVersion as $key => $value) {
            if (in_array($key, $ignoredColumns)) {
                continue;
            }
            if ($toVersion[$key] != $value) {
                switch ($keys) {
                    case 'versions':
                        $diff[$fromVersionNumber][$key] = $value;
                        $diff[$toVersionNumber][$key] = $toVersion[$key];
                        break;
                    default:
                        $diff[$key] = array(
                            $fromVersionNumber => $value,
                            $toVersionNumber => $toVersion[$key],
                        );
                        break;
                }
            }
        }

        return $diff;
    }
    /**
     * retrieve the last $number versions.
     *
     * @param Integer $number the number of record to return.
     * @return PropelCollection|array \Store\Model\StoreVersion[] List of \Store\Model\StoreVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildStoreVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(StoreVersionTableMap::VERSION);
        $criteria->limit($number);

        return $this->getStoreVersions($criteria, $con);
    }
    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
