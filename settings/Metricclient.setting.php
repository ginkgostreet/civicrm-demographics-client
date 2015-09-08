<?php
return array(
  //Reporting URL
  //Site Name
  //
  'metrics_reporting_url' => array(
    'group_name' => 'CiviCRM Preferences',
    'group' => 'metrics',
    'name' => 'metrics_reporting_url',
    'type' => 'String',
    'default' => '',
    'add' => '4.4',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Metrics Reporting URL',
    'help_text' => 'The url of the metrics server that you want metrics from this site to report to.',
  ),
  'metrics_site_name' => array(
    'group_name' => 'CiviCRM Preferences',
    'group' => 'metrics',
    'name' => 'metrics_site_name',
    'type' => 'String',
    'default' => '',
    'add' => '4.4',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Metrics Site Name',
    'help_text' => 'The name of this site as it will be used in metric reporting at the server.',
  )
);