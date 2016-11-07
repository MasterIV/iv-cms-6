<?php

namespace Iv\System\DependencyInjection;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Component
{
	/** @var string */
	public $name;
}