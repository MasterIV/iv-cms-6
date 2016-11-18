<?php


namespace Iv\System\Injection;


class Parameter {
	public $type;
	public $value;

	/**
	 * Parameter constructor.
	 * @param $type
	 * @param $value
	 */
	public function __construct($type, $value) {
		$this->type = $type;
		$this->value = $value;
	}
}