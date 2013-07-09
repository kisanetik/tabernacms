<h4><?php echo app::lang('step') ?> 3. <?php echo app::lang('step3_title') ?></h4>

<form action="/install/3" class="data-form" method="post">

    <div class="required_global"><?php echo app::lang('required_global') ?></div>
    <?php
    foreach ($f as $key => $arr) {
        echo '<div class="row' . ($arr['error'] ? ' error' : '') . '">
            <label>
                <input type="text" name="' . $key . '" value="' . $arr['value'] . '" style="width:300px;">
                <span class="title">' . $arr['label'] . ($arr['required'] ? '<span class="required">*</span>' : '') . ':</span>
            </label>
            <span class="msg">' . $arr['error'] . '</span>
        </div>';
    }
    ?>

    <div class="submit" style="margin-top:20px;">
        <span style="display:none;" id="next_value"><?php echo app::lang('next') ?></span>
        <img src="/install/img/ajax.gif" alt="<?php echo app::lang('server_response') ?>" style="margin-right:5px;display:none;" align="bottom" id="ajax_indication">
        <span style="margin-right:5px;color:red;display:none;" id="error_msg"></span>
        <span style="margin-right:5px;color:green;display:none;" id="success_msg"><?php echo app::lang('test_successful') ?></span>
        <input type="submit" value="<?php echo app::lang('test_connection') ?>" class="button test_connect">
    </div>

</form>

<script src="/install/testConnect.js" type="text/javascript"></script>