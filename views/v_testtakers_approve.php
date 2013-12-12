<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 12/11/13
 * Time: 7:59 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<h2>Uploaded Test Takers</h2>

<!--List of test takers to follow-->
<form method='POST' id='frmMain' action='/testtakers/p_approve/' >
    <label for="txtPassword">Enter a default password for the new users: </label><input type="text" id="txtPassword" name="txtPassword" value="p@$$w0rd"/>
    <table>
        <thead class="table-header">
            <td>&nbsp;</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Job Title</td>
            <td>Person ID</td>
            <td>Issues</td>
        </thead>
        <tbody>
    <?php
        if ($user_list) {

        foreach($user_list AS $current_user) { ?>
            <tr>
                <td><input type="checkbox" checked="checked" id="chk_<?php echo $current_user['testtaker_staging_row_id']?>" name="chk_<?php echo $current_user['testtaker_staging_row_id']?>" value="<?php echo $current_user['testtaker_staging_row_id']?>"></td>
                <td><?php echo $current_user['first_name']?></td>
                <td><?php echo $current_user['last_name']?></td>
                <td><?php echo $current_user['email']?></td>
                <td><?php echo $current_user['job_title']?></td>
                <td><?php echo $current_user['person_id']?></td>
                <td><?php echo $current_user['issue_text']?></td>
            </tr>
        <?php }} else {echo ("<h3>No test takers exist for this instance</h3>");} ?>
        <tbody>
    </table>

    <input type='submit' value='Approve Checked Test Takers'>
</form>