<form id="frmProfile" method="POST">
    <table>
        <tr>
            <th>Email</th>
            <td>: <input type="text" name="email_addr" value="<?=$userData[0]['email_addr']?>" /></td>
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
            <td>: <input type="text" name="first_name" value="<?=$userData[0]['first_name']?>" /></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>: <input type="text" name="last_name" value="<?=$userData[0]['last_name']?>" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="frmProfile" value="Save" /></td>
        </tr>
    </table>
</form>
