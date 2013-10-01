<?php
/**
 * This model represents users' contact data stored in the tbl_contacts table
 *
 */
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
}