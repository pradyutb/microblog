<?php
    
    include 'settings.php';
    // Create connection
    $db = new mysqli($servername, $username, $password, $database, $dbport);
    // Check connection
    if ($db->connect_error) {
        echo("Connection failed: " . $db->connect_error);
    } else {
        echo "Connected successfully (".$db->host_info.")";
    }
    
    
    $shout='';
    if( $_POST["shout"] ) {
        $shout = $_POST["shout"];
        $shout = trim($shout);
    }
    
            if (isset($_FILES['my_file'])) {
                $myFile = $_FILES['my_file'];
                $fileCount = count($myFile["name"]);
                $target_dir = "uploads/";
                for ($i = 0; $i < $fileCount; $i++) {
                    ?>
                        <p>File #<?= $i+1 ?>:</p>
                        <p>
                            Name: <?= $myFile["name"][$i] ?><br>
                            <?php 
                            $target_file = $target_dir . basename($myFile["name"][$i]);
                            
                            $file_name = substr($target_file , 0, strripos($target_file, ".") );
                            $extn = substr($target_file,  strripos($target_file, "."),  strlen($target_file) - strripos($target_file, ".") );
                            $file_name = $file_name . "_" . date("dMYhis");
                            $target_file = $file_name . $extn;
                            
                            if (file_exists($target_file)) {
                               echo "Sorry, file already exists.<br>";
                                $uploadOk = 0;
                            }
                            else {
                                if (move_uploaded_file($myFile["tmp_name"][$i], $target_file)) {
                                    echo "The file ". basename( $myFile["name"][$i]). " has been uploaded.<br>";
                                    $shout = $shout . "<br><a href=\"". $target_file . "\">" . basename($myFile["name"][$i]) .  "</a>";
                                }
                            }
                            ?>
                            Temporary file: <?= $myFile["tmp_name"][$i] ?><br>
                            Type: <?= $myFile["type"][$i] ?><br>
                            Size: <?= $myFile["size"][$i] ?><br>
                            Error: <?= $myFile["error"][$i] ?><br>
                        </p>
                    <?php
                }
            }
            
            if($shout!='') {
                $shout = str_replace("'", "''", $shout);
                $sql = "INSERT INTO shouts (name, shout) VALUES ('Guest', '". $shout ."')";
            if ($db->query($sql) === TRUE) {
                echo "<br />New record created successfully";
            } else {
                echo "<br />Error: " . $sql . "<br>" . $db->error;
            }
            echo "<br />You shouted: ". $shout. ".<br />";
            
        }
                
            
        ?>