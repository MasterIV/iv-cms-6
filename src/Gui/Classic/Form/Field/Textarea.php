<?php


namespace Iv\Gui\Classic\Form\Field;


use Iv\Gui\Classic\Form\AbstractField;
use Iv\Gui\Classic\Html\Tag;

class Textarea extends AbstractField {
	public function __construct($name, $caption, $value = NULL) {
		$id = 'form_field_'.self::$count++;
		$this->createLabel($id, $caption);

		$this->input = Tag::create('textarea');
		$this->input->name = $name;
		$this->input->id = $id;
		$this->input->append( $value );
	}
}