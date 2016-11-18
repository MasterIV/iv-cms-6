<?php

define('ROOT',__DIR__.'/..');
require ROOT.'/vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;


//AnnotationRegistry::registerAutoloadNamespace('Iv\System\DependencyInjection', ROOT.'/src');



/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Suppe {
	/** @var mixed */
	public $name;
}

/**
 * Class Subject
 * @Suppe({"foo", "bar"})
 */
class Subject {

}

$reader = new AnnotationReader();

var_dump($reader->getClassAnnotations(new ReflectionClass("Subject")));


