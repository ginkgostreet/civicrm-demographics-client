<?php

require_once 'metricclient.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function metricclient_civicrm_config(&$config) {
  _metricclient_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function metricclient_civicrm_xmlMenu(&$files) {
  _metricclient_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function metricclient_civicrm_install() {
  _metricclient_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function metricclient_civicrm_uninstall() {
  _metricclient_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function metricclient_civicrm_enable() {
  _metricclient_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function metricclient_civicrm_disable() {
  _metricclient_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function metricclient_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _metricclient_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function metricclient_civicrm_managed(&$entities) {
  _metricclient_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function metricclient_civicrm_caseTypes(&$caseTypes) {
  _metricclient_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function metricclient_civicrm_angularModules(&$angularModules) {
  _metricclient_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function metricclient_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _metricclient_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function metricclient_civicrm_preProcess($formName, &$form) {

}

 */

/**
 * implements hook metrics_collate
 *
 * This function is used for generating some basic metrics
 * That should be useful to most and can be used as an example
 *
 * @param $data
 */
function metricclient_metrics_collate(&$data) {


  /********[ Total Number of Contacts ] ********/
  $sql = "SELECT COUNT(*) FROM `civicrm_contact` WHERE `is_deleted` = 0";
  $total =& CRM_Core_DAO::singleValueQuery($sql);

  $data[] = array("type" => "total_contacts", "data" => $total);


  /********[ Contact Totals by Gender ] ********/
  $sql = "SELECT COUNT(*) as `total`, `gender_id` FROM `civicrm_contact` GROUP BY `gender_id`";
  $gender = CRM_Core_PseudoConstant::get('CRM_Contact_DAO_Contact', 'gender_id', array('localize' => TRUE));
  $dao =& CRM_Core_DAO::executeQuery($sql);
  $total = array();
  while($dao->fetch()) {
    if ($dao->gender_id == null) {
      $total['none'] = $dao->total;
    } else {
      $total[ $gender[ $dao->gender_id ] ] = $dao->total;
    }
  }
  $data[] = array("type" => "gender", "data" => $total);


  /********[ Contacts with Phone ] ********/
  $sql = "SELECT COUNT(*) FROM `civicrm_contact` WHERE id IN (SELECT contact_id FROM civicrm_phone WHERE `phone` IS NOT NULL) AND `is_deleted` = 0";
  $total =& CRM_Core_DAO::singleValueQuery($sql);
  $data[] = array("type" => "contacts_with_phone", "data" => $total);

  /********[ Contacts with email ] ********/
  $sql = "SELECT COUNT(*) FROM `civicrm_contact` WHERE id IN (SELECT contact_id FROM civicrm_email WHERE `email` IS NOT NULL) AND `is_deleted` = 0";
  $total =& CRM_Core_DAO::singleValueQuery($sql);
  $data[] = array("type" => "contacts_with_email", "data" => $total);

  /********[ Contacts with address ] ********/
  $sql = "SELECT COUNT(*) FROM `civicrm_contact` WHERE id IN (SELECT contact_id FROM civicrm_address WHERE `street_address` IS NOT NULL) AND `is_deleted` = 0";
  $total =& CRM_Core_DAO::singleValueQuery($sql);
  $data[] = array("type" => "contacts_with_address", "data" => $total);

}

/**
 * Add navigation for Metric Settings under "Administer" menu
 *
 * @param $params associated array of navigation menus
 *
 */
function metricclient_civicrm_navigationMenu( &$params ) {
  // get the id of Administer Menu
  $administerMenuId = CRM_Core_DAO::getFieldValue('CRM_Core_BAO_Navigation', 'Administer', 'id', 'name');

  // skip adding menu if there is no administer menu
  if ($administerMenuId) {
    // get the maximum key under adminster menu
    $maxKey = max( array_keys($params[$administerMenuId]['child']));
    $params[$administerMenuId]['child'][$maxKey+1] =  array (
      'attributes' => array (
        'label'      => 'Metrics Settings',
        'name'       => 'MetricClientSettings',
        'url'        => 'civicrm/metrics/settings?reset=1',
        'permission' => 'administer CiviCRM',
        'operator'   => NULL,
        'separator'  => false,
        'parentID'   => $administerMenuId,
        'navID'      => $maxKey+1,
        'active'     => 1
      )
    );
  }
}
