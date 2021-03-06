<!DOCTYPE html>
<html>
<head>
	<title>
        <?php if(isset($title)) echo $title; ?>
    </title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	

    <!-- Common CSS/JSS -->
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/js/flymeaway.js"></script>
    <script src="/js/preferences.js"></script>
    
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>  

    <div id='menu'>
        <div id = 'left'>
            <a href='/'><h2>Fly Me Away!</h2></a>
        </div>

        <!-- Menu for users who are logged in -->
        <div id='right'><h3>
            <?php if($user): ?>

                <a href='/users/preferences'>Trip Ideas</a>
                <a href='/flights/index'>Deals</a>
                <a href='/users/logout'>Log out</a>

            <!-- Menu options for users who are not logged in -->
            <?php else: ?>

                <a href='/users/signup'>Sign up</a>
                <a href='/users/login'>Log in</a>

            <?php endif; ?>
        </h3></div>
        <hr>

    </div>

    <br>

    <?php if(isset($content)) echo $content; ?>

</body>
</html>