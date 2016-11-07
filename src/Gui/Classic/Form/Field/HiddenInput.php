<?php


namespace Iv\Gui\Classic\Form\Field;


use Iv\Gui\Classic\Form\AbstractField;

class HiddenInput extends AbstractField {
	public function __construct($name, $value = NULL) {
		parent::__construct($name, '', $value);
		$this->input->type = 'hidden';
	}

	public function __toString() {
		return (string) $this->input;
	}
}