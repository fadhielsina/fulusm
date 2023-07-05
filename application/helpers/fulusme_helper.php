<?php 

function is_logged_in()
{
	$ci = get_instance();
	if (!$ci->session->userdata('email')) {
		redirect('auth');
	}else{
		$role_id = $ci->session->userdata('role_id');
		$role_accepted = "6";

		if($role_id != $role_accepted){
			redirect('auth/blocked');
		}
	}
}


function is_logged_in_non()
{
	$ci = get_instance();
	if (!$ci->session->userdata('email')) {
		redirect('auth');
	}else{
		$role_id = $ci->session->userdata('role_id');
		$role_accepted = "6";
		$role_accepted_non = "1";


		if($role_id != $role_accepted || $role_accepted != $role_accepted_non){
			redirect('auth/blocked');
		}
	}
}

function check_access($role_id, $menu_id)
{
	$ci = get_instance();
	$ci->db->where('role_id', $role_id);
	$ci->db->where('menu_id', $menu_id);
	$result = $ci->db->get('user_access_menu');

	if ($result->num_rows() > 0 ) {
		return "checked = 'checked'";
	}
}

 ?>