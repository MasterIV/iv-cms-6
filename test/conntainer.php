<?php

define( 'ERROR_LEVEL', E_ALL ^ E_NOTICE);

define('ROOT',__DIR__.'/..');
require ROOT.'/vendor/autoload.php';

$container = new \Symfony\Component\DependencyInjection\ContainerBuilder();

$foo = new stdClass();
$foo->test = 'hallo';

$container->set('test', $foo);

class foo {

}

$container->register('foo', 'foo');

$dumper = new \Symfony\Component\DependencyInjection\Dumper\PhpDumper($container);

//echo $dumper->dump(array(
//	'class' => 'IvServiceContainer'
//));

var_export($foo);
