<?php


namespace Iv\System\Configuration\Processor;


use Iv\System\Annotation\Application;
use Iv\System\Annotation\Controller;
use Iv\System\Annotation\Route;
use Iv\System\Configuration\Processor;
use Iv\System\Routing\Dispatcher;
use Iv\System\Routing\Router;

class RoutingProcessor implements Processor  {
	const OUTPUT_FILE = ROOT.'/cache/routes.php';

	/** @var Application[] */
	private $applications = [];
	/** @var Controller[] */
	private $controllers = [];

	/**
	 * @param \ReflectionClass $class
	 * @param $annotation
	 */
	public function handleClass($class, $annotation) {
		if($annotation instanceof Controller) {
			if(empty($annotation->name))
				$annotation->name = $class->getShortName();
			$this->controllers[$class->getName()] = $annotation;
		}

		if($annotation instanceof Application) {
			if(empty($annotation->route))
				$annotation->route = $annotation->name;
			$this->applications[$annotation->name] = $annotation;
		}
	}

	public function handleConstructor($class, $annotation) {}

	/**
	 * @param \ReflectionClass $class
	 * @param \ReflectionMethod $method
	 * @param $annotation
	 */
	public function handleMethod($class, $method, $annotation) {
		if(!$annotation instanceof Route) return;
		$this->controllers[$class->getName()]->add( $annotation->value, $method);
	}

	private function init() {
		return [
			Router::CHILDREN => [],
			Router::MATCHER => [],
		];
	}

	public function complete() {
		$routes = [];
		$tree = $this->init();

		foreach($this->controllers as $controller)
			foreach($controller->getChildren() as $route) {
				$path = $this->applications[$controller->application]->route . '/'
					  . $controller->route . '/'
					  . $route['route'];

				unset($route['route']);
				$routes[$path] = $route;
			}

		foreach($routes as $path => $route) {
			$steps = explode('/', $path);
			$pointer =& $tree;

			while(count($steps)) {
				$step = array_shift($steps);
				if(empty($step)) continue;
				$type = $step[0] == '$' ? Router::MATCHER : Router::CHILDREN;

				if(empty($pointer[$type][$step]))
					$pointer[$type][$step] = $this->init();
				$pointer =& $pointer[$type][$step];
			}

			$pointer[Router::ROUTE] = $route;
		}

		echo "\tWrtiting Routes...\n";
		file_put_contents(self::OUTPUT_FILE, '<?php return '.preg_replace(
				['/\s*array \(/', '/\)/s', '/\[\s*\]/s', '/  /'],
				[' [', ']', '[]', "\t"],
				var_export($tree, true)
			).";\n\n");
	}
}