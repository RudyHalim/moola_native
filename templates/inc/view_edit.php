<p>
    <a href="/<?=$config['url']['module']?>">Go back</a>
</p>

<?php
echo "<form method='POST' action='/".$config['url']['module']."' enctype='multipart/form-data'>";
    echo "<table>";

        foreach ($columns as $row => $array_data) {
            if($array_data['COLUMN_KEY'] == 'PRI') {
                echo "<input type='hidden' name='".$array_data['COLUMN_NAME']."' value='".$data[0][$array_data['COLUMN_NAME']]."'>";
            } else {
                echo "<tr>";

                    if($array_data['COLUMN_NAME'] == "passwd") {
                        echo "<th>New Password</th>";
                        $data[0]['passwd'] = '';
                    } else {
                        echo "<th>".ucwords(str_replace("_", " ", $array_data['COLUMN_NAME']))."</th>";
                    }

                    if(strpos($array_data['COLUMN_TYPE'], "enum") !== false) {

                        if(preg_match_all("/'([^']+)'/", $array_data['COLUMN_TYPE'], $m)) {
                            // use array value become its key
                            $cb = array_combine($m[1], $m[1]);
                            $select_options = generateSelectOptions($cb, $data[0][$array_data['COLUMN_NAME']]);
                        }
                        echo "<td><select name='".$array_data['COLUMN_NAME']."'>".$select_options."</select></td>";

                    } else if($array_data['COLUMN_TYPE'] == "text") {
                        echo "<td><textarea name='".$array_data['COLUMN_NAME']."'>".$data[0][$array_data['COLUMN_NAME']]."</textarea></td>";
                    
                    } else if($array_data['COLUMN_NAME'] == "country_id") {
                        echo "<td><select name='".$array_data['COLUMN_NAME']."'>".generateCbCountries($data[0][$array_data['COLUMN_NAME']])."</select></td>";
                    
                    } else if($array_data['COLUMN_NAME'] == "role_id") {
                        echo "<td><select name='".$array_data['COLUMN_NAME']."'>".generateCbRole($data[0][$array_data['COLUMN_NAME']])."</select></td>";

                    } else if(in_array($array_data['COLUMN_NAME'], array('seller_id'))) {
                        echo "<td><select name='".$array_data['COLUMN_NAME']."'>".generateCbUser($data[0][$array_data['COLUMN_NAME']])."</select></td>";
                
                    } else if(strpos($array_data['COLUMN_NAME'], "currency") !== false) {
                        echo "<td><select name='".$array_data['COLUMN_NAME']."'>".generateCbCurrency($data[0][$array_data['COLUMN_NAME']])."</select></td>";
                    
                    } else if($array_data['COLUMN_NAME'] == "display_image") {
                        echo "<td>";

                            if(!empty($data[0][$array_data['COLUMN_NAME']]) && file_exists($data[0][$array_data['COLUMN_NAME']])) {
                                ?>
                                <img src="/<?=$data[0][$array_data['COLUMN_NAME']]?>" /><br />
                                <?php
                            }
                            echo "<input type='file' name='".$array_data['COLUMN_NAME']."'>";

                        echo "</td>";
                    } else if($array_data['COLUMN_NAME'] == "passwd") {
                        echo "<td><input type='password' name='".$array_data['COLUMN_NAME']."' value=''></td>";
                    } else {
                        echo "<td><input type='text' name='".$array_data['COLUMN_NAME']."' value='".$data[0][$array_data['COLUMN_NAME']]."'></td>";
                    }
                    
                echo "</tr>";
            }
        }

        echo "<tr><td></td><td><input type='submit' value='Save' name='frmEdit' /></td></tr>";
    echo "</table>";
    echo "</form>";
?>