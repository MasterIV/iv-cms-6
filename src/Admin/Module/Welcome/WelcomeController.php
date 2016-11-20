<?php


namespace Iv\Admin\Module\Welcome;
use Iv\System\Annotation\Controller;
use Iv\System\Annotation\Route;

/** @Controller(application="admin") */
class WelcomeController {

	/** @Route() */
	public function actionIndex() {
		return ['content' => 'hallo welt'];
	}
}