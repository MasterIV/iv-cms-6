<?php


namespace Iv\Gui\Classic\Form\Field;


use Iv\Gui\Classic\Form\AbstractField;

class Checkbox extends AbstractField {
	public function __construct($name, $caption, $value = NULL) {
		parent::__construct($name, $caption, 1);
		$this->input->type = 'checkbox';
		if ($value) $this->input->checked = "checked";
	}
}