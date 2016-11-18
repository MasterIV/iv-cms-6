<?php


namespace Iv\System\Cache;


class CacheProxy {
	private $subject;
	/** @var Cache */
	private $cache;

	/**
	 * CacheProxy constructor.
	 * @param $subject
	 * @param Cache $cache
	 */
	public function __construct($subject, Cache $cache) {
		$this->subject = $subject;
		$this->cache = $cache;
	}

	function __call($name, $arguments) {
		// TODO: Implement __call() method.
	}

	function __get($name) {
		// TODO: Implement __get() method.
	}

	function __set($name, $value) {
		// TODO: Implement __set() method.
	}
}