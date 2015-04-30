<?php

namespace Iv\System\DependencyInjection;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Service {
	public function __construct($data) {
		$this->data = $data;
	}
}
