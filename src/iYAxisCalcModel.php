<?php
namespace agsource\datasource;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* -----------------------------------------------------------------
 *	CLASS comments
  *  @author: ctranel
 *  @date: 2017/10/26
 *
 * -----------------------------------------------------------------
 */

interface iYAxisCalcModel {
    public function adjustYAxes($input);
}