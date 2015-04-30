<?php

require 'inc/common.php';

$path = empty( $_GET['path'] ) ? [] : explode( '/', $_GET['path'] );
$application = ucfirst( array_shift( $path ) ?: 'admin' );

var_dump( $application );
