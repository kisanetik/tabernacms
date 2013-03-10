<h4><?php echo app::lang('step') ?> 2. <?php echo app::lang('step2_title') ?></h4>

<div id="configuration_list">
	<?php
	foreach ($f as $key => $arr)
		echo '<div ' . ($arr['error'] ? 'class="no"' : '') . '
			<td>' . $arr[($arr['error'] ? 'error' : 'label')] .
			(($arr['download'] and $arr['error']) ? '. <a href="' . $arr['download'] . '">' . app::lang('download') . '</a>' : '') . '
			</td>
		</div>';
	?>
</div>

<p style="margin-bottom:20px;<?php echo $hasErrors ? 'color:red;' : '' ?>">
	<?php echo app::lang('step2_txt' . ($hasErrors ? '2' : '1')) ?>
</p>

<form action="/install/<?php echo $hasErrors ? '2' : '3' ?>" class="data-form" method="post">
	<div class="submit">
		<input type="submit" value="<?php echo app::lang($hasErrors ? 'refresh' : 'next') ?>" class="button">
	</div>
</form>
