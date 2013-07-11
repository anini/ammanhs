<div>
	<h2>New Membership Request:</h2>
	<div style="font-size: 20px">
		<br>
		<br>
		User ID: <?php echo $user->id; ?>
		<br>
		User Name: <?php echo $user->name; ?>
		<br>
		User Email: <?php echo $user->email; ?>
		<br>
		User Mobile: <?php echo $user->mobile; ?>
		<br>
		Membership Type: <?php echo $membership->type; ?>
		<br>
		Requested At: <?php echo $membership->created_at; ?>
	</div>
</div>