<?php


namespace Iv\System\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Route {
	/** @var string */
	public $value;
}