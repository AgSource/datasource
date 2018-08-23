<?php
namespace agsource\datasource;

/**
 * Name:  iDataFieldFactory
 *
 * Author: ctranel
 *
 * Created:  02-10-2015
 *
 * Description:  Interface for datasource tables.
 *
 */
interface iDataFieldFactory {
    public function getFromData($data);
    public function get($id);
    public function getGeneralObjectFromData($data);
}
