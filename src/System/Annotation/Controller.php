<?php

namespace Iv\System\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Controller extends Component {
	/** @var string */
	public $application;
	/** @var string */
	public $route;

	/** @var array */
	private $children = [];

	public static function __set_state($state) {
		$result = new self();
		foreach ($state as $k => $v)
			$result->{$k} = $v;
		return $result;
	}

	public function add(Route $route, \ReflectionMethod $method) {
		$this->children[] = [
			'route' => $route->route,
			'application' => $this->application,
			'controller' => $this->name,
			'method' => $method->getName(),
			'produces' => $route->produces
		];
	}

	public function getChildren() {
		return $this->children;
	}
}