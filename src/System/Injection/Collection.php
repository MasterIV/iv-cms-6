<?php


namespace Iv\System\Injection;


class Collection {
	public $name;
	public $elements = [];

	/**
	 * Collection constructor.
	 * @param $name
	 */
	public function __construct($name) {
		$this->name = $name;
	}

	public function add($definition) {
		$this->elements[] = $definition;
	}
}