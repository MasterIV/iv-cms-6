<?php

define('ROOT',__DIR__.'/..');
require ROOT.'/vendor/autoload.php';
require ROOT.'/inc/functions.php';

$builder = new \Iv\System\Configuration\Reader();
$builder->readAnnotations(ROOT.'/src');

//$builder->readXml(ROOT.'/cfg/container.xml');
//$builder->readYaml(ROOT.'/cfg/container.yml');

//$builder->save(ROOT.'/cache/container.php');
