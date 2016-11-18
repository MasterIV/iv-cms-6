<?php

require 'inc/common.php';

/** @var \Iv\System\Routing\Dispatcher $dispatcher */
$dispatcher = $container->get('Dispatcher');
$dispatcher->route( $_GET['path'] );
