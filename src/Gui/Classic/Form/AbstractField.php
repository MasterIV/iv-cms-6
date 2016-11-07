<?php


namespace Iv\Gui\Classic\Form;


use Iv\Gui\Classic\Html\Standalone;
use Iv\Gui\Classic\Html\Tag;

abstract class AbstractField {
	/** @var Tag */
	protected $label;
	/** @var Standalone */
	protected $input;

	protected static $count = 0;

	protected function createLabel($id, $caption ) {
		$this->label = Tag::create('label')->append( $caption );
		$this->label->for = $id;
		$this->label->class = 'control-label';
	}

	public function __construct( $name, $caption, $value = NULL ) {
		$id = 'form_field_'.self::$count++;
		$this->createLabel($id, $caption);

		$this->input = Standalone::create('input');
		$this->input->id = $id;
		$this->input->value = $value;
		$this->input->name = $name;
	}

	public function input( $attr, $value ) {
		$this->input->attr( $attr, $value );
		return $this;
	}

	public function label( $attr, $value ) {
		$this->label->attr( $attr, $value );
		return $this;
	}

	public function __toString() {
		return '<div class="control-group">'.$this->label.'<div class="controls">'.$this->input.'</div></div>';
	}
}