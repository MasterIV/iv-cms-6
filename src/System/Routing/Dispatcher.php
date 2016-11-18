<?php


namespace Iv\System\Routing;

use Iv\System\Annotation\Inject;
use Iv\System\Annotation\Service;
use Iv\System\Injection\Container;

/** @Service() */
class Dispatcher {
	/** @var Router */
	private $router;
	/** @var Container */
	private $container;

	/**
	 * Dispatcher constructor.
	 * @param Router $router
	 * @param Container $container
	 * @Inject({"@Router", "@Container"})
	 */
	public function __construct(Router $router, Container $container) {
		$this->router = $router;
		$this->container = $container;
	}

	public function route($path) {
		$route = $this->router->route($path);

		var_dump($route);
		if(empty($route)) return;

		$controller = $this->container->get($route['controller']);
		if($route['args']) {
			$refl = new \ReflectionMethod($controller, $route['method']);
			$args = [];

			foreach($refl->getParameters() as $p)
				$args[] = $route['$'.$p->getName()];

			$result = $refl->invokeArgs($controller, $args);
		} else {
			$result = call_user_func([$controller, $route['method']]);
		}

		echo "<br>".$result;
	}

}