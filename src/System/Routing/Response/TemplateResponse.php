<?php


namespace Iv\System\Routing\Response;

use Iv\System\Annotation\Component;
use Iv\System\Annotation\Inject;
use Iv\System\View\TemplateLoader;

/**
 * Class TemplateResponse
 * @package Iv\System\Routing\Response
 * @Component()
 */
class TemplateResponse implements Response {
	/** @var TemplateLoader */
	private $loader;

	/**
	 * TemplateResponse constructor.
	 * @param TemplateLoader $loader
	 * @Inject({"@TemplateLoader"})
	 */
	public function __construct(TemplateLoader $loader) {
		$this->loader = $loader;
	}


	public function handle($route, $application, $result) {
		$template = empty($application)
			? $this->loader->load('content/'.$route['method'])
			: $application->getTemplate($route);
		$template->display($result);
	}
}