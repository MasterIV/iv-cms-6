<?php

namespace Iv\Gui\Classic\Html;

class Standalone {
	protected $attributes = array();
	protected $tagName;

	public function __construct($tagname) {
		$this->tagName = $tagname;
	}

	/**
	 * Static constructor for method chaining
	 * @param string $tagName
	 * @return Standalone
	 */
	public static function create($tagName) {
		return new self($tagName);
	}

	/**
	 * Generic setter for attributes
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		$this->attr($name, $value);
	}

	/**
	 * Generic getter for attributes
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this->attributes[$name];
	}

	/**
	 * Setter for attributes
	 * @param string $name
	 * @param string $value
	 * @return Standalone
	 */
	public function attr($name, $value) {
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * Converts the object into html string
	 * @return string
	 */
	public function __toString() {
		$result = '<' . $this->tagName;
		foreach ($this->attributes as $name => $value)
			$result .= ' ' . $name . '="' . htmlspecialchars($value) . '"';
		return $result . '>';
	}
}