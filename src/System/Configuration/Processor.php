<?php


namespace Iv\System\Configuration;


interface Processor {
	public function handleClass($class, $annotation);
	public function handleConstructor($class, $annotation);
	public function handleMethod($class, $method, $annotation);
	public function complete();
}