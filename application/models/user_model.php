<?php
class User_model extends CI_Model {
	
	var $id = null;
	var $real_name = null;
	var $student_id = null;
	var $ucard = null;
	var $x500 = null;
	var $email = null;
	var $phone = null;
	var $street = null;
	var $city = null;
	var $state = null;
	var $zip = null;
	var $user_name = null;
	var $password = null;
	var $shell = null;
	var $status = null;

	function __construct() {
		parent::__construct();
		$this->config->load('acm_constants');
	}

	function insert_user() {
		foreach($this as $key => $value) {
			if(($this->input->post($key))) {
				switch($key) {
					case "password":
						$this->$key = mcrypt_encrypt(MCRYPT_BLOWFISH, $this->config->item('ACM_REGISTRATION_KEY'), $this->input->post('password'), MCRYPT_MODE_ECB);
						break;
					case "user_name":
						$this->$key = strtolower($this->input->post('user_name'));
						break;
					case "id":
						$this->$key = null;
						break;
          case "x500":
            if(preg_match('/(.+?)@umn\.edu/', $this->input->post($key), $matches)) {
              $this->$key = $matches[1];
            }
            else {
              $this->$key = "Unmatched";
            }
            break;
					default:
						$this->$key = $this->input->post($key);
				}
			}
		}
		$this->status = 'pending';
		$this->db->insert('pending_users', $this);
	}
}

?>
