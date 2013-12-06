<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
    <link rel="stylesheet" href="/css/basic-minimal.css" type="text/css"/>
	
</head>

<body>

<div id='menu'>

    <a href='/'>Home</a> |

    <!-- Menu for users who are logged in -->
    <?php if($user): ?>
        <a href='/posts'>Posts</a> |
        <a href='/users/profileedit/<?php echo $user->user_id?>'>You</a> |
        <a href="/users">Others |
        <a href='/users/logout'>Logout</a>

        <!-- Menu options for users who are not logged in -->
    <?php else: ?>

        <a href='/users/signup'>Sign up</a> |
        <a href='/users/login'>Log in</a>

    <?php endif; ?>

</div>

<br>

<?php if(isset($content)) echo $content; ?>

</body>
</html>