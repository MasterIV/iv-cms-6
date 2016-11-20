<?php


namespace Iv\System\Annotation;

use Iv\System\Routing\OutputType;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Route {
	/** @var string */
	public $route;
	/** @var string */
	public $produces = OutputType::HTML;
}