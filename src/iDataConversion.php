<?php
namespace agsource\datasource;

interface iDataConversion
{
    function __construct($name, $metric_label, $metric_abbrev, $to_metric_factor, $metric_rounding_precision, $imperial_label, $imperial_abbrev, $to_imperial_factor, $imperial_rounding_precision);
    function metricFactor();
    function metricRoundingPrecision();
}