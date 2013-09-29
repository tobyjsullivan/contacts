<?php

class ContactTest extends CDbTestCase {
	public $fixtures = array(
			'users' => ':tbl_users',
			'contacts' => ':tbl_contacts'
		);
	
	public function testCreateNewWithNameOnly() {
		
		
		$contact = new Contact;
		$owner_id = $this->users['sample1']['user_id'];
		$contact->owner_id = $owner_id;
		$contact->name = "Eunice Dias";
		$contact->save();
		
		$contact_id = $contact->contact_id;
		
		$this->assertNotEquals("0", $contact_id);
		
		$contact = null;
		$foundContact = Contact::model()->find('contact_id=:contact_id', array(':contact_id'=>$contact_id));
		
		$this->assertEquals("Eunice Dias", $foundContact->name);
	}
}