<?php


namespace Iv\System\Configuration;


use Doctrine\Common\Annotations\AnnotationReader;

class Reader {
	/** @var AnnotationReader */
	private $reader;
	/** @var Processor[] */
	private $processors = [];

	public function __construct() {
		$this->reader = new AnnotationReader();
		$this->enableGlobalImports();

		foreach($this->findClasses(ROOT.'/src/System/Configuration/Processor') as $name)
			$this->processors[] = new $name();
	}

	/**
	 * Adds Inject and Service Annotation to global Import,
	 * So you don't have to put a use statement in every File you want to use them
	 * A dirty Hack: Writing a private property through reflection because
	 * Doctrine does normally not allow this...
	 */
	private function enableGlobalImports() {
		$readerRef = new \ReflectionClass('Doctrine\Common\Annotations\AnnotationReader');
		$property = $readerRef->getProperty('globalImports');
		$property->setAccessible(true);

		$classes = [];
		foreach($this->findClasses(ROOT.'/src/System/Annotation') as $name) {
			$key = strtolower(substr($name, strrpos($name, '\\') + 1));
			$classes[$key] = substr($name, 1);
			new $name(); // force autoloading for the class
		}

		$property->setValue(array_merge($property->getValue(), $classes));
	}

	/**
	 * Find classes in the given path
	 * The path should be inside the src folder
	 * @param $dir
	 * @return string[] array
	 */
	private function findClasses($dir) {
		$replaceDir = substr($dir, 0, strpos($dir, 'src')+3);
		$objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
		$classes = [];

		foreach($objects as $name => $object)
			if( $object->isFile() && $object->getExtension() == 'php')
				$classes[] = str_replace([ $replaceDir, '/', '.php'], ['\\Iv', '\\', ''], $object->getPathname());

		return $classes;
	}

	/**
	 * Read Dependency Injection Annotations
	 * @param $dir string Sourcecode Directory
	 */
	public function readAnnotations($dir) {
		foreach($this->findClasses($dir) as $name) {
			$class = new \ReflectionClass($name);

			$classAnnotation = $this->reader->getClassAnnotations($class);
			$this->process($class, $classAnnotation);
		}

		foreach($this->processors as $processor)
			$processor->complete();
	}

	/**
	 * @param \ReflectionClass $class
	 * @param $classAnnotation
	 */
	private function process( $class, $classAnnotation ) {
		foreach($classAnnotation as $annotation)
			foreach($this->processors as $p)
				$p->handleClass( $class, $annotation );

		foreach( $class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method ) {
			$methodName = $method->getName();
			if( $methodAnnotations = $this->reader->getMethodAnnotations( $method )) {
				foreach($methodAnnotations as $annotation)
					if( $methodName == '__construct' )
						foreach($this->processors as $p)
							$p->handleConstructor( $class, $annotation );
					else
						foreach($this->processors as $p)
							$p->handleMethod( $class, $method, $annotation );
			}
		}


	}
}