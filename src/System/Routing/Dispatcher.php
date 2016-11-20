<?php


namespace Iv\System\Routing;

use Iv\System\Annotation\Inject;
use Iv\System\Annotation\Service;
use Iv\System\Injection\Container;
use Iv\System\Routing\Response\Response;

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

	/**
	 * Handles the given path
	 * @param string $path
	 */
	public function route($path) {
		$route = $this->router->route($path);

		if(empty($route))
			$route = [
				'controller' => 'ErrorController',
				'method' => 'notFound',
				'produces' => OutputType::HTML
			];

		/** @var Application $application */
		$application = $this->container->optional($route['application']);
		if(!empty($application) && !$application->isAccessible($route))
			$route = [
				'controller' => 'ErrorController',
				'method' => 'forbidden',
				'produces' => OutputType::HTML
			];

		/** @var Response $response */
		$response = $this->container->create($route['produces'].'Response');

		// Environment that can be accessed through controller parameter
		$route['$path'] = $path;
		$route['$response'] = $response;

		$response->handle($route, $application, $this->processRoute($route));
	}

	/**
	 * @param $route
	 * @return mixed
	 */
	private function processRoute($route) {
		$controller = $this->container->get($route['controller']);
		$method = new \ReflectionMethod($controller, $route['method']);
		$args = [];

		foreach ($method->getParameters() as $p)
			$args[] = $route['$' . $p->getName()];

		return $method->invokeArgs($controller, $args);
	}

}