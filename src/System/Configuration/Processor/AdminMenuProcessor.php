<?php


namespace Iv\System\Configuration\Processor;


use Iv\System\Annotation\Module;
use Iv\System\Configuration\Processor;

class AdminMenuProcessor implements Processor {
	const OUTPUT_FILE = ROOT.'/cache/admin_menu.php';

	private $menu = [];

	public function handleClass($class, $annotation) {
		if(!$annotation instanceof Module) return;
		$this->menu[$annotation->category][] = [
			'icon' => $annotation->icon,
			'caption' => $annotation->caption,
			'path' => $annotation->route
		];
	}

	public function handleConstructor($class, $annotation) {}
	public function handleMethod($class, $method, $annotation) {}

	public function complete() {
		ksort($this->menu);
		dumpData(self::OUTPUT_FILE, $this->menu);
	}
}