<?php
if(isset($config['url']['action']) && $config['url']['action'] == 'search') {
    ?><p><a href="/<?=$config['url']['module']?>">Go back</a></p><?php
} else {
    ?><p><a href="/<?=$config['url']['module']?>/add">Add new</a></p><?php
}
if(sizeof($data) > 0) {

    if(!isset($data[0])) {
        reset($data);
    }

    echo "Total Found ".$pagination->totalRows." record(s)";

    echo "<form method='POST' action='/".$config['url']['module']."/search'>";
    echo "<table>";
        echo "<tr>";
            foreach ($data[0] as $column_name => $array_data) {  // generate filter textbox
                $default_value = isset($_SESSION['filterCond'][$column_name]) ? $_SESSION['filterCond'][$column_name] : "";
                echo "<td><input type='text' class='txtfilter' name='".$column_name."' value='".$default_value."' /></td>";
            }
            echo "<td colspan='2'><input type='submit' name='frmFilter' value='search'></td>";
        echo "</tr>";
        echo "<tr>";
            foreach ($data[0] as $column_name => $array_data) {  // generate column name
                echo "<th class='center'>".ucwords(str_replace("_", " ", $column_name))."</th>";
            }
        echo "</tr>";

        foreach ($data as $row => $array_data) {
            echo "<tr>";
                foreach ($array_data as $key => $value) {
                    echo "<td class='center'>".$value."</td>";
                }
                echo "<td class='center'><a href='/".$config['url']['module']."/edit/".current($array_data)."'>Edit</a></td>";
                echo "<td class='center'><a href='/".$config['url']['module']."/delete/".current($array_data)."' onclick='return confirm(\"Are you sure want to delete this data?\");'>Delete</a></td>";
            echo "</tr>";
        }

        echo "<tr><td colspan='99' align='center'>";
        include($config['application']['includesDir']."view_paging.php");
        echo "</td></tr>";

    echo "</table>";
    echo "</form>";

} else {
    ?>
    <h3>No match data</h3>
    <?php
}