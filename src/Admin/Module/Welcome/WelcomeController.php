<?php


namespace Iv\Admin\Module\Welcome;
use Iv\System\Annotation\Controller;
use Iv\System\Annotation\Route;

/** @Controller(application="admin") */
class WelcomeController {

	/** @Route() */
	public function actionIndex() {
		return "pusemuckel";
	}

	/**
	 * @Route("test/$id")
	 * @param $id
	 * @return string
	 */
	public function actionTest($id) {
		return "ich bin ein id $id test";
	}

	/**
	 * @Route("$id/test")
	 * @param $id
	 * @return string
	 */
	public function actionTest2($id) {
		return "das ganze spiel mal $id anders rum";
	}

}