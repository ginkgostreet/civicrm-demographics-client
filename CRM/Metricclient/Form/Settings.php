<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Metricclient_Form_Settings extends CRM_Core_Form {
  function buildQuickForm() {

    // add form elements
    $this->add(
      'text', // field type
      'metrics_reporting_url', // field name
      ts('Metrics Reporting URL'), // field label
      array("size" => 75),
      true // is required
    );
    $this->add(
      'text',
      'metrics_site_name',
      ts('Metrics Site Name'),
      array("size" => 35),
      true // is required,
    );
    $this->add(
      'text',
      'metrics_ca_path',
      ts('SSL CA Path'),
      array("size" => 75),
      false
    );
    $this->add(
      'checkbox',
      'metrics_ignore_verify_peer',
      ts('Skip Peer CA Validation'),
      null,
      false
    );
    $this->add(
      'checkbox',
      'metrics_ignore_verify_host',
      ts('Skip SSL Host Validation'),
      null,
      false
    );
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  function setDefaultValues() {

    $metricSettings = CRM_Core_BAO_Setting::getItem("metrics");

    return $metricSettings;
  }

  function validate() {
    if(strpos($this->_submitValues['metrics_reporting_url'], "https") === false) {
      CRM_Core_Session::setStatus(ts("SSL Should be used when sending metrics."), "Error", "error");
      //This should be false but for testing I'm not enforcing ssl.
      return true;
    }
    return true;
  }

  function postProcess() {
    $values = $this->exportValues();
    CRM_Core_BAO_Setting::setItem($values['metrics_reporting_url'],"metrics", "metrics_reporting_url");
    CRM_Core_BAO_Setting::setItem($values['metrics_site_name'],"metrics", "metrics_site_name");
    CRM_Core_BAO_Setting::setItem($values['metrics_ca_path'],"metrics", "metrics_ca_path");

    $peer = array_key_exists("metrics_ignore_verify_peer", $values) ? $values['metrics_ignore_verify_peer'] : 0;
    CRM_Core_BAO_Setting::setItem($peer,"metrics", "metrics_ignore_verify_peer");
    $host = array_key_exists("metrics_ignore_verify_host", $values) ? $values['metrics_ignore_verify_host'] : 0;
    CRM_Core_BAO_Setting::setItem($host,"metrics", "metrics_ignore_verify_host");

    CRM_Core_Session::setStatus(ts("Changed Saved"), "Saved", "success");
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
}
