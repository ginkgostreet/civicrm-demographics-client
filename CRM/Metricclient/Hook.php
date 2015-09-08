<?php

class CRM_Metricclient_Hook
{

  static $_nullObject = NULL;

  static function collateMetrics(&$data) {
    return CRM_Utils_Hook::singleton()->invoke(1, $data, self::$_nullObject,
      self::$_nullObject, self::$_nullObject, self::$_nullObject, self::$_nullObject,
      'metrics_collate'
    );
  }
}

?>