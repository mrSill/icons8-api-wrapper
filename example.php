<?php

use mrSill\Icons8\Icons8Wrapper;

require dirname(__FILE__) . '/vendor/autoload.php';

$service = new Icons8Wrapper();

print_r($service->getIconById(1));
print_r($service->getIconByIDs([2,3,4]));
print_r($service->getAllIcons());
print_r($service->searchIcons('home'));
print_r($service->getNewestIcons());
print_r($service->getSimilarIcons(1));
print_r($service->getTotalIcons());
print_r($service->getInfoList());
print_r($service->getCategories());
print_r($service->getCategory('Weather'));
print_r($service->suggest('home'));