<?php

define('ROOT',__DIR__.'/..');
require ROOT.'/vendor/autoload.php';

$builder = new \Iv\System\DependencyInjection\Builder();
$builder->enableGlobalImports();
$builder->readAnnotations(ROOT.'/src');

//$builder->readXml(ROOT.'/cfg/container.xml');
//$builder->readYaml(ROOT.'/cfg/container.yml');

$builder->save(ROOT.'/cache/container.php');
