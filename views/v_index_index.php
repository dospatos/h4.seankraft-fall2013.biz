<h2>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h2>

    <p>
        The site to help whitewater boaters connect and find out what's running and who's running it!
    </p>

    <br/>
    <img src='/images/banner.png' alt='whitewater on the Beerkill' title='Jeff Piche on the Beerkill Creek'/>
    <h3>This site has +1 features</h3>
    <ul>
        <li>Support for user profiles & avatars</li>
        <li>Hashtags to identify rivers refered to in posts</li>
    </ul>

</p>

<?php if($user) { ?>
    <a href="/users">Find other boaters to follow!</a>
<?php } ?>