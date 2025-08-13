<?php

/*
$myFile = "hw5.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, "");
fclose($fh);*/


if(isset($_POST['field1']) && isset($_POST['field2']) && isset($_POST['field3'])) {
    $data = $_POST['field1'] . '-' . $_POST['field2'] . "\n". $_POST['field3'] ;
    $ret = file_put_contents("hw5.txt", $data, FILE_APPEND | LOCK_EX);
    if($ret === false) {
        die('There was an error writing this file');
    }
    else {
        echo "$ret bytes written to file"."<br>";

        echo "Post has been submitted for approval";
    }
}
else {
   die('no post data to process');
}
?>