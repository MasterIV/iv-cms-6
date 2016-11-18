<?php

namespace Iv\System\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Inject {
	/** @var array */
	public $dependencies;
}
