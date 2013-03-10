<h4><?php echo app::lang('step') ?> 4. <?php echo app::lang('step4_title') ?></h4>

<form action="/install/4" class="data-form" method="post">

	<div class="required_global"><?php echo app::lang('required_global') ?></div>
	<?php 
	foreach($f as $key => $arr){
		echo '<div class="row'.($arr['error'] ? ' error' : '').'">
			<label>
				<input type="text" name="'.$key.'" value="'.$arr['value'].'" style="width:300px;">
				<span class="title">'.$arr['label'].($arr['required']?'<span class="required">*</span>':'').':</span>
			</label>
			<span class="msg">'.$arr['error'].'</span>
		</div>';
	}
	?>
	
	<div class="submit" style="margin-top:20px;">
		<input type="submit" value="<?php echo app::lang('next') ?>" class="button">
	</div>
	
</form>