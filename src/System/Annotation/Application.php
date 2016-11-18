<?php

namespace Iv\System\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Application extends Component {
	/** @var string */
	public $route;
}