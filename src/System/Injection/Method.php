<?php


namespace Iv\System\Injection;


class Method {
	public $name;
	public $arguments;

	/**
	 * Method constructor.
	 * @param $name
	 * @param $arguments
	 */
	public function __construct($name, $arguments) {
		$this->name = $name;
		$this->arguments = $arguments;
	}


}