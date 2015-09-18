# civicrm-metrics-client

##API Functions:
**api.metrics.collate**
This extension creates a new API method that can be schedule as a job to periodically report metrics to a defined server

##Hooks: 
This extension implementes a new hook
hook_metrics_collate(&$data)

$data is an array and all new metrics should be pushed into this array.
Data entries should contain two keys, 'type' and 'data'.
eg: 
```php
$data[] = array("type" => "YouCustomMetric", "data" => "SomethingCool");
```

The data key can also be an array
eg: 
```php
$data[] = array("type" => "AnotherCustomMetric", "data" => array("cows" => "We have 25 cows", "chickens" => "We have 57 chickens", "total" => 82));
```

Data will be json stringified and stored in the data field within the metrics server.
eg: 
```
{"cows": "We have 25 cows", "chickens": "We have 57 chickens", "total": 82}
```

##Settings
You can modify settings at civicrm/metrics/settings


##Default Metrics
This module comes packaged with 5 metrics

- Total Number of Contacts
- Contacts broken down by Gender
- Percentage of contacts with an associated phone number
- Percentage of contacts with an associated email address
- Percentage of contacts with an associated address
