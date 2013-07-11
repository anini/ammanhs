<div style="direction: ltr;">
	<h2>Contact Form:</h2>
	<div style="font-size: 20px">
		<br>
		User ID: <?php echo $user_id; ?>
		<br>
		User Name: <?php echo $contact_form->name; ?>
		<br>
		User Email: <?php echo $contact_form->email; ?>
		<br>
		Subject: <?php echo $contact_form->subject; ?>
		<br>
		<br>
		Message:
		<br>
		<?php echo $contact_form->body; ?>
		<br>
		<br>
		Reference: <?php echo $contact_form->ref; ?>
		<br>
		User IP: <?php echo $user_ip; ?>
	</div>
</div>