<?php

use mrSill\Icons8\Icons8Wrapper;

require dirname(__FILE__) . '/vendor/autoload.php';

$service = new Icons8Wrapper();

$result = $service->getIconById(941);
print_r($result);
echo PHP_EOL;

$result = $service->getAllIcons(100);
print_r($result);
echo PHP_EOL;