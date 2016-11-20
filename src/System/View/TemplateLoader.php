<?php


namespace Iv\System\View;

use Iv\System\Annotation\Inject;
use Iv\System\Annotation\Service;

/**
 * Class TemplateLoader
 * @package Iv\System\View
 * @Service()
 */
class TemplateLoader {
	/** @var \Twig_Loader_Filesystem */
	private $loader;
	/** @var \Twig_Environment */
	private $twig;
	/** @var array */
	private $globals = [];

	/**
	 * TemplateLoader constructor.
	 * @param $debug
	 * @Inject({"#debug"})
	 */
	public function __construct($debug) {
		$this->loader = new \Twig_Loader_Filesystem([
			ROOT . '/tpl/system'
		]);

		$settings = [];

		if(!$debug)
			$settings['cache'] = ROOT . '/cache/tpl';

		$this->twig = new \Twig_Environment($this->loader, $settings);

		$this->addGlobal('js', [
			ROOT_DIR.'/static/js/jquery.min.js',
			ROOT_DIR.'/static/js/jquery.jqgrid.min.js',
			ROOT_DIR.'/static/js/bootstrap.min.js',
			ROOT_DIR.'/static/js/bootstrap-select.min.js',
			ROOT_DIR.'/static/js/bootstrap-spinedit.js',
			ROOT_DIR.'/static/js/i18n/defaults-de_DE.min.js',
			ROOT_DIR.'/static/js/i18n/grid.locale-de.min.js',
		]);

		$this->addGlobal('css', [
			ROOT_DIR.'/static/css/bootstrap.min.css',
			ROOT_DIR.'/static/css/bootstrap-select.min.css',
			ROOT_DIR.'/static/css/bootstrap-sinedit.css',
			ROOT_DIR.'/static/css/bootstrap-theme.min.css',
			ROOT_DIR.'/static/css/ui.jqgrid.min.css',
		]);

		$this->addGlobal('root_dir', ROOT_DIR);
	}

	/**
	 * @param string $path
	 */
	public function addPath($path) {
		$this->loader->addPath($path);
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 */
	public function addGlobal($key, $value) {
		if(is_array($value))
			$this->globals[$key] = $value;
		$this->twig->addGlobal($key, $value);
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 */
	public function appendGlobal($key, $value) {
		if(!empty($this->globals[$key]) && is_array($value))
			$value = array_merge($this->globals[$key], $value);
		$this->twig->addGlobal($key, $value);
	}

	/**
	 * @param $template
	 * @return \Twig_Template
	 */
	public function load($template) {
		return $this->twig->loadTemplate($template.'.twig');
	}
}