<?php
namespace agsource\datasource;

/**
 * Name:  iDataTableFactory
 *
 * Author: ctranel
 *
 * Created:  2017-08-29
 *
 * Description:  Interface for datasource tables.
 *
 */
interface iDataTableFactory {
    function __construct(iDatasourceTableDatasource $db_table_model);
    function getTable($name);
}
