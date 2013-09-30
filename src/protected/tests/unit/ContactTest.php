<?php

class ContactTest extends CDbTestCase {
	public $fixtures = array(
			'users' => ':tbl_users',
			'contacts' => ':tbl_contacts'
		);
	
	public function testCreateNewWithNameOnly() {
		$owner_id = $this->users['sample1']['user_id'];
		
		$contact = new Contact;
		$contact->owner_id = $owner_id;
		$contact->name = "Eunice Dias";
		$contact->save();
		
		$contact_id = $contact->contact_id;
		
		$this->assertNotEquals("0", $contact_id);
		
		$contact = null;
		$foundContact = Contact::model()->find('contact_id=:contact_id', array(':contact_id'=>$contact_id));
		
		$this->assertEquals("Eunice Dias", $foundContact->name);
	}
	
	public function testCreateNewWithAllInfo() {
		$owner_id = $this->users['sample1']['user_id'];

		$contact = new Contact;
		$contact->owner_id = $owner_id;
		$contact->name = "Howard Osborn";
		$contact->phone = "215-853-0456";
		$contact->twitter = "hosborn";
		$contact->save();
		
		$contact_id = $contact->contact_id;
		
		$this->assertNotEquals("0", $contact_id);
		
		$contact = null;
		$foundContact = Contact::model()->find('contact_id=:contact_id', array(':contact_id'=>$contact_id));

		$this->assertEquals("Howard Osborn", $foundContact->name);
		$this->assertEquals("215-853-0456", $foundContact->phone);
		$this->assertEquals("hosborn", $foundContact->twitter);
	}
}