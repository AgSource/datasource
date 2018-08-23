<?php
namespace agsource\datasource;

interface iDatasourceTableDatasource
{
    function getColumns($db_name, $table_name);
}