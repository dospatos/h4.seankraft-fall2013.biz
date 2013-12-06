<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 10/8/13
 * Time: 7:59 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<h2>Other Users</h2>
<div>Click name to see profile and follow:</div>
<?php if($user) { //this block displays the options for the logged-inn user?>
    <!--List of users to follow-->
    <?php foreach($users_list AS $currentuser) { ?>

            <div>
                <a href="/users/profileview/<?php echo $currentuser['user_id'] ?>">
                    <img src='/uploads/avatars/<?php echo $currentuser["avatar"] ?>' style='height:50px;width:50px' alt='profile picture'/>
                    <?php echo $currentuser['first_name'].' '.$currentuser['last_name'] ?>
                </a>
                <?php if($currentuser["following_user_id"] == $user->user_id){
                    echo "<a href='/users/p_profilefollow/".$currentuser["user_id"]."/true'><img src='/images/following.png' style='width:20;height:20;' title='following - click to stop'/></a>";
                } else {
            echo "<a href='/users/p_profilefollow/".$currentuser["user_id"]."/true'><img src='/images/follow.png' style='width:20;height:20;' title='Click to follow this boater'/></a>";
                } ?>
            </div>
        <?php } ?>
<?php } else { //This block displays the public option ?>
    <h2>To view other users and to post you must have an account!</h2>
<?php } ?>

