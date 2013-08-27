<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<title><?php echo app::lang('title') ?></title>
<link rel="stylesheet" href="/install/style.css" type="text/css">
<script src="/libc/jquery/jquery.js" type="text/javascript"></script>
</head>
<body>
    <div id="page">
        <div id="header">
            <img src="/image.php?m=core&p=original&f=des/logo.jpg">
            <div id="page_title"><?php echo app::lang('title') ?></div>
        </div>
        <div id="content">
            <?php echo app::getVar('content') ?>
        </div>
    </div>
</body>
</html>
