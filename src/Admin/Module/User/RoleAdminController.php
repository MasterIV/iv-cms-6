<?php


namespace Iv\Admin\Module\User;

use Iv\System\Annotation\Module;
use Iv\System\Annotation\Route;

/**
 * Class RoleAdminController
 * @package Iv\Admin\Module\User
 * @Module(
 *     application="admin",
 *     route="/roles",
 *     category="Userverwaltung",
 *     caption="Rollen",
 *     icon="none.png")
 */
class RoleAdminController {
	/** @Route() */
	public function actionIndex() {
		return ['content' => 'dies ist ide rollenverwaltung'];
	}
}