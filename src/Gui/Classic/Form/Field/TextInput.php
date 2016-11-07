<?php


namespace Iv\Gui\Classic\Form\Field;


use Iv\Gui\Classic\Form\AbstractField;

class TextInput extends AbstractField {
	public function __construct($name, $caption, $value = NULL) {
		parent::__construct($name, $caption, $value);
		$this->input->type = 'text';
	}
}