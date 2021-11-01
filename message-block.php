<?php

if(isset($_SESSION['msg_error_fr']))
{
	$error = $_SESSION['msg_error_fr'];
	unset($_SESSION['msg_error_fr']);
}

if(isset($_SESSION['msg_success_fr']))
{
	$success = $_SESSION['msg_success_fr'];
	unset($_SESSION['msg_success_fr']);
}

?>

<?php if($error != "") { ?>
<div class="">
	<div class="errormes">
		<div class="message-box-wrap"> 
			<i class="fa fa-exclamation-circle fa-lg"></i> 
			<?php echo $error; ?>
		</div>
	</div>
</div>
<?php } ?>


<?php if($success != "") { ?>
<div class="">
	<div class="successmes">
		<div class="message-box-wrap"> 
			<i class="fa fa-check-square fa-lg"></i> 
			<?php echo $success; ?>
		</div>
	</div>
</div>
<?php } ?>