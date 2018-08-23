<?php
namespace agsource\datasource;

require_once('iDataField.php');
require_once('iDataConversion.php');

/**
 * Name:  DbField
 *
 * Author: ctranel
 *
 * Created:  02-03-2015
 *
 * Description:  Metadata typically associated with data storage for data fields.
 *
 */
class DbField implements iDataField {
	/**
	 * id
	 * @var int
	 **/
	protected $id;
	
	/**
	 * db_table
	 * @var \agsource\datasource\DbTable
	 **/
	protected $db_table;
	
	/**
	 * db field name
	 * @var int
	 **/
	protected $db_field_name;
	
	/**
	 * field name
	 * @var string
	 **/
	protected $name;
	
	/**
	 * field description
	 * @var string
	 **/
	protected $description;
	
	/**
	 * pdf_width
	 * @var int
	 **/
	protected $pdf_width;
	
	/**
	 * default_sort_order
	 * @var string
	 **/
	protected $default_sort_order;
	
	/**
	 * datatype
	 * @var string
	 **/
	protected $datatype;
	
	/**
	 * max_length
	 * @var int
	 **/
	protected $max_length;
	
	/**
	 * decimal_scale
	 * @var int
	 **/
	protected $decimal_scale;
	
	/**
	 * unit_of_measure
	 * @var string
	 **/
	protected $unit_of_measure;
	
	/**
	 * is_timespan
	 * @var boolean
	 **/
	protected $is_timespan;
	
	/**
	 * is_key
	 * @var boolean
	 **/
	protected $is_key;

    /**
     * is_lookup
     * @var boolean
     **/
    protected $is_lookup;

    /**
     * lookup_type
     * @var int
     **/
    protected $lookup_type;

    /**
     * is_internal
     * @var boolean
     **/
    protected $is_internal;

    /**
	 * is_nullable
	 * @var boolean
	 **/
	protected $is_nullable;
	
	/**
	 * is_natural_sort
	 * @var boolean
	 **/
	protected $is_natural_sort;

    /**
     * is_serialized
     * @var boolean
     **/
    protected $is_serialized;

    /**
     * data_conversion
     * @var iDataConversion
     **/
    protected $data_conversion;


    /**
	 */
	function __construct($field_data, iDataTable $db_table = null, iDataConversion $data_conversion=null) {
		$this->id = $field_data['db_field_id'];
		$this->db_field_name = $field_data['db_field_name'];
		$this->name = $field_data['name'];
		$this->description = $field_data['description'];
		$this->pdf_width = $field_data['pdf_width'];
		$this->default_sort_order = $field_data['default_sort_order'];
		$this->datatype = $field_data['datatype'];
		$this->max_length = $field_data['max_length'];
		$this->decimal_scale = $field_data['decimal_scale'];
		$this->unit_of_measure = $field_data['unit_of_measure'];
		$this->is_timespan = (bool)$field_data['is_timespan'];
		$this->is_key = (bool)$field_data['is_key'];
        $this->is_lookup = (bool)$field_data['is_lookup'];
        $this->lookup_type = (int)$field_data['lookup_type'];
        $this->is_internal = (bool)$field_data['is_internal'];
		$this->is_nullable = (bool)$field_data['is_nullable'];
		$this->is_natural_sort = (bool)$field_data['is_natural_sort'];
        $this->is_serialized = (bool)$field_data['is_serialized'];
        $this->db_table = $db_table;
        $this->data_conversion = $data_conversion;
	}

	public function isKey(){
        return $this->is_key;
    }

    public function maxLength(){
        return $this->max_length;
    }

    public function isLookup(){
        return $this->is_lookup;
    }

    public function lookupType(){
        return $this->lookup_type;
    }

    public function isSerialized(){
        return $this->is_serialized;
    }

    public function toArray(){
        $ret = [
            'db_field_id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'default_sort_order' => $this->default_sort_order,
            'datatype' => $this->datatype,
            'max_length' => $this->max_length,
            'decimal_scale' => $this->decimal_scale,
            'unit_of_measure' => $this->unit_of_measure,
            'is_timespan' => $this->is_timespan,
            'db_field_name' => $this->db_field_name,
            'is_natural_sort' => $this->is_natural_sort,
        ];
        return $ret;
    }
	
	public function dbFieldName(){
		return $this->db_field_name;
	}

    public function fullDbFieldName(){
        if(!isset($this->db_table)){
            return $this->db_field_name;
        }

	    $table_name = $this->db_table->tableName();

        return $table_name . '.' . $this->db_field_name;
    }

    public function validTableAndField(){
        if($this->dbTable() === null){
	        return false;
        }
	    return $this->dbTable()->field_exists($this->db_field_name);
    }

    public function label(){
        return $this->name;
    }

	public function dbTableName(){
		return $this->db_table->tableName();
	}

    public function dbTable(){
        return $this->db_table;
    }

    public function unitOfMeasure(){
		return $this->unit_of_measure;
	}
	
	public function dataType(){
		return $this->datatype;
	}

	public function decimalScale(){
		return $this->decimal_scale;
	}

	public function pdfWidth(){
		return $this->pdf_width;
	}

	public function defaultSortOrder(){
		return $this->default_sort_order;
	}

	public function isNaturalSort(){
		return (bool)$this->is_natural_sort;
	}

    public function hasMetricConversion(){
        return is_a($this->data_conversion, '\myagsource\Datasource\iDataConversion');
    }

    public function conversionToMetricFactor(){
        return is_a($this->data_conversion, '\myagsource\Datasource\iDataConversion') ? $this->data_conversion->metricFactor() : 1;
    }

    public function isNumeric(){
		//@todo: database neutral
		return (strpos($this->datatype, 'int') !== false) || (strpos($this->datatype, 'money') !== false) || (strpos($this->datatype, 'decimal') !== false) || $this->datatype === 'float' || $this->datatype === 'numeric' || $this->datatype === 'real';
	}

    /**
     * @method selectFieldText()
     *
     * Returns SQL text for select statement
     *
     * @param boolean is report to be displayed as metric?
     * @param string report aggregate
     * @return string of sql select statement text for field
     * @access public
     * @todo: should this be in model?
     * */
    public function selectFieldText($is_metric, $aggregate) {
        $field_text = $this->db_table->tableName() . "." . $this->db_field_name;

        //if it has metric conversion, convert it and set alias
        if($is_metric && $this->hasMetricConversion()){
            $alias_field_name = $this->db_field_name;
            $field_text = "(ROUND(" . $this->conversionToMetricFactor() . "*" . $field_text . ", 1))";
        }
        //if it has an aggregate, set aggregate and alias
        if(isset($aggregate) && !empty($aggregate)){
            $alias_field_name = strtolower($aggregate) . '_' . $this->db_field_name;
            $field_text = $aggregate . '(' . $field_text . ')';
            if($this->isNumeric()) {
                $field_text = 'ROUND(' . $field_text . ', ' . $this->decimal_scale . ')';
            }
        }
        else { //if it was an aggregate, no need to format
            // if it is a decimal datatype, set alias and round it
            if ($this->datatype === "decimal" && isset($this->decimal_scale) && (!isset($aggregate) || empty($aggregate))) {
                $alias_field_name = $this->db_field_name;
                $field_text = 'ROUND(' . $field_text . ', ' . $this->decimal_scale . ')';
            }
            //handle dates
            if ($this->datatype === "date" || $this->datatype === "smalldatetime") {//in all cases, time was irrelevent for columsn of this datatype
                return "FORMAT(" . $field_text . ",  'yyyy-MM-dd', 'en-US') AS " . $this->db_field_name;
            }
            if ($this->datatype === "datetime") {
                return "FORMAT(" . $field_text . ",  'yyyy-MM-dd HH:mm:ss', 'en-US') AS " . $this->db_field_name;
            }
        }
        //put it all together
        return isset($alias_field_name) ? $field_text . " AS " . $alias_field_name : $field_text;
    }

    /**
     * @method benchSelectFieldText()
     *
     * Returns SQL text for select statement
     *
     * @param boolean is report to be displayed as metric?
     * @param string report aggregate
     * @return string of sql select statement text for field
     * @access public
     * @todo: should this be in model?
     * */
    public function benchSelectFieldText($is_metric, $aggregate) {
        $field_text = $this->db_table->tableName() . "." . $this->db_field_name;
        $conversion_text = $is_metric && $this->hasMetricConversion() ? ' * ' . $this->conversionToMetricFactor() : '';
        $alias_field_name = $this->db_field_name;
        if(isset($aggregate)){
            $alias_field_name = strtolower($aggregate) . '_' . $this->db_field_name;
        }

        if($this->decimal_scale > 0){
            $sql = "CAST(ROUND(AVG(CAST(" . $field_text . " AS DECIMAL(12,4)))" . $conversion_text . ", " . $this->decimal_scale . ") AS DECIMAL(12, " . $this->decimal_scale . ")) AS " . $alias_field_name;
        }
        else{
            $sql = "CAST(ROUND(AVG(CAST(" . $field_text . " AS DECIMAL(12,4)))" . $conversion_text . ", 0) AS INT) AS " . $alias_field_name;
        }

        return $sql;
    }
}

?>