<?php

namespace Iv\Gui\Classic\Form;

use Iv\Gui\Classic\Form\Field\Checkbox;
use Iv\Gui\Classic\Form\Field\HiddenInput;
use Iv\Gui\Classic\Form\Field\PasswordInput;
use Iv\Gui\Classic\Form\Field\RadioBox;
use Iv\Gui\Classic\Form\Field\SelectField;
use Iv\Gui\Classic\Form\Field\Textarea;
use Iv\Gui\Classic\Form\Field\TextInput;
use Iv\Gui\Classic\Html\Standalone;
use Iv\Gui\Classic\Html\Tag;

class FormRenderer extends Tag {
	protected $buttons;

	public function __construct($action, $submit = "Speichern", $method = "post") {
		parent::__construct('form');
		$this->action = $action;
		$this->method = $method;
		$this->class = 'form-horizontal';

		$this->buttons = Tag::create('div')->attr('class', 'controls');
		$this->button($submit, 'submit', 'btn btn-primary');
	}

	public function field(AbstractField $f) {
		$this->append($f);
		return $f;
	}

	/**
	 * Add a single line text input to the form
	 * @param string $name
	 * @param string $caption
	 * @param string $value
	 * @return TextInput
	 */
	public function text($name, $caption, $value = NULL) {
		return $this->field(new TextInput($name, $caption, $value));
	}

	/**
	 * Add a password input to the form
	 * @param string $name
	 * @param string $caption
	 * @param string $value
	 * @return PasswordInput
	 */
	public function password($name, $caption, $value = NULL) {
		return $this->field(new PasswordInput($name, $caption, $value));
	}

	/**
	 * Add a dropdown select to the form
	 * @param string $name
	 * @param string $caption
	 * @param array $options
	 * @param string $value
	 * @return SelectField
	 */
	public function select($name, $caption, $options, $value = NULL) {
		return $this->field(new SelectField($name, $caption, $options, $value));
	}

	/**
	 * Adds a radio box selection to the form
	 * @param string $name
	 * @param string $caption
	 * @param array $options
	 * @param string$value
	 * @return RadioBox
	 */
	public function radio($name, $caption, $options, $value = NULL) {
		return $this->field(new RadioBox($name, $caption, $options, $value));
	}

	/**
	 * Adds a textare to the form
	 * @param string $name
	 * @param string $caption
	 * @param string $value
	 * @return Textarea
	 */
	public function textarea($name, $caption, $value = NULL) {
		return $this->field(new Textarea($name, $caption, $value));
	}

	/**
	 * Adds a checkbox to the form
	 * @param string $name
	 * @param string $caption
	 * @param string $value
	 * @return Checkbox
	 */
	public function checkbox($name, $caption, $value = NULL) {
		return $this->field(new Checkbox($name, $caption, $value));
	}

	/**
	 * Adds an invisible input to the form
	 * @param string $name
	 * @param string $value
	 * @return HiddenInput
	 */
	public function hidden($name, $value = NULL) {
		return $this->field(new HiddenInput($name, $value));
	}

	/**
	 * Add an upload field to the form
	 * @param string $name
	 * @param string $caption
	 * @param string $type
	 * @return TextInput
	 */
	public function upload($name, $caption, $type = null) {
		$this->enctype = 'multipart/form-data';
		$field = $this->text($name, $caption);
		$field->input('type', 'file');
		if ($type) $field->input('accept', $type);
		return $field;
	}

	/**
	 * Add a button to the bottom of the form
	 * @param $value
	 * @param string $type
	 * @param string $class
	 * @return Standalone
	 */
	public function button($value, $type = 'button', $class = 'btn') {
		$button = Standalone::create('input')->attr('type', $type)->attr('value', $value)->attr('class', $class);
		$this->buttons->append($button);
		return $button;
	}

	/**
	 * Add a button to the form, that is a link to another page
	 * Could be used for cancel buttons for example
	 * @param $value
	 * @param $link
	 * @param string $class
	 * @return Standalone
	 */
	public function linkButton($value, $link, $class = 'btn') {
		$button = Standalone::create('input')->attr('type', 'button')->attr('value', $value)->attr('class', $class);
		$this->buttons->append($button->attr('onclick', "location.href = '{$link}'"));
		return $button;
	}

	/**
	 * Converts the object into html string
	 * @return string
	 */
	public function __toString() {
		$this->append(Tag::create('div')->attr('class', 'control-group')->append($this->buttons));
		return parent::__toString();
	}
}