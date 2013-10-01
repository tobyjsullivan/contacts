<?php
/**
 * This model manages the data for active sessions. It is used by the UserSessionManager component
 *
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