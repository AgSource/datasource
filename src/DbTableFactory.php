<?php
namespace agsource\datasource;

require_once('iDataTableFactory.php');
require_once('DbTable.php');

class DbTableFactory implements iDataTableFactory
{
    /**
     * db_table_model
     *
     * @var iDatasourceTableDatasource
     **/
    protected $db_table_model;

    public function __construct(iDatasourceTableDatasource $db_table_model){
        $this->db_table_model = $db_table_model;
    }

    public function getTable($name){
        if(!isset($name) || empty($name)){
            return;
        }

        $table_data = $this->db_table_model->getTableMeta($name);

        $ret = new DbTable($name, $table_data, $this->db_table_model);
        return $ret;
    }
}