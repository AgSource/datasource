<?php
namespace agsource\datasource;

/**
 * Name:  DbField
 *
 * Author: ctranel
 *
 * Created:  02-10-2015
 *
 * Description:  Interface for datasource fields.
 *
 */
interface iDataField {
	function __construct($field_data, iDataTable $db_table, iDataConversion $data_conversion);
	
	function dbFieldName();
    function dbTableName();
    function dbTable();
	function dataType();
	function maxLength();
    function isKey();
    function isLookup();
    function isSerialized();
    function label();
    function toArray();
    function hasMetricConversion();
    function conversionToMetricFactor();
}
