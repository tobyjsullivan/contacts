<?php

class ContactFormTest extends CTestCase {
	/**
	 * This test verifies we can set and read the name property
	 */
	public function testSetName() {
		$contactForm = new ContactForm;
		
		$contactForm->name = "Josh Hadwell";
		
		$this->assertEquals("Josh Hadwell", $contactForm->name);
	}

	/**
	 * This test verifies we can set and read the phone # property
	 */
	public function testSetPhone() {
		$contactForm = new ContactForm;
	
		$contactForm->phone = "+1 (778) 555-2391";
	
		$this->assertEquals("+1 (778) 555-2391", $contactForm->phone);
	}
	
	/**
	 * This test verifies we can set and read the twitter handle property
	 */
	public function testSetTwitter() {
		$contactForm = new ContactForm;
		
		$contactForm->twitter = "@joshie";
		
		$this->assertEquals("@joshie", $contactForm->twitter);
	}
	
	public function testValidateNoName() {
		$form = new ContactForm();
		
		$form->name = "";
		
		$res = $form->validate();
		$this->assertFalse($res);
	}
	
	public function testValidateWithName() {
		$form = new ContactForm();
		
		$form->name = "Bobby Shell";
		
		$res = $form->validate();
		$this->assertTrue($res);
	}
}