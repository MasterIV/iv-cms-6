<?php

namespace Iv\Gui\Classic\Form\Field;

use Iv\Gui\Classic\Form\AbstractField;
use Iv\Gui\Classic\Html\Standalone;
use Iv\Gui\Classic\Html\Tag;

class RadioBox extends AbstractField {
	public function __construct($name, $caption, $options, $value = NULL) {
		$this->label = Tag::create('div')->append($caption);
		$this->label->class = 'form_label';
		$this->input = array();

		foreach ($options as $k => $v) {
			$id = 'form_field_' . self::$count++;

			$label = Tag::create('label')->append($v);
			$label->for = $id;

			$input = Standalone::create('input');
			$input->type = 'radio';
			$input->id = $id;
			$input->value = $k;
			$input->name = $name;

			if ($k == $value)
				$input->checked = true;

			$this->input[] = array($input, $label);
		}
	}

	public function input($attr, $value) {
		foreach ($this->input as $i) $i[0]->attr($attr, $value);
	}

	public function __toString() {
		$inputs = '';
		foreach ($this->input as $i) $inputs .= $i[0] . $i[1] . '<br>';
		return '<div class="form_field">' . $this->label . '<div class="form_input">' . $inputs . '</div></div>';
	}

}