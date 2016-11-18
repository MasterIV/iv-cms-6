<?php

namespace Iv\System\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Component
{
	/** @var string */
	public $name;
	/** @var string */
	public $collection;
}