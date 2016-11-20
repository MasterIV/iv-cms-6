<?php


namespace Iv\System\Controller;


use Iv\System\Annotation\Controller;

/**
 * Class ErrorController
 * @package Iv\Cms
 * @Controller()
 */
class ErrorController {
	public function notFound() {
		return [];
	}

	public function forbidden() {
		return [];
	}
}