<?php

namespace Iv\System\DependencyInjection;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Inject {
	public function __construct($data) {
		$this->data = $data;
	}
}
