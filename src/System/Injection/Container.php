<?php


namespace Iv\System\Injection;


class Container {
	private $methods = [];
	private $services = [];
	private $parameters = [];

	/**
	 * Container constructor.
	 * @param array $methods
	 * @param $parameters
	 */
	public function __construct($methods, $parameters) {
		$this->methods = $methods;
		$this->parameters = $parameters;
		$this->services['Container'] = $this;
	}

	public function create($service) {
		if(empty($this->methods[$service]))
			throw new \Exception('invalid service: '.$service);
		return call_user_func([$this, $this->methods[$service]]);
	}

	protected function loadCache( $file ) {
		$fileName = ROOT.'/cache/'.$file.'.php';
		return is_file($fileName) ? include $fileName : null;
	}

	public function get($service) {
		if(empty($this->services[$service]))
			$this->services[$service] = $this->create($service);
		return $this->services[$service];
	}

	public function optional($service) {
		if(empty($this->methods[$service]) && empty($this->services[$service]))
			return null;
		return $this->get($service);
	}

	public function setParameter($key, $value) {
		$this->parameters[$key] = $value;
	}

	public function getParameter($key) {
		return $this->parameters[$key];
	}
}