<h4><?php echo app::lang('step') ?> 5. <?php echo app::lang('step5_title') ?></h4>

<?php 
if (!empty($error)){
	echo '<div class="error_msg round" id="error_install">'.
			app::lang('install_error').':<ul><li>'.
			implode('</li><li>', $error).
			'</li></ul></div>';
}
?>

<form action="/install/5" class="data-form" method="post">

	<input type="hidden" name="install" value="<?php echo empty($error) ? 'start' : 'restart' ?>">
	
	<div id="pre_install">
		<p><?php echo empty($error) ? app::lang('step5_txt1') : '' ?></p>
		<input type="submit" value="<?php echo app::lang((!empty($error)?'re':'').'start') ?>" class="button" onclick="
			$('#error_install').hide(0);
			$('#pre_install').hide(0);
			$('#post_install').show(0);
			return true;">
	</div>
</form>

<div id="post_install">
	<?php echo app::lang('installation') ?> <img src="img/i.gif">
</div>