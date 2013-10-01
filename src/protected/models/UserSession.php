<?php
/**
 * This model manages the data for active sessions. It is used by the UserSessionManager component
 * and data is stored in the table tbl_sessions
 */
class UserSession extends CActiveRecord
{	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_sessions';
	}
}