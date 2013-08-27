<h4><?php echo app::lang('step') ?> 1. <?php echo app::lang('step1_title') ?></h4>

<form action="/install/1" class="data-form" method="post">
    <input type="hidden" name="license" value="0">

    <div class="row<?php echo $f['license']['error'] ? ' error' : '' ?>">

        <p><?php echo app::lang('step1_txt1') ?></p>

        <iframe src="../LICENSE.txt" style="width:100%;height:300px;border:1px solid #ccc;"></iframe>

        <p style="margin:10px;text-align:center;"><label>
            <input type="checkbox" name="license" value="1" <?php echo $f['license']['value'] == '1' ? 'checked' : '' ?>> <?php echo app::lang('i_agree') ?>
        </label></p>

        <div class="msg round"><?php echo $f['license']['error'] ?></div>
    </div>

    <div class="submit">
        <input type="submit" value="<?php echo app::lang('next') ?>" class="button">
    </div>
</form>