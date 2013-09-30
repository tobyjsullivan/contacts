<?php
class Contact extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_contacts';
	}
	
	public function getFollowerCount() {
		if(empty($this->twitter)) {
			return null;
		}
		
		return TwitterUtils::getFollowerCount($this->twitter);
	}
}