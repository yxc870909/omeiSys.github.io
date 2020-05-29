<?php
namespace App\Repository;
class User
{
	public static function getValidatorEvent()
	{
		$event = array(
			'AddTemple'=>array('admin','editor','local'),
			'EditTemple'=>array('admin','editor','local'),
			'AddUser_AddTab'=>array('admin','editor'),
			'GroupTab'=>array('admin','editor'),
			'EditPersonnel'=>array('admin','editor','local'),
			'EditPersonnel_Auth'=>array('admin'),
			'Agenda_AddTab'=>array('admin','editor'),
			'AddActivity_Record'=>array('admin','editor'),
			'AddCenter_Record'=>array('admin','editor'),
			'AddCenter_Status'=>array('admin','editor'),
			'MenuClasmanag'=>array('admin','editor'),
			'AddBookBorrow'=>array('admin','editor'),
			'AddBookBorrowCount'=>array('admin','editor'),
			'EditBookBorrow'=>array('admin','editor'),
			'BookBorrow_RecordTab'=>array('admin','editor'),
			'BookBorrow_BorrowTab'=>array('admin','editor'),
			'AddBookBorrow_itemShow'=>array('admin','editor'),
			);

		return $event;
	}

	public static function UserTypeValidator($eventName, $userType)
	{
		$validator = false;
		$event = User::getValidatorEvent();
		foreach($event as $key => $val) {
			if($key == $eventName) {
				foreach($val as $item) {
					if($item == $userType)
						$validator = true;
				}
			}
		}

		return $validator;
	}
}