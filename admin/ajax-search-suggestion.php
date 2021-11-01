<?php

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

if(isset($_POST['search_str']))
{
    $search_str = $_POST['search_str'];
	
    $result = mysqli_query($link, "SELECT id, speaker_name, position FROM speakers WHERE speaker_name like '$search_str%' LIMIT 10");
    
    if(!$result)
	{
		echo $sww;
	}
	else
    {
        echo '<div class="panel panel-info panel-border top mt10" style="margin-bottom: 0">
        <div class="panel-body">
            <ul class="fa-ul" style="margin-bottom:0">';
		
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                echo '<li><a onclick="sc_select(\''.$row['id'].'\', \''.addslashes($row['speaker_name']).' - '.addslashes($row['position']).'\')" ><i class="fa-li fa fa-check-square"></i> '.$row['speaker_name'].' - '.$row['position'].'</a></li>';
            }
        }
        else
        {
            echo '<li>No records found</li>';
        }
		
        echo '</ul>
            </div>
        </div>';
    }
}
else
{
    echo '1'.$sww;
}