<?php


namespace Iv\System\Routing\Response;

use Iv\System\Annotation\Component;

/**
 * Class RedirectResponse
 * @package Iv\System\Routing\Response
 * @Component()
 */
class RedirectResponse implements Response {
	public function handle($route, $application, $result) {
		header('LOCATION: '.$result);
	}
}