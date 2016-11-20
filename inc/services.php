<?php

use Iv\System\Injection\Definition;
use Iv\System\Configuration\Processor\InjectionProcessor;

function defineService($name, $class, $parameters) {
	$service = new Definition($name, $class);
	$service->constructor = InjectionProcessor::readDependencies($parameters);
	return $service;
}

return [];
