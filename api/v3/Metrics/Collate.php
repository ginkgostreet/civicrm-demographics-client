<?php

/**
 * Metrics.collate API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_metrics_collate_spec(&$spec) {
}

/**
 * Metrics.collate API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_metrics_collate($params) {

  $data = array();
  CRM_Metricclient_Hook::collateMetrics($data);
  if (!empty($data)) {

    $header = array();
    $header['site_url'] = $_SERVER['SERVER_NAME'];
    $metricSettings = CRM_Core_BAO_Setting::getItem("metrics");
    $header['site_name'] = $metricSettings['metrics_site_name'];

    $header['data'] = $data;

    $curl = curl_init($metricSettings['metrics_reporting_url']);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array("json" => json_encode($header)));
    $response = curl_exec($curl);


    return civicrm_api3_create_success(count($data), $params, 'Metrics', 'collate');
  }

  return civicrm_api3_create_success(0, $params, 'Metrics', 'collate');
}

