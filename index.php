<html>
    <head>
        <title>Shouts</title>
    </head>
    <body>
    Hello world from Pradyut Project!<br />
<?php
// A simple web site in Cloud9 that runs through Apache
// Press the 'Run' button on the top to start the web server,
// then click the URL that is emitted to the Output tab of the console
    echo "The time is: " .date("dMYhis") . "<br>";
    echo (getMaximumFileUploadSize() . "<br>");
    $str = "uploads/test_file.txt.jpg";
    
    echo "Sub string: " . substr($str, 0, strripos($str, ".") ) . "<br>";  
    echo "File Extension: " . substr($str,  strripos($str, "."),  strlen($str) - strripos($str, ".") )  . "<br>" ;
    
    if( $_GET["shout"] ) {
        $shout = $_GET["shout"];
        $shout = trim($shout);
        if($shout!='') {
            echo "You shouted: ". $shout. ".<br />";
        }
    }
    include 'settings.php';
    // Create connection
    $db = new mysqli($servername, $username, $password, $database, $dbport);
    // Check connection
    if ($db->connect_error) {
        echo("Connection failed: " . $db->connect_error);
    } else {
        echo "Connected successfully (".$db->host_info.")";
    }
    if( $_POST["shout"] ) {
        $shout = $_POST["shout"];
        $shout = trim($shout);
        if($shout!='') {
            $sql = "INSERT INTO shouts (name, shout) VALUES ('Guest', '". $shout ."')";
            if ($db->query($sql) === TRUE) {
                echo "<br />New record created successfully";
            } else {
                echo "<br />Error: " . $sql . "<br>" . $db->error;
            }
            echo "<br />You shouted: ". $shout. ".<br />";
        }
    }
    
?>
<br />
<a href="https://community.c9.io/t/setting-up-mysql/1718">Starting MySql</a>
<br /><br/>
<div>
    <form action="index.php" method="post">
        <input type="text" name="shout" value="Shout This"/>
        <input type="submit"/>
    </form>
</div>

<div>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" multiple>
    <input type="submit" value="Upload Image" name="submit">
</form>
</div>
Multiple upload:
<div>
    
    <form method="post" action="upload1.php" enctype="multipart/form-data">
            <input type="text" name="shout" value="Shout This"/>
            <input type="file" name="my_file[]" multiple>
            <input type="submit" value="Upload">

<div>
    <table border=1>
<?php
    $sql = "SELECT * from shouts order by shout_id desc";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" .$row[shout_id] . "</td><td> " .$row[shout] . "</td><td>" . 
            date ("D d-M-Y h:i:sa",strtotime ($row[shout_time]))  . "</td></tr>";
        }
    }
    $db->close();
    
    function convertPHPSizeToBytes($sSize)  
{  
    if ( is_numeric( $sSize) ) {
       return $sSize;
    }
    $sSuffix = substr($sSize, -1);  
    $iValue = substr($sSize, 0, -1);  
    switch(strtoupper($sSuffix)){  
    case 'P':  
        $iValue *= 1024;  
    case 'T':  
        $iValue *= 1024;  
    case 'G':  
        $iValue *= 1024;  
    case 'M':  
        $iValue *= 1024;  
    case 'K':  
        $iValue *= 1024;  
        break;  
    }  
    return $iValue;  
}  

function getMaximumFileUploadSize()  
{  
    return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));  
}  

    
?>    
</table>
</div>

</body>
</html>