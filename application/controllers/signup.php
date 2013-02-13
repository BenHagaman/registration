<?php

class Signup extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->config->load('acm_constants', FALSE, FALSE);
	}

	function index() {
		$this->load->view('signup/signup_welcome');
	}

	function register() {
		$this->load->view('signup/signup_form');
	}

	function do_register() {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="err_msg">','</div>');
		$this->load->model('User_model');
		$this->load->database();

		if ($this->form_validation->run('signup') == false) {
			$this->load->view('signup/signup_form');
		}
		else {
			$this->User_model->insert_user();
			$this->load->view('signup/success');
		}
	}

	function ucard_check($str) {
		$value = preg_match("/^600953\d{11}$/", $str);
		$this->form_validation->set_message("ucard_check", "UCard number must be 17 digits long and start with 600953");
		if ($value == 1) {
			return true;
		}
		else {
			return false;
		}
	}

	function student_id_check($str) {
		$value = preg_match("/^\d{7}$/", $str);
		$this->form_validation->set_message("student_id_check", "Student Id must be 7 digits long");
		if ($value == 1) {
			return true;
		}
		else {
			return false;
		}
	}

  function x500_check($x500) {
    if(isset($_SERVER['REMOTE_USER'])) {
      if ($x500 != $_SERVER['REMOTE_USER']) {
        $this->form_validation->set_message("x500_check", "Sorry, your UMN x500 ID must match the value you logged in with.");
        return false;
      }
      else {
        return true;
      }
    }
    else {
      return true;
    }
  }

	function user_name_check($un) {

 		$value = preg_match("/^[a-zA-Z\d]{3,16}$/", $un);
                $this->form_validation->set_message("user_name_check", "Usernames must be between 3-16 characters and consist of only letters and numbers (case sensitive)");
                if ($value != 1) {
                	return false;
                }

		$this->load->model('User_model', 'users');
		$res_query = $this->db->query("SELECT COUNT(*) as ct from reserved_names WHERE user_name = ?", array(strtolower($un)));
		$res_row = $res_query->row();

		$sup_query = $this->db->query("SELECT COUNT(*) as ct from pending_users WHERE user_name = ? AND status != 'denied'", array(strtolower($un)));
		$sup_row = $sup_query->row();

		if($res_row->ct > 0) {
			$this->form_validation->set_message('user_name_check', "The username $un is already in use");
			return false;
		}

		if($sup_row->ct > 0) {
			$this->form_validation->set_message('user_name_check', "The username $un is already in use");
			return false;
		}

    		$ds = ldap_connect($this->config->item('ACM_LDAP_SERVER_URL'));
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

		if($ds) {
			$res = ldap_bind($ds);
			$results = ldap_search($ds, $this->config->item('ACM_LDAP_USERS_OU'), "(uid=$un)", array('cn'));
			$info = ldap_get_entries($ds, $results);

			if($info["count"] > 0) {
				$this->form_validation->set_message('user_name_check', "The username $un is already in use");
				ldap_unbind($ds);
				return false;
			} else {
				ldap_unbind($ds);
				return true;
			}
		}
		
		// You never, EVER want to get here!
		$this->load->view('system_failure');
	}
}

?>
