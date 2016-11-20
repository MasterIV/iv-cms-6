<?php


namespace Iv\System\Routing\Response;


use Iv\System\Routing\Application;

interface Response {
	/**
	 * @param array $route
	 * @param Application $application
	 * @param mixed $result
	 */
	public function handle($route, $application, $result);
}