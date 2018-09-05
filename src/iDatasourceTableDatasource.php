<?php
namespace agsource\datasource;

interface iDatasourceTableDatasource
{
    function getColumns($db_name, $table_name);
    function getColumnNamesFromMeta($db_name, $schema_name, $table_name);
    function getTableMeta($full_table_name);
}