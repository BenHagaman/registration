<html>
<head>
<title>ACM @ U of M: Signup!</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/signup_form.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/acm.css" type="text/css" />
</head>
<body>
<div id="container">
<?php
	$this->load->view('acm/header');
	echo form_open('signup/do_register');
?>
<div id="content">
<fieldset>
	<legend>Personal</legend>
	<div class="field_container">
	<label for="real_name">Name <span class="required">*</span></label>
	<input id="real_name" type="text" name="real_name" size="50" value="<?php echo set_value('real_name'); ?>"/>
	<?php echo form_error('real_name'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="student_id">Student ID <span class="required">*</span></label>
	<input id="student_id" type="text" name="student_id" size="50" value="<?php echo set_value('student_id'); ?>"/>
	<?php echo form_error('student_id'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="ucard">UCard Number <span class="required">*</span></label>
	<input id="ucard" type="text" name="ucard" size="50" value="<?php echo set_value('ucard'); ?>"/>
	<?php echo form_error('ucard'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="x500">X500 UMN ID <span class="required">*</span></label>
	<input id="x500" type="text" name="x500" size="50" <?php if(isset($_SERVER['REMOTE_USER'])) { echo "readonly"; } ?> value="<?php echo isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] : "" ?>"/>
	<?php echo form_error('x500'); ?>
	</div>
	<br/>
</fieldset>
<br/>
<fieldset>
	<legend>Contact Information</legend>
	<div class="field_container">
	<label for="email">E-Mail <span class="required">*</span></label>
	<input id="email" type="text" name="email" size="50" value="<?php echo set_value('email'); ?>"/>
	<?php echo form_error('email'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="phone">Phone Number</label>
	<input id="phone" type="text" name="phone" size="50" value="<?php echo set_value('phone'); ?>"/>
	<?php echo form_error('phone'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="street">Street</label>
	<input id="street" type="text" name="street" size="50" value="<?php echo set_value('street'); ?>"/>
	<?php echo form_error('street'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="city">City</label>
	<input id="city" type="text" name="city" size="50" value="<?php echo set_value('city'); ?>"/>
	<?php echo form_error('city'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="state">State</label>
	<input id="state" type="text" name="state" size="50" value="<?php echo set_value('state'); ?>"/>
	<?php echo form_error('state'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="zip">Zip</label>
	<input id="zip" type="text" name="zip" size="50" value="<?php echo set_value('zip'); ?>"/>
	<?php echo form_error('zip'); ?>
	</div>
	<br/>

</fieldset>
<br/>
<fieldset>
	<legend>Account Information</legend>
	<div class="field_container">
	<label for="user_name">User Name <span class="required">*</span></label>
	<input id="user_name" type="text" name="user_name" size="50" value="<?php echo set_value('user_name'); ?>"/>
	<?php echo form_error('user_name'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="password">Password <span class="required">*</span></label>
	<input id="password" type="password" name="password" size="50" value=""/>
	<?php echo form_error('password'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="passconf">Confirm<span class="required">*</span></label>
	<input id="passconf" type="password" name="passconf" size="50" value=""/>
	<?php echo form_error('passconf'); ?>
	</div>
	<br/>

	<div class="field_container">
	<label for="shell">Shell</label>
	<select id="shell" name="shell" value="<?php echo set_value('shell'); ?>">
		<option value="/bin/bash">bash</option>
		<option value="/bin/tcsh">tcsh</option>
		<option value="/bin/zsh">zsh</option>
	</select>
	<?php echo form_error('shell'); ?>
	</div>
	<br/>
</fieldset>

<p><?php echo form_submit('submit', 'Submit'); ?></p>

<?php echo form_close(); ?>
</form>
</div>
</div>
</body>
</html>
