<?php


namespace Iv\System\Routing;


interface Application {
	/**
	 * @param array $route
	 * @return \Twig_Template
	 */
	public function getTemplate($route);
	public function isAccessible($route);
}