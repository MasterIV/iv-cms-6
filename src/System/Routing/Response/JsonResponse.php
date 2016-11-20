<?php

namespace Iv\System\Routing\Response;

use Iv\System\Annotation\Component;

/**
 * Class JsonResponse
 * @package Iv\System\Routing\Response
 * @Component()
 */
class JsonResponse implements Response {
	public function handle($route, $application, $result) {
		echo json_encode($result);
	}
}