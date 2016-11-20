<?php


namespace Iv\Admin\Module\User;

use Iv\System\Annotation\Module;
use Iv\System\Annotation\Route;

/**
 * Class UserAdminContoller
 * @package Iv\Admin\Module\User
 * @Module(
 *     application="admin",
 *     route="/user",
 *     category="Userverwaltung",
 *     caption="Benutzer",
 *     icon="none.png")
 */
class UserAdminController {
	/** @Route() */
	public function actionIndex() {
		return ['content' => 'dies ist ide userverwaltung'];
	}
}