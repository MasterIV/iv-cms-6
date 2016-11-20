<?php


namespace Iv\Cms;
use Iv\System\Annotation\App;
use Iv\System\Routing\Application;

/** @App(name = "cms", route ="page") */
class CmsApplication  implements Application {

	public function getTemplate($route) {
		// TODO: Implement getTemplate() method.
	}

	public function isAccessible($route) {
		return true;
	}
}