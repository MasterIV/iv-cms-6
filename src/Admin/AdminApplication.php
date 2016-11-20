<?php


namespace Iv\Admin;

use Iv\System\Annotation\App;
use Iv\System\Annotation\Inject;
use Iv\System\Routing\Application;
use Iv\System\View\TemplateLoader;

/** @App(name = "admin", route = "admin") */
class AdminApplication implements Application {
	const TEMPLATE_DIR = '/tpl/admin/default';

	/** @var TemplateLoader */
	private $loader;

	/**
	 * AdminApplication constructor.
	 * @param TemplateLoader $loader
	 * @Inject({"@TemplateLoader"})
	 */
	public function __construct(TemplateLoader $loader) {
		$this->loader = $loader;
	}

	public function getTemplate($route) {
		$this->loader->addPath(ROOT . self::TEMPLATE_DIR);
		$this->loader->addGlobal('base_dir', ROOT_DIR . self::TEMPLATE_DIR);
		return $this->loader->load('index');
	}

	public function isAccessible($route) {
		return true;
	}
}