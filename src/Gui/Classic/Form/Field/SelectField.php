<?php


namespace Iv\Gui\Classic\Form\Field;


use Iv\Gui\Classic\Form\AbstractField;
use Iv\Gui\Classic\Html\Tag;

class SelectField extends AbstractField {
	public function __construct($name, $caption, $options, $value = NULL) {
		$id = 'form_field_'.self::$count++;
		$this->createLabel($id, $caption);

		$this->input = Tag::create('select');
		$this->input->name = $name;

		foreach( $options as $k => $v )
			if( $value != $k ) $this->input->append( '<option value="'.htmlspecialchars ($k).'">'.htmlspecialchars($v).'</option>' );
			else $this->input->append( '<option value="'.htmlspecialchars ($k).'" selected>'.htmlspecialchars($v).'</option>' );
	}
}