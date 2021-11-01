<?php

if(isset($_SESSION['msg_error']))
{
	$error = $_SESSION['msg_error'];
	unset($_SESSION['msg_error']);
}

if(isset($_SESSION['msg_success']))
{
	$success = $_SESSION['msg_success'];
	unset($_SESSION['msg_success']);
}

if ( $error != "" || $success != "" )
{
	if ( $error != "" )
	{
		$class = 'danger';
	}
	else if ( $success != "" )
	{
		$class = 'success';
	}
?>
	<div class="alert alert-micro alert-border-left alert-<?php echo $class; ?> alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-info pr10"></i><?php echo $error.$success; ?>
	</div>
<?php } ?>