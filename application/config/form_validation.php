<?php
	$config = array(
		'signup' =>	array(
			array(
				'field' => 'real_name',
				'label' => 'Real Name',
				'rules' => 'required'
			),
			array(
				'field' => 'student_id',
				'label' => 'Student ID',
				'rules' => 'required'
			),
			array(
				'field' => 'ucard',
				'label' => 'UCard',
				'rules' => 'required|exact_length[17]|numeric|callback_ucard_check'
			),
      array(
        'field' => 'x500',
        'label' => 'x500',
        'rules' => 'callback_x500_check'
      ),
			array(
				'field' => 'email',
				'lable' => 'E-Mail',
				'rules' => 'required|valid_email',
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|matches[passconf]'
			),
			array(
				'field' => 'passconf',
				'label' => 'Password Confirmation',
				'rules' => 'required'
			),
			array(
				'field' => 'user_name',
				'label' => 'User Name',
				'rules' => 'required|callback_user_name_check'
			),
		)
	);
?>
