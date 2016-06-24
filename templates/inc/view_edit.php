<p>
    <a href="/<?=$config['url']['module']?>">Go back</a>
</p>

<?php
echo "<form method='POST' action='/".$config['url']['module']."'>";
    echo "<table>";

        foreach ($columns as $row => $array_data) {
            echo "<tr>";
                echo "<th>".ucwords(str_replace("_", " ", $array_data['COLUMN_NAME']))."</th>";

                if(strpos($array_data['COLUMN_TYPE'], "enum") !== false) {

                    if(preg_match_all("/'([^']+)'/", $array_data['COLUMN_TYPE'], $m)) {
                        // use array value become its key
                        $cb = array_combine($m[1], $m[1]);
                        $select_options = generateSelectOptions($cb, $data[0][$array_data['COLUMN_NAME']]);
                    }
                    echo "<td><select name='".$array_data['COLUMN_NAME']."'>".$select_options."</select></td>";

                } else {
                    echo "<td><input type='text' name='".$array_data['COLUMN_NAME']."' value='".$data[0][$array_data['COLUMN_NAME']]."'></td>";
                }
            echo "</tr>";
        }

        echo "<tr><td></td><td><input type='submit' value='Save' name='frmAdd' /></td></tr>";
    echo "</table>";
    echo "</form>";
?>