<?php

/**
 * Template Name: Ref Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */


if (isset($_POST['register'])) {
	//print_r($_POST);
	$user_email = sanitize_email($_POST['user_email']);
	$user_pwd = md5($_POST['user_pwd']);
	$ref_code = sanitize_text_field($_POST['ref_code']);
	if(!empty($user_email ) && !empty($user_pwd) && !empty($ref_code)){
		global $wpdb;
		$sql = "SELECT user_email FROM `ref_register_table` WHERE user_email='".$user_email."'";
		$exist_user_data = $wpdb->get_results($sql);
		if($exist_user_data){
			$path = site_url();
			wp_redirect($path.'/Refral_System/?email_exist');
			
		}else{
			$chk_ref_id = "SELECT ref_code FROM `ref_register_table` WHERE ref_code='".$ref_code."'";
			$exist_ref_code_data = $wpdb->get_results($chk_ref_id);
			if($exist_ref_code_data){
			global $wpdb;
			$insert_records = $wpdb->insert('ref_register_table',
				array(
					'user_email'=>$user_email,
					'user_pwd'=>$user_pwd, 
					'ref_code'=>$ref_code
				));
			if(is_wp_error($insert_records)){

				echo "<p style='color:red'>Failed to insert data</p>";
			}else{
				 $get_refrer_username = "SELECT ref_code,user_email FROM `ref_register_table` WHERE ref_code = '".$ref_code."'";
				$refer_user_data = $wpdb->get_results($get_refrer_username);
				/*print_r($refer_user_data);
				die("ref data");*/
				$refrer_user_email = $refer_user_data[0]->user_email;

				/*$insert_ref_records = $wpdb->insert('refel_account',
				array(
					'ref_id'=>$ref_code,
					'refer_usernme'=>$refrer_user_email
					
				));*/
				if($insert_records){
					$amnt = "500";
					  $get_already_insrted_username = "SELECT * FROM `account` WHERE id_holder_name = '".$refrer_user_email."'";
					 $check_exist_Accuser_data = $wpdb->get_results($get_already_insrted_username);
					 //print_r($check_exist_Accuser_data);
					 $acc_holder_id = $check_exist_Accuser_data[0]->id;
					 $acc_holder_amount = $check_exist_Accuser_data[0]->amount;
					 /*echo $acc_holder_id;
					 echo $acc_holder_amount;*/
					 $amnt = $acc_holder_amount+$amnt;
					 //echo $amnt;

					if($check_exist_Accuser_data){
						//die("$refrer_user_email is exisit");
						$update_userdata = $wpdb->update('account',
						array(
								'id'=>$acc_holder_id,
								'amount'=>$amnt
								),array('id'=>$acc_holder_id));
						$path = site_url();
			wp_redirect($path.'/Refral_System/login');
						
						
					}else{
						$insert_ref_records_amount = $wpdb->insert('account',
					array(
					'id_holder_name'=> $refrer_user_email,
					'amount' => $amnt
					));
						$path = site_url();
			wp_redirect($path.'/Refral_System/login');

					}
					//die("inside");
					
					 
				}

			}
			
		}else{
				echo "Enter valid ref id";

			
			/*else{
				$path = site_url();
			wp_redirect($path.'/Refral_System/?email_exist');
			}*/
		}


		}

	}
}
get_header();
?>

<main id="site-content" role="main">

	<div class="container">
	<div class="col-md-6 mx-auto" style="width:300px;margin: 0 auto;">
		<h2>Register</h2>
		<form action="" method="POST">
		<label>Username</label>
		<input type="email" name="user_email" id="user_email" class="form-control">
		<label>Password</label>
		<input type="password" name="user_pwd" id="user_pwd" class="form-control">
		<label>Ref Code:</label>
		<input type="text" name="ref_code" id="ref_code" class="form-control"><br>
		<input type="submit" name="register" value="submit">

			
		</form>
		<a href="<?php echo $path; ?>/login/">Login here</a>
	</div>
	</div>
</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>

