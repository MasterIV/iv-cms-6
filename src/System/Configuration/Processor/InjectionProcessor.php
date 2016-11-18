<?php

namespace Iv\System\Configuration\Processor;

use Iv\System\Annotation\Component;
use Iv\System\Annotation\Inject;
use Iv\System\Configuration\Processor;
use Iv\System\Injection\Collection;
use Iv\System\Injection\Definition;
use Iv\System\Injection\Method;
use Iv\System\Injection\Parameter;

/**
 * Handles the Component and Injection Annotations
 * and creates the service container from them.
 * @package Iv\System\Configuration\Processor
 */
class InjectionProcessor implements Processor  {
	/** @var Definition[] */
	private $definitions = [];
	/** @var Collection[] */
	private $collections = [];

	const TEMPLATE_DIR = ROOT.'/tpl/system/injection';
	const OUTPUT_FILE = ROOT.'/cache/container.php';
	
	/**
	 * @param \ReflectionClass $class
	 * @param $annotation
	 */
	public function handleClass($class, $annotation) {
		if(!$annotation instanceof Component) return;

		$name = $annotation->name ?: $class->getShortName();
		$definition = new Definition($name, $class->getName());
		$this->definitions[$class->getName()] = $definition;

		if(empty($annotation->collection)) return;
		if(empty($this->collections[$annotation->collection]))
			$this->collections[$annotation->collection] = new Collection($annotation->collection);
		$this->collections[$annotation->collection]->add( $definition );
	}

	/**
	 * Create a list of Parameter Objects from dependency strings
	 * The type of injection depends on the first character:
	 *  '@' => inject service or collection
	 *  '#' => inject a parameter
	 *  '~' => inject cache file
	 * @param string[] $dependencies
	 * @return \Iv\System\Injection\Parameter[]
	 * @throws \Exception
	 */
	private function readDependencies($dependencies) {
		$params = [];

		foreach($dependencies as $d)
			if($d[0] == '@')
				$params[] = new Parameter('service', substr($d, 1));
			elseif($d[0] == '#')
				$params[] = new Parameter('parameter', substr($d, 1));
			elseif($d[0] == '~')
				$params[] = new Parameter('cache', substr($d, 1));
			else
				throw new \Exception('Type of Parameter unknown: '.$d);

		return $params;
	}

	/**
	 * Parses Inject annotations on the constructor.
	 * @param \ReflectionClass $class
	 * @param $annotation
	 */
	public function handleConstructor($class, $annotation) {
		if(!$annotation instanceof Inject) return;

		$this->definitions[$class->getName()]->constructor
			= $this->readDependencies($annotation->dependencies);
	}

	/**
	 * Parses Inject annotations on methods.
	 * @param \ReflectionClass $class
	 * @param \ReflectionMethod $method
	 * @param $annotation
	 */
	public function handleMethod($class, $method, $annotation) {
		if(!$annotation instanceof Inject) return;
		$this->definitions[$class->getName()]->methods[] = new Method(
			$method->getName(), $this->readDependencies($annotation->dependencies));
	}

	/**
	 * Create the container.php inside the cache directory
	 */
	public function complete() {
		$loader = new \Twig_Loader_Filesystem(self::TEMPLATE_DIR);
		$twig = new \Twig_Environment($loader, []);
		$twig->addFilter(new \Twig_SimpleFilter('ucfirst', 'ucfirst'));
		$template = $twig->loadTemplate('container.twig');

		echo "\tCreating Container...\n";
		file_put_contents(self::OUTPUT_FILE, $template->render([
			'definitions' => $this->definitions,
			'collections' => $this->collections
		]));
	}
}