<form id="frmProfile" method="POST">
    <table>
        <tr>
            <th>Is Active</th>
            <td>: <select name="is_active"><?=generateCbYesNo($data[0]['is_active'])?></select></td>
        </tr>
        <tr>
            <th>Email</th>
            <td>: <input type="text" name="email_addr" value="<?=$data[0]['email_addr']?>" /></td>
        </tr>
        <tr>
            <th>Old Password</th>
            <td>: <input type="password" name="password" /></td>
        </tr>
        <tr>
            <th>New Password</th>
            <td>: <input type="password" name="newpassword" /></td>
        </tr>
        <tr>
            <th>Confirm New Password</th>
            <td>: <input type="password" name="newpassword1" /></td>
        </tr>
        <tr>
            <th>First Name</th>
            <td>: <input type="text" name="first_name" value="<?=$data[0]['first_name']?>" /></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>: <input type="text" name="last_name" value="<?=$data[0]['last_name']?>" /></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>: <select name="gender"><?=generateCbGender($data[0]['gender'])?></select></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>: <input type="text" name="phone_no" value="<?=$data[0]['phone_no']?>" /></td>
        </tr>
        <tr>
            <th>Display Image</th>
            <td>: <input type="file" name="display_image" value="<?=$data[0]['display_image']?>" /></td>
        </tr>
        <tr>
            <th>Country</th>
            <td>: <select name="country_id"><?=generateCbCountries($data[0]['country_id'])?></select></td>
        </tr>
        <tr>
            <th>Role</th>
            <td>: <select name="role_id"><?=generateCbRole($data[0]['role_id'])?></select></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="frmProfile" value="Save" /></td>
        </tr>
    </table>
</form>
