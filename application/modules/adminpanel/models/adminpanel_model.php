<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminpanel_model extends CI_Model {

	public static $userCount;
	public static $userCountThisMonth;
	
	public function __construct() {
        parent::__construct();
		$this->count_users();
		$this->count_users_this_month();
    }
	
	public function count_users() {
		self::$userCount = $this->db->count_all_results('user');
	}
	public function count_users_this_month() {
		self::$userCountThisMonth = $this->db->query("SELECT count(1) as count FROM user WHERE MONTH(date_registered) = MONTH(CURDATE()) AND YEAR(date_registered) = YEAR(CURDATE())")->row();
		
	}

}