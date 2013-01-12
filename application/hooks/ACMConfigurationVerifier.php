<?php if( ! defined('BASEPATH')) exit('No direct script access!');

class ACMConfigurationVerifier extends CI_Controller {

  private function db_permissions_okay($user) {
    $acl_output = array();
    exec("/usr/bin/getfacl /srv/dev_www/sites/$user/htdocs/registration/application/config/database.php", $acl_output);

    $badacl = false;

    foreach($acl_output as $line) {
      $matches = array();

      switch($line) {

        /* eat any empty lines */
        case "":
        break;

        /* user perms should be read-only */
        case (preg_match("/^user::(.+)$/", $line, $matches) == 1):
          if($matches[1] != "rw-") {
            $badacl = true;
          }
        break;

        /* group should have no permissions */
        case (preg_match("/^group::(.*)$/", $line, $matches) == 1):
          if($matches[1] != "---") {
            $badacl = true;
          }
        break;

        /* others perms should have no permissions */
        case (preg_match("/^other::(.*)$/", $line, $matches) == 1):
          if($matches[1] != "---") {
            $badacl = true;
          }
        break;

        /* the only ACL statement that's allowed is u:www-data:r */
        case (preg_match("/^(user|group):(.+):(.*)$/", $line, $matches) == 1):
          if($matches[1] != "user") {
            $badacl = true;
          }
          if($matches[2] != 'www-data') {
            $badacl = true;
          }
          if($matches[3] != 'r--') {
            $badacl = true;
          }
        break;
      }//end switch
      
      if($badacl == true) {
        break;
      }//always break immediately when something fails

    }//end loop
    
    if($badacl == true) {
      return false;
    }
    else {
      return true;
    }
  }

  private function get_user_from_host() {
      $matches = array();

      if( preg_match("/^(.+)\.dev\.acm\.umn\.edu$/", $_SERVER['SERVER_NAME'], $matches) == 1) {
        return $matches[1];
      }
      else {
        return null;
      }
  }

  # This makes sure that the user has setup their environment properly before beginning to develop.
  public function check_getting_started() {
    $CI =& get_instance();
    $CI->load->database();

    $message = "Before working on this application, you need to setup your environment.  Please read the README.md file.  Here's what you still need to change:<br/><ul>";
    $fail = false;

    $acm_user = $this->get_user_from_host();

    if(is_null($acm_user)) {
      $message .= "<li>Please run this from your ACM development space or disable the validation hooks.</li>";
      $fail = true;
    }

    if(is_null($acm_user)) {
      $message .= "<li>Unable to locate your database.php file.  Make sure you application is installed properly in the ACM development space.</li>";
    }
    elseif( ! is_readable('application/config/database.php') or ! $this->db_permissions_okay($acm_user) ) {
      $message .= "<li>Your registration/application/config/database.php file must be configured properly!  Please make sure to <br/><code>chmod 600 database.php; setfacl -m u:www-data:r database.php;</code></li>";
      $fail = true;
    }

    if($CI->db->username == 'CHANGEME') {
      $message .= "<li>Your database username should be set to your ACM username in registration/application/config/database.php</li>";
      $fail = true;
    }

    if($CI->db->password == 'password') {
      $message .= "<li>Your database username should be set to your ACM DATABASE password in registration/application/config/database.php</li>";
      $fail = true;
    }

    if($CI->db->database == 'CHANGEME_registration') {
      $message .= "<li>Your database should be set to your ACM usernamed followed by \"_registration\" in registration/application/config/database/php</li>";
      $fail = true;
    }

    if($CI->config->config['base_url'] == 'https://CHANGEME.dev.acm.umn.edu/registration/') {
      $message .= "<li>Your base url should be set to \"https://YOUR ACM USERNAME.dev.acm.umn.edu/registration/\" in registration/application/config/config.php</li>";
      $fail = true;
    }
    
    if($CI->config->config['log_path'] == '/srv/dev_www/log/CHANGEME/registration.log') {
      $message .= "<li>Your log path should be set to \"/srv/dev_www/log/YOUR ACM USERNAME/registration.log\" in registration/application/config/config.php</li>";
      $fail = true;
    }
    
    $message .= "</ul><br/>If you need help getting started, please e-mail acm@cs.umn.edu.";
    if ( $fail == true ) {
      die($message);
    }
  }
}

