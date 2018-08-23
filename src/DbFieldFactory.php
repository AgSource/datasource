<?php
namespace agsource\datasource;

require_once('iDatasourceFieldDatasource.php');
require_once('iDataFieldFactory.php');
require_once('DataConversion.php');
require_once('DbField.php');

class DbFieldFactory implements iDataFieldFactory
{
    /**
     * datasource
     * @var iDatasourceFieldDatasource
     **/
    protected $datasource;

    /**
     * data_table_factory
     * @var iDataTableFactory
     **/
    protected $data_table_factory;

    public function __construct(iDatasourceFieldDatasource $datasource, iDataTableFactory $data_table_factory){
        $this->datasource = $datasource;
        $this->data_table_factory = $data_table_factory;
    }

    /**
     * getFromData
     *
     * Takes meta data and returns a DbField object
     *
     * @method getFromData()
     * @param array of meta data
     * @return DbField
     * @access protected
     **/
    public function get($id){
        $d = $this->datasource->getFieldData($id);

        $data_conversion = null;
        $data_table = $this->data_table_factory->getTable($d['table_name']);
        if(isset($d['conversion_name'])) {
            $data_conversion = new DataConversion($d['conversion_name'], $d['metric_label'], $d['metric_abbrev'],
                                                  $d['to_metric_factor'], $d['metric_rounding_precision'], $d['imperial_label'], $d['imperial_abbrev'], $d['to_imperial_factor'], $d['imperial_rounding_precision']);
        }
        return new DbField($d, $data_table, $data_conversion);
        
    }

    /**
     * getFromData
     *
     * Takes meta data and returns a DbField object
     *
     * @method getFromData()
     * @param array of meta data
     * @return DbField
     * @access protected
     **/
    public function getFromData($d){
        $data_conversion = null;
        $data_table = $this->data_table_factory->getTable($d['table_name']);

        if(isset($d['conversion_name'])) {
            $data_conversion = new DataConversion($d['conversion_name'], $d['metric_label'], $d['metric_abbrev'],
                                                  $d['to_metric_factor'], $d['metric_rounding_precision'], $d['imperial_label'], $d['imperial_abbrev'], $d['to_imperial_factor'], $d['imperial_rounding_precision']);
        }
        return new DbField($d, $data_table, $data_conversion);

    }

    /**
     * getGeneralInfoByName
     *
     * Takes meta data and returns a DbField object based on first occurence of the given field name (db_field_name element required in array),
     * BUT DOES NOT INCLUDE SPECIFIC FIELD ID OR TABLE INFO
     *
     * @param string
     * @return DbField
     * @access protected
     **/
    public function getGeneralObjectFromData($data){
        if(!isset($data['db_field_name'])){
            throw new \Exception("Field name required in DBFieldFactory.");
        }

        $data_table = isset($data['table_name']) ? $this->data_table_factory->getTable($data['table_name']) : null;


        $d = $this->datasource->getFieldDataByName($data['db_field_name']);
        $d = array_merge($d, $data);
        $data_conversion = null;

        if(isset($d['conversion_name'])) {
            $data_conversion = new DataConversion($d['conversion_name'], $d['metric_label'], $d['metric_abbrev'],
                                                  $d['to_metric_factor'], $d['metric_rounding_precision'], $d['imperial_label'], $d['imperial_abbrev'], $d['to_imperial_factor'], $d['imperial_rounding_precision']);
        }
        return new DbField($d, $data_table, $data_conversion);

    }
}