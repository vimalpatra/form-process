<?php 
ini_set('display_errors',1);

$errors = [];
$missing = [];

if (isset($_POST['send'])){

	$expectedFields = ['name','email','description'];
	$requiredFields = ['name','email'];

	$to = 'Vimal Patra <contact@vimalpatra.com>'; // should be the mail address to send to
	$subject = 'Feedback from online form';

	$headers = [];
	$headers[] = 'From: webmasters@vimalpatra.com'; // an email address on the domain
	// $headers[] = 'Cc: vimalpatra136@gmail.com';
	$headers[] = 'Bcc: vimalpatra1@gmail.com';
	$headers[] = 'Content-type: text/plain; charset=utf-8';
	$authorize = null;

	require('./includes/process_form.php');

	if ($mailSent) {
		echo 'header("Location: thanks.php")';
		// header("Location: thanks.php");
		
	}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		body{
			background: rgb(240,240,240);
		}
		*{
			box-sizing: border-box;	
			
		}
		.warning{
			color:red;
		}
		form{
			background: white;
			margin:auto;
			width: 700px;
			padding:  50px;
		}
		form label,
		form input,
		form textarea{
			display: block;
			width: 100%;
			
			font-size: 1.5rem;
		}
		form input,
		form textarea{
			min-height: 50px;
			border: 3px solid rgb(200,200,200);
		}
		form label{
			margin-top: 1rem;
			text-align:center;
		}
		button[type="submit"]{
			width: 100%;
			cursor: pointer;
			height: 50px;
			background: black;
			color: white;
			border:none;
			margin-top: 1rem;
			font-size: 1.5rem;

		}
	</style>
</head>
<body>

	<pre><?php 
		if ($_POST && $mailSent){
			echo "------------------message: \n\n";
			echo '<br>' . $message . '<br>';
			
			echo "------------------headers: \n\n";
			echo '<br>' . $headers . '<br>';

		}
		 ?>
	</pre>
	<form novalidate method="post" action="<?= $_SERVER['PHP_SELF'] ?>">

		<?php if($_POST && ($suspect || isset($errors['mailFail']) ) ) : ?>
			<p class="warning form-errors">
				Your mail couldn't be sent
			</p>
			<?php if (isset($errors['mailFail']) || $errors['mailFail']) { ?>
				<p class="warning form-errors">
					mail sending failed
				</p>
			<?php } ?>	

		<?php elseif ($errors || $missing) :  ?>

			<p class="warning form-errors">
				Please fix the errors in the form
			</p>

		<?php endif; ?>

		<div>
			<label for="">Name

			<?php if($missing && in_array('name', $missing)) : ?>
				<span class="warning missing-msg">
					Name cannot be left empty
				</span>
			<?php endif; ?>

			</label>
			<input type="text" name="name" value="<?= isset($name) ? htmlentities($name) : null; ?>">
		</div>
		<div>
			<label for="">E-Mail

			<?php if($missing && in_array('email', $missing)) : ?>
				<span class="warning missing-email">
					E-Mail cannot be left blank
				</span>
			<?php elseif(isset($errors['email']) && $errors['email']) : ?>
				<span class="warning errors-email">
					E-Mail address is not valid
				</span>
			<?php endif; ?>

			</label>
			<input type="email" name="email" id="" value="<?= isset($name) ? htmlentities($email) : null; ?>">
			
		</div>
		<div>
			<!-- label+input -->
			
		</div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div>
			<label for="">
				Description

				<?php if($missing && in_array('description', $missing)) : ?>
					<span class="warning missing-description">
						Description cannot be left blank
					</span>
				<?php endif; ?>

			</label>
			<textarea name="description" id="" cols="30" rows="10"><?= isset($name) ? htmlentities($description) : null; ?></textarea>
		</div>

		<div>
			<button name="send" type="submit">
				Submit Form
			</button>
		</div>

	</form>
	<?php  
		
		if ($_GET) {
			echo '<br><br>-------------------------<br><br>';
			echo 'contents of the GET array <br>';
			print_r($_GET);
		}
		if ($_POST) {
			echo '<br><br>-------------------------<br><br>';
			echo 'contents of the POST array <br>';
			print_r($_POST);
		}
	?> 
</body>
</html>