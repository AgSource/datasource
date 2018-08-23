<?php
namespace agsource\datasource;

interface iDatasourceFieldDatasource
{
    function getFieldData($id);
    function getFieldDataByName($name);
}