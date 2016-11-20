<?php


namespace Iv\System\Controller;

use Iv\System\Annotation\Controller;
use Iv\System\Annotation\Route;
use Iv\System\Routing\OutputType;

/** @Controller() */
class IndexController {
	/** @Route(produces=OutputType::REDIRECT) */
	public function actionIndex() {
		return '/Source/iv-cms-6/page/55';
	}
}