<?php


namespace Iv\Cms\Content;

use Iv\System\Annotation\Controller;
use Iv\System\Annotation\Route;

/**
 * Class DisplayController
 * @package Iv\Cms\Content
 * @Controller(application="cms")
 */
class DisplayController {
	/**
	 * @Route("$id")
	 * @param $id
	 */
	public function actionIndex($id) {
		return "page $id";
	}
}