<?php


namespace Iv\System\Routing\Response;

use Iv\System\Annotation\Component;

/**
 * Class PlainResponse
 * @package Iv\System\Routing\Response
 * @Component()
 */
class PlainResponse implements Response {
	public function handle($route, $application, $result) {
		var_dump( $result );
	}
}