<?php

namespace Iv\Cms\Content;

/**
 * Represent a layout element, usually a box
 * The actual behaviour depends on the type of the panel
 */
class Panel
{
	private $id;
	private $name;
	private $tile;
	private $type;
	private $prio;
	private $vars;
}