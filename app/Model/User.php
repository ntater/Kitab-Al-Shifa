<?php
class User extends AppModel
{
	public $actsAs = array('Containable');
	public $useDbConfig = 'joomla';
	public $useTable = 'users';
 	public $hasOne = array(
			'Profile' => array(
				'className' => 'Profile',
				'foreignKey' => 'id',
				'conditions' => '',
				'fields' => array('cb_displayname', 'firstname', 'lastname'),
				'order' => '')
	);
	public $hasMany = array('Shifts');
	public $hasAndBelongsToMany = array(
		'Usergroup' =>
			array(
				'className'				=> 'Usergroup',
				'joinTable'				=> 'user_usergroup_map',
				'foreignKey'			=> 'user_id',
				'associationForeignKey'	=> 'group_id',
				'unique'				=> true,
				'conditions'			=> '',
				'fields'				=> '',
				'order'					=> '',
				'limit'					=> '',
				'offset'				=> '',
				'finderQuery'			=> '',
				'deleteQuery'			=> '',
				'insertQuery'			=> ''
			)
	);
	var $displayField = 'name';
	public $order = array('block' => 'ASC');

	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A username is required'
			)
		),
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A password is required'
			)
		),
	);

	
	public function getList($conditions = array(), $full = NULL) {
		$userList = array();
		if ($full) {
			$userFields = array('Profile.firstname', 'Profile.lastname', 'User.id');
			$userOrder = array('Profile.lastname ASC, Profile.firstname ASC');
		}
		else {
			$userFields = array('User.id', 'Profile.cb_displayname');
			$userOrder = array('Profile.cb_displayname ASC');
		}
		$users = $this->find('list', array(
			'contain' => array('Profile'),
			'fields' => $userFields,
			'order'=> $userOrder,
			'recursive' => 0,
			'conditions' => $conditions
		));

		foreach ($users as $id => $fullname) {
			foreach ($fullname as $firstname => $lastname) {
				$userList[$id]['User']['id'] = $id;
				if ($full) {
					$userList[$id]['Profile']['firstname'] = $firstname;
					$userList[$id]['Profile']['lastname'] = $lastname;
				}
				else {
					$userList[$id]['Profile']['cb_displayname'] = $fullname;
				}
			}
		}

		return $userList;
	}

	
 	public function getActiveUsersForGroup($group, $full = null, $conditions = array()) {
 		if ($full) {
 			$userFields = array('Profile.firstname', 'Profile.lastname');
 		}
 		else {
 			$userFields = array('Profile.cb_displayname');
 		}
 		$conditions = array_merge(array('Usergroup.id' => $group, 'User.block' => 0), $conditions);

 		
 		
 		$userList = $this->find('all', array(
 				'conditions' => $conditions, 
 				'recursive' => '0',
 				'fields' => array_merge(array('User.id'), $userFields),
 				'order' => array('Profile.lastname' => 'ASC', 'Profile.firstname' => 'ASC', 'Profile.cb_displayname' => 'ASC'),
 				'joins' => array(
						array(
								'table' => 'j17_user_usergroup_map',
								'alias' => 'UsersUsergroup',
								'type' => 'inner',
								'foreignKey' => false,
								'conditions'=> array('UsersUsergroup.user_id = User.id')
						),
						array(
								'table' => 'j17_usergroups',
								'alias' => 'Usergroup',
								'type' => 'inner',
								'foreignKey' => false,
								'conditions'=> array('Usergroup.id = UsersUsergroup.group_id')
 						)
				),
 				'contain' => array('Profile' => array(
 						'fields' => array('Profile.firstname', 'Profile.lastname')
 						)
 				)
			)
 		);

 		return $userList;
 	}
 	
 	/**
 	 * Function will query user's preferred communication method and return it
 	 * @param integer $toUser
 	 */
 	public function getCommunicationMethod($toUser) {
 		//FIX: Stubbed for now
 		return 'email';
 	}
}
?>