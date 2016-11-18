<?php


namespace Iv\System\Injection;


use Symfony\Component\Config\Definition\Exception\Exception;

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

	protected function loadCache( $file ) {
		$fileName = ROOT.'/cache/'.$file.'.php';
		return is_file($fileName) ? include $fileName : null;
	}

	public function get($service) {
		if(empty($this->services[$service]))
			$this->instantiate($service);
		return $this->services[$service];
	}

	public function setParameter($key, $value) {
		$this->parameters[$key] = $value;
	}

	public function getParameter($key) {
		return $this->parameters[$key];
	}

	private function instantiate($service) {
		if(empty($this->methods[$service]))
			throw new Exception('invalid service: '.$service);
		$this->services[$service] = call_user_func([$this, $this->methods[$service]]);
	}
}