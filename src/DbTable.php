<?php
namespace agsource\datasource;

require_once('iDataTable.php');

/* -----------------------------------------------------------------
 *  Library for db tables
 *
 *  Library for db tables
 *
 *  @category: 
 *  @package: 
 *  @author: ctranel
 *  @date: May 19, 2014
 *  @version: 1.0
 * -----------------------------------------------------------------
 */

class DbTable implements iDataTable
{
    /**
     * database name
     * @var string
     **/
    protected $database_name;

    /**
     * schema name
     * @var string
     **/
    protected $schema_name;

    /**
     * table name
     * @var string
     **/
    protected $table_name;

    /**
     * dataset_type
     * @var string tsql type (V = view, U = table, P = Stored Proc etc)
     **/
    protected $dataset_type;

    /**
     * db_table_model
     * @var object
     **/
    protected $db_table_model;

    /**
     * column_names
     * @var array of column names
     **/
    protected $column_names;

    public function __construct($full_table_name, $table_meta, $db_table_model){
        list($this->database_name, $this->schema_name, $this->table_name) = explode('.', $full_table_name);
        $this->db_table_model = $db_table_model;
        $this->dataset_type = $table_meta['dataset_type'];
    }

    /**
     * Checks whether given field exists in table
     *
     * Checks whether given field exists in table

     *  @since: 1.0
     *  @author: ctranel
     *  @date: May 19, 2014
     * @return boolean
     *  @throws:
     **/
    public function field_exists($col_name){
        if(!isset($this->column_names)){
            $this->setColumns();
        }

        return in_array($col_name, $this->column_names);
    }

    /**
     * columnNames
     *
     * returns all columns from given table

     *  @author: ctranel
     *  @date: 2017-02-20
     * @return array of column names
     *  @throws:
     **/
    public function columnNames(){
        if(!isset($this->column_names)){
            $this->setColumns();
        }
        return $this->column_names;
    }

    protected function setColumns(){
        if($this->dataset_type === 'P'){
            $this->column_names = $this->db_table_model->getColumnNamesFromMeta($this->database_name, $this->schema_name, $this->table_name);
        }
        else{
            $this->column_names = $this->db_table_model->getColumns($this->database_name, $this->table_name);
        }
    }

    /* -----------------------------------------------------------------
    *  tableName

    *  If a value is passed, the object variable is set to that value.
    *  If no value is passed, the current table name is passed.
    *  Returns false on failure

    *  @since: 1.0
    *  @author: ctranel
    *  @date: May 19, 2014
     * @param bool is fully qualified
    *  @return: string
    *  @throws:
    * -----------------------------------------------------------------*/
    function tableName($fully_qualified = true) {
        if($fully_qualified){
            return $this->database_name . '.' . $this->schema_name . '.' . $this->table_name;
        }
        return $this->table_name;
    }
}