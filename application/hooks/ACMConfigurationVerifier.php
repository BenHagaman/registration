<?php if( ! defined('BASEPATH')) exit('No direct script access!');

class ACMConfigurationVerifier extends CI_Controller {

  # This makes sure that the user has setup their environment properly before beginning to develop.
  public function check_getting_started() {
    $CI =& get_instance();
    $CI->load->database();

    $message = "Before working on this application, you need to setup your environment.  Please read the README.md file.  Here's what you still need to change:<br/><ul>";
    $fail = false;

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

