<?php


namespace Iv\Deprecated\DependencyInjection;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/*
 * Class Builder
 * Used to build a Dependency Injection Container
 * based on Symfony 2 Dependency Injection and Doctrine Annotations
 *
 * Example Usage:
 *   $builder = new \Iv\System\DependencyInjection\Builder();
 *   builder->enableGlobalImports();
 *   $builder->readAnnotations(ROOT.'/src');
 *
 *   $builder->readConfig(ROOT.'/config/default/config.ini');
 *   $builder->readXml(ROOT.'/config/default/services.xml');
 *   $builder->readYaml(ROOT.'/config/default/services.yml');
 *
 *   $builder->save(ROOT.'/cache/container.php');
 *
 */
class SymfonyBuilder {
	const SERVICE = 'Iv\System\DependencyInjection\Service';
	const INJECT = 'Iv\System\DependencyInjection\Inject';

	private $container;
	private $reader;

	private $xmlLoader;
	private $yamlLoader;

	public function __construct() {
		AnnotationRegistry::registerAutoloadNamespace('Iv\System\DependencyInjection', ROOT.'/src');
		$this->container = new ContainerBuilder();
		$this->reader = new AnnotationReader();

		$this->xmlLoader = new XmlFileLoader( $this->container, new FileLocator( ROOT ));
		$this->yamlLoader = new YamlFileLoader( $this->container, new FileLocator( ROOT ));
	}

	/**
	 * Read Dependency Injection Annotations
	 * @param $dir string Sourcecode Directory
	 */
	public function readAnnotations($dir) {
		$objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
		foreach($objects as $className => $object)
			if( $object->isFile() && preg_match('|(Wlec.*/(\w+))\.php|', str_replace( '\\', '/', $className ), $match )) {
				$reflClass = new \ReflectionClass(str_replace('/', '\\', $match[1]));

				if( $classAnnotation = $this->reader->getClassAnnotation($reflClass, self::SERVICE ))
					$this->addService( $reflClass, $classAnnotation->name ?: $match[2]);
			}
	}

	/** Load Yaml Configuration */
	public function readYaml($file, $required = true) {
		if( $required || is_file( $file ))
			$this->yamlLoader->load($file);
	}

	/** Load XML Configuration */
	public function readXml($file, $required = true) {
		if( $required || is_file( $file ))
			$this->xmlLoader->load($file);
	}

	/**
	 * Stores Service Container in defined Output file
	 * @param $outputFile
	 */
	public function save($outputFile){
		$dumper = new PhpDumper($this->container);
		file_put_contents($outputFile, $dumper->dump(array(
				'class' => 'IvServiceContainer'
		)));
	}

	/**
	 * Add a Service to service Container
	 * @param \ReflectionClass $reflClass
	 * @param $name
	 */
	private function addService( \ReflectionClass $reflClass, $name ) {
		if( $reflClass->isAbstract() || $reflClass->isInterface()) return;
		$service = $this->container->register( $name, $reflClass->getName());

		foreach( $reflClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method ) {
			$methodName = $method->getName();
			if( $methodAnnotation = $this->reader->getMethodAnnotation( $method, self::INJECT )) {
				if( $methodName == '__construct' )
					foreach( $this->parseParameters( $methodAnnotation->data['value'] ) as $parameter )
						$service->addArgument($parameter);
				else
					$service->addMethodCall($methodName, $this->parseParameters( $methodAnnotation->data['value']));
			}
		}
	}

	/**
	 * Converts each parameter:
	 * - starting with @ into an Reference Object
	 * @param $parameters array
	 * @return array
	 */
	private function parseParameters( $parameters ) {
		foreach( $parameters as &$param ) {
			if( $param[0] == '@' )
				$param = new Reference( substr($param, 1));
		}

		return $parameters;
	}

	/**
	 * Adds Inject and Service Annotation to global Import,
	 * So you don't have to put a use statement in every File you want to use them
	 * A dirty Hack: Writing a private property through reflection because
	 * Doctrine does normally not allow this...
	 */
	public function enableGlobalImports() {
		$readerRef = new \ReflectionClass('Doctrine\Common\Annotations\AnnotationReader');
		$property = $readerRef->getProperty('globalImports');
		$property->setAccessible(true);
		$property->setValue(array_merge($property->getValue(), array(
				'service' => self::SERVICE,
				'inject' => self::INJECT,
		)));
	}
}
