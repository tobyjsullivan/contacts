<?php
/**
 * ContactForm class.
 * ContactForm is a container for managing contact form data. It is used in 'Add Contact' and 'Edit Contact'.
 *
 */
class ContactForm extends CFormModel {
	public $name;
	public $phone;
	public $twitter;
	
	public function rules()
	{
		return array(
				array('name', 'required'),
				array('name', 'length', 'min'=>1, 'max'=>42),
				array('phone', 'length', 'max'=>20),
				array('twitter', 'length', 'max'=>17),
		);
	}
}