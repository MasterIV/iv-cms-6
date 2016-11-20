<?php


namespace Iv\Admin\Module\Welcome;
use Iv\System\Annotation\Module;
use Iv\System\Annotation\Route;

/** @Module(application="admin", category="Allgemein", caption="Startseite", icon="none.png") */
class WelcomeController {

	/** @Route() */
	public function actionIndex() {
		return ['content' => 'hallo welt'.print_r($_GET,true)];
	}
}