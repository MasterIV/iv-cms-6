<?php

namespace Iv\System\DependencyInjection;

class Collection
{
	private $items;

	/**
	 * Collection constructor.
	 * @param $item
	 */
	public function __construct($item)
	{
		$this->items = array($item);
	}

	public function add($item) {
		$this->items[] = $item;
	}

	public function get() {
		return $this->items;
	}
}