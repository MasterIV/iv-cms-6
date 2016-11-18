<?php


namespace Iv\System\Routing;

use Iv\System\Annotation\Inject;
use Iv\System\Annotation\Service;

/** @Service() */
class Router {
	const CHILDREN = 'c';
	const ROUTE = 'r';
	const MATCHER = 'm';

	private $routes;

	/**
	 * Dispatcher constructor.
	 * @param $routes
	 * @Inject({"~routes"})
	 */
	public function __construct($routes) {
		$this->routes = $routes;
	}

	private function match($pointer, $steps) {
		while(count($steps)) {
			$step = array_shift($steps);
			if(empty($step)) continue;

			if(isset($pointer[self::CHILDREN][$step])) {
				$pointer = $pointer[self::CHILDREN][$step];
				continue;
			}

			foreach($pointer[self::MATCHER] as $param => $matcher)
				if($route = $this->match($matcher, $steps)) {
					$route[$param] = $step;
					$route['args'] = true;
					return $route;
				}

			return false;
		}

		if( empty( $pointer[self::ROUTE] )) {
			return false;
		} else {
			$route = $pointer[self::ROUTE];
			$route['args'] = false;
			return $route;
		}
	}

	public function route($path) {
		return $this->match($this->routes,  explode('/', $path));
	}
}