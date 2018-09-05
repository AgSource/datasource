<?php
namespace agsource\datasource;

/**
 * Name:  iDataTable
 *
 * Author: ctranel
 *
 * Created:  02-10-2015
 *
 * Description:  Interface for datasource tables.
 *
 */
interface iDataTable {
    function __construct($full_table_name, $table_meta, $db_table_model);
    function field_exists($col_name);
    function columnNames();
    function tableName($full_table_name = null);
}
