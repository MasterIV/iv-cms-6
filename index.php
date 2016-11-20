<?php

require 'inc/common.php';
define('ROOT_DIR', dirname($_SERVER['SCRIPT_NAME']));

/** @var \Iv\System\Routing\Dispatcher $dispatcher */
$dispatcher = $container->get('Dispatcher');
$dispatcher->route( $_GET['path'] );
