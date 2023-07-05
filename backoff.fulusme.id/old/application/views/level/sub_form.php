<?php
$active = $this->athoslib->activeLang();
echo '<div class="row">';
foreach($sub_content_data as $data){

	if ($active['label'] == 'Indonesia') {
	    $menu_label = $data['menu_label'];
	  } else {
	    $menu_label = $data['english_label'];
	  }

	echo '<div class="col-md-6">
		<div class="demo-checkbox">
			<input type="checkbox" id="'.$menu_label.'" name="'.$menu_label.'" value="'.$data['id_menu'].'" class="filled-in chk-col-light-blue" >
			<label for="'.$menu_label.'">'.$menu_label.'</label>
		</div>
		</div>';
	
}
echo '</div>';
?>

