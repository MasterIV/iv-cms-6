<?php

namespace Iv\System\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class App extends Component {
	/** @var string */
	public $route;
}