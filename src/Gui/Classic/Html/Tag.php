<?php

namespace Iv\Gui\Classic\Html;

class Tag extends Standalone {
	protected $children = array();

	/**
	 * Static constructor for method chaining
	 * @param string $tagName
	 * @return Tag
	 */
	public static function create($tagName) {
		return new self($tagName);
	}

	/**
	 * Converts the object into html string
	 * @return string
	 */
	function __toString() {
		return parent::__toString() . implode($this->children) . "</{$this->tagName}>";
	}

	/**
	 * Setter for attributes
	 * Overwritten vor IDE type hinting
	 * @param string $name
	 * @param string $value
	 * @return Tag
	 */
	public function attr($name, $value) {
		parent::attr($name, $value);
		return $this;
	}

	/**
	 * Add a child node
	 * @param mixed $child
	 * @return Tag
	 */
	public function append($child) {
		$this->children[] = $child;
		return $this;
	}
}