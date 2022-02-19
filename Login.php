<?php

/**
 * Template Name: Login Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */


if (isset($_POST['login'])) {
	//print_r($_POST);
	$user_email = sanitize_email($_POST['user_email']);
	$user_pwd = md5($_POST['user_pwd']);
	
	if(!empty($user_email ) && !empty($user_pwd)){
		global $wpdb;
		 $sql = "SELECT user_email,user_pwd FROM `ref_register_table` WHERE user_email='".$user_email."' AND user_pwd = '".$user_pwd."'";
		$login = $wpdb->get_results($sql);
		//print_r($exist_user_data);
		if($login>0){
			$path = site_url();
			//echo $path;
			wp_redirect('http://localhost/Refral_System/dashboard/');
			
		}else{
			//wp_die("login failed");
			$path = site_url();
			//wp_redirect($path.'/Refral_System/?invalid-login');


		}

	}
}
get_header();
?>

<main id="site-content" role="main">

	<div class="container">
	<div class="col-md-6 mx-auto" style="width:300px;margin: 0 auto;">
		<h2>Login</h2>
		<form action="" method="POST">
		<label>Username</label>
		<input type="email" name="user_email" id="user_email" class="form-control">
		<label>Password</label>
		<input type="password" name="user_pwd" id="user_pwd" class="form-control"><br>
		
		<input type="submit" name="login" value="Login">

			
		</form>
		
	</div>
	</div>
</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>

