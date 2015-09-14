<?php
/* Profile Fixture generated on: 2011-12-19 13:40:37 : 1324320037 */

/**
 * ProfileFixture
 *
 */
class ProfileFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'jem5_comprofiler';
/**
 * Import
 *
 * @var array
 */
//	public $import = array('connection' => 'joomla');

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'unique', 'collate' => NULL, 'comment' => ''),
		'firstname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'middlename' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'lastname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'hits' => array('type' => 'integer', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'message_last_sent' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'collate' => NULL, 'comment' => ''),
		'message_number_sent' => array('type' => 'integer', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'avatar' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'avatarapproved' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'approved' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'confirmed' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'collate' => NULL, 'comment' => ''),
		'lastupdatedate' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'registeripaddr' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cbactivation' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'banned' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'collate' => NULL, 'comment' => ''),
		'banneddate' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'unbanneddate' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'bannedby' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'unbannedby' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'bannedreason' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'acceptedterms' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'fbviewtype' => array('type' => 'string', 'null' => false, 'default' => '_UE_FB_VIEWTYPE_FLAT', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'fbordering' => array('type' => 'string', 'null' => false, 'default' => '_UE_FB_ORDERING_OLDEST', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'fbsignature' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_positiond' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_sites' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_undergrad' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_residency' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'connections' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_univappt' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_mdcert' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_profint' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_outint' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_memmnt' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_phoneh' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_phonem' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_phoneo' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_pager' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_addrcity' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_addrpstcd' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_addrs1' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_addrs2' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_addrprov' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'formatname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_displayname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'cb_ohip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 1), 'apprconfbanid' => array('column' => array('approved', 'confirmed', 'banned', 'id'), 'unique' => 0), 'avatappr_apr_conf_ban_avatar' => array('column' => array('avatarapproved', 'approved', 'confirmed', 'banned', 'avatar'), 'unique' => 0), 'lastupdatedate' => array('column' => 'lastupdatedate', 'unique' => 0)),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'user_id' => '1',
			'firstname' => 'James',
			'middlename' => NULL,
			'lastname' => 'Bynum',
			'hits' => '200',
			'message_last_sent' => '0000-00-00 00:00:00',
			'message_number_sent' => '0',
			'avatar' => '1.jpg',
			'avatarapproved' => '1',
			'approved' => '1',
			'confirmed' => '1',
			'lastupdatedate' => '2010-12-11 15:35:36',
			'registeripaddr' => '',
			'cbactivation' => '',
			'banned' => '0',
			'banneddate' => NULL,
			'unbanneddate' => NULL,
			'bannedby' => NULL,
			'unbannedby' => NULL,
			'bannedreason' => NULL,
			'acceptedterms' => 0,
			'fbviewtype' => '_UE_FB_VIEWTYPE_FLAT',
			'fbordering' => '_UE_FB_ORDERING_OLDEST',
			'fbsignature' => '',
			'cb_positiond' => 'Adult Emergency Physician',
			'cb_sites' => '',
			'cb_undergrad' => '',
			'cb_residency' => '',
			'connections' => NULL,
			'cb_univappt' => '',
			'cb_mdcert' => '',
			'cb_profint' => '',
			'cb_outint' => '',
			'cb_memmnt' => '',
			'cb_phoneh' => '',
			'cb_phonem' => '',
			'cb_phoneo' => '',
			'cb_pager' => '',
			'cb_addrcity' => '',
			'cb_addrpstcd' => '',
			'cb_addrs1' => '',
			'cb_addrs2' => '',
			'cb_addrprov' => '',
			'formatname' => NULL,
			'cb_displayname' => 'Bynum',
			'cb_ohip' => '010010'
		),
		array(
			'id' => '2',
			'user_id' => '2',
			'firstname' => 'Harold',
			'middlename' => NULL,
			'lastname' => 'Morrissey',
			'hits' => '200',
			'message_last_sent' => '0000-00-00 00:00:00',
			'message_number_sent' => '0',
			'avatar' => '2.jpg',
			'avatarapproved' => '1',
			'approved' => '1',
			'confirmed' => '1',
			'lastupdatedate' => '2010-04-28 14:02:01',
			'registeripaddr' => '',
			'cbactivation' => '',
			'banned' => '0',
			'banneddate' => NULL,
			'unbanneddate' => NULL,
			'bannedby' => NULL,
			'unbannedby' => NULL,
			'bannedreason' => NULL,
			'acceptedterms' => 0,
			'fbviewtype' => '_UE_FB_VIEWTYPE_FLAT',
			'fbordering' => '_UE_FB_ORDERING_OLDEST',
			'fbsignature' => '',
			'cb_positiond' => 'Adult Emergency Physician',
			'cb_sites' => '',
			'cb_undergrad' => '',
			'cb_residency' => '',
			'connections' => NULL,
			'cb_univappt' => '',
			'cb_mdcert' => '',
			'cb_profint' => '',
			'cb_outint' => '',
			'cb_memmnt' => '',
			'cb_phoneh' => '',
			'cb_phonem' => '',
			'cb_phoneo' => '',
			'cb_pager' => '',
			'cb_addrcity' => '',
			'cb_addrpstcd' => '',
			'cb_addrs1' => '',
			'cb_addrs2' => '',
			'cb_addrprov' => '',
			'formatname' => NULL,
			'cb_displayname' => 'Morrissey',
			'cb_ohip' => '010012'
		),
		array(
			'id' => '3',
			'user_id' => '3',
			'firstname' => 'Madeline',
			'middlename' => NULL,
			'lastname' => 'Cremin',
			'hits' => '200',
			'message_last_sent' => '0000-00-00 00:00:00',
			'message_number_sent' => '0',
			'avatar' => NULL,
			'avatarapproved' => '1',
			'approved' => '1',
			'confirmed' => '1',
			'lastupdatedate' => '0000-00-00 00:00:00',
			'registeripaddr' => '',
			'cbactivation' => '',
			'banned' => '0',
			'banneddate' => NULL,
			'unbanneddate' => NULL,
			'bannedby' => NULL,
			'unbannedby' => NULL,
			'bannedreason' => NULL,
			'acceptedterms' => 0,
			'fbviewtype' => '_UE_FB_VIEWTYPE_FLAT',
			'fbordering' => '_UE_FB_ORDERING_OLDEST',
			'fbsignature' => '',
			'cb_positiond' => 'Adult Emergency Physician',
			'cb_sites' => '',
			'cb_undergrad' => '',
			'cb_residency' => '',
			'connections' => NULL,
			'cb_univappt' => '',
			'cb_mdcert' => '',
			'cb_profint' => '',
			'cb_outint' => '',
			'cb_memmnt' => '',
			'cb_phoneh' => '',
			'cb_phonem' => '',
			'cb_phoneo' => '',
			'cb_pager' => '',
			'cb_addrcity' => '',
			'cb_addrpstcd' => '',
			'cb_addrs1' => '',
			'cb_addrs2' => '',
			'cb_addrprov' => '',
			'formatname' => NULL,
			'cb_displayname' => 'Cremin',
			'cb_ohip' => '010014'
		),
		array(
			'id' => '4',
			'user_id' => '4',
			'firstname' => 'Jacqueline',
			'middlename' => NULL,
			'lastname' => 'Beaudoin',
			'hits' => '200',
			'message_last_sent' => '0000-00-00 00:00:00',
			'message_number_sent' => '0',
			'avatar' => NULL,
			'avatarapproved' => '1',
			'approved' => '1',
			'confirmed' => '1',
			'lastupdatedate' => '2010-04-27 11:19:15',
			'registeripaddr' => '',
			'cbactivation' => '',
			'banned' => '0',
			'banneddate' => NULL,
			'unbanneddate' => NULL,
			'bannedby' => NULL,
			'unbannedby' => NULL,
			'bannedreason' => NULL,
			'acceptedterms' => 0,
			'fbviewtype' => '_UE_FB_VIEWTYPE_FLAT',
			'fbordering' => '_UE_FB_ORDERING_OLDEST',
			'fbsignature' => '',
			'cb_positiond' => 'Adult Emergency Physician',
			'cb_sites' => '',
			'cb_undergrad' => '',
			'cb_residency' => '',
			'connections' => NULL,
			'cb_univappt' => '',
			'cb_mdcert' => '',
			'cb_profint' => '',
			'cb_outint' => '',
			'cb_memmnt' => '',
			'cb_phoneh' => '',
			'cb_phonem' => '',
			'cb_phoneo' => '',
			'cb_pager' => '',
			'cb_addrcity' => '',
			'cb_addrpstcd' => '',
			'cb_addrs1' => '',
			'cb_addrs2' => '',
			'cb_addrprov' => '',
			'formatname' => NULL,
			'cb_displayname' => 'Beaudoin',
			'cb_ohip' => '010016'
		),
		array(
			'id' => '5',
			'user_id' => '5',
			'firstname' => 'Sabine',
			'middlename' => NULL,
			'lastname' => 'Chatigny',
			'hits' => '200',
			'message_last_sent' => '0000-00-00 00:00:00',
			'message_number_sent' => '0',
			'avatar' => NULL,
			'avatarapproved' => '1',
			'approved' => '1',
			'confirmed' => '1',
			'lastupdatedate' => '0000-00-00 00:00:00',
			'registeripaddr' => '',
			'cbactivation' => '',
			'banned' => '0',
			'banneddate' => NULL,
			'unbanneddate' => NULL,
			'bannedby' => NULL,
			'unbannedby' => NULL,
			'bannedreason' => NULL,
			'acceptedterms' => 0,
			'fbviewtype' => '_UE_FB_VIEWTYPE_FLAT',
			'fbordering' => '_UE_FB_ORDERING_OLDEST',
			'fbsignature' => '',
			'cb_positiond' => 'Adult Emergency Physician',
			'cb_sites' => '',
			'cb_undergrad' => '',
			'cb_residency' => '',
			'connections' => NULL,
			'cb_univappt' => '',
			'cb_mdcert' => '',
			'cb_profint' => '',
			'cb_outint' => '',
			'cb_memmnt' => '',
			'cb_phoneh' => '',
			'cb_phonem' => '',
			'cb_phoneo' => '',
			'cb_pager' => '',
			'cb_addrcity' => '',
			'cb_addrpstcd' => '',
			'cb_addrs1' => '',
			'cb_addrs2' => '',
			'cb_addrprov' => '',
			'formatname' => NULL,
			'cb_displayname' => 'Chatigny',
			'cb_ohip' => '010018'
		),
	);
}
