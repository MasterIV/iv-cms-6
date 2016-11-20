<?php


namespace Iv\System\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Module extends Controller {
	/** @var string */
	public $icon;
	/** @var string */
	public $caption;
	/** @var string */
	public $category;
}