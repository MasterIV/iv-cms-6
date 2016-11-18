<?php


namespace Iv\System\Injection;


class Definition {
	public $name;
	public $class;
	public $constructor = [];
	public $methods = [];

	/**
	 * Definition constructor.
	 * @param $name
	 */
	public function __construct($name, $class) {
		$this->name = $name;
		$this->class = $class;
	}
}