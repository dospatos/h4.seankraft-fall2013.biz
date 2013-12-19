<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
    <link rel="stylesheet" href="/css/basic-minimal.css" type="text/css"/>
    <link rel="stylesheet" href="/css/jquery-ui.css" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.core.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.timer.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.question.js"></script>
    <script type="text/javascript" src="/js/jquery.watermark.js"></script>

</head>

<body>

<div id='menu' style="width:100%;border:1px solid black">

    <div id="spanUsername" style="clear: both">
    <a href='/'>Our Online Tests</a>

    <?php if($user) { //menu items for logged in users?>
        (<a href='/users/profileedit/<?php echo $user->user_id?>'><?php echo $user->first_name." ".$user->last_name ?></a>)
    <?php }?>
    </div>

    <div id="spanMenu" style="text-align: right;border:1px solid red;clear: none;">
        <?php if($user) { ?>
            <?php if ($user->is_admin) {//menu items for admins?>
                <a href="/tests">Tests |
                <a href="/testtakers">Test Takers |
            <?php }?>
            <a href='/tests/viewhistory'>My Tests History</a> |
            <a href='/users/logout'>Logout</a>

        <?php } else { //non-loged-in user's menu?>
            <a href='/users/signup'>Sign up</a> |
            <a href='/users/login'>Log in</a>
        <?php } ?>
    </div>
    <div style="clear:both"></div>
    <hr style="border-top:1px dotted #aaa;">
</div>

<?php if (isset($content->errors)) { ?>
    <?php foreach($content->errors AS $current_error) { ?>
        <div class='alerttext'>
            Error: <?php echo $current_error ?>
        </div>
    <?php } ?>
<?php }?>

<div id="maincontent">
<?php if(isset($content)) echo $content; ?>
</div>

</body>
</html>