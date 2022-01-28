<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="helloWorld.php" method="POST">
        Name: <input type="text" id="fnamePost" name="fname">
        Race: <input type="text" id="racePost" name="race">
        <input type="submit" value="POST">
    </form><br><br>
    <form action="helloWorld.php" method="GET">
        Name: <input type="text" id="fnameGet" name="fname">
        Race: <input type="text" id="raceGet" name="race">
        id: <input type="text" id="touhou_idGet" name="tid">
        <input type="submit" value="GET">
    </form><br><br>
    <form action="helloWorld.php" method="GET">
        Name: <input type="text" id="fnamePut" name="fname">
        Race: <input type="text" id="racePut" name="race">
        id: <input type="text" id="touhou_idPut" name="tidp">
        <input type="submit" value="PUT">
    </form><br><br>
    <?php
        $servername = "localhost";
        $username = "jdbuenol";
        $password = "123";
        $dbname = "touhou";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        else{
            echo "Connected Succesfully<br>";
            if(count($_POST) > 0){
                $sql_query = "INSERT INTO touhou(name, race) VALUES ('{$_POST["fname"]}','{$_POST["race"]}')";
                echo $sql_query;
                $conn->query($sql_query);
                echo "SUBMITED INFO<br>";
            }
            elseif($_GET['tidp']){
                $tid = $_GET["tidp"];
                $fname = $_GET["fname"];
                $race = $_GET["race"];
                $sql_query = "UPDATE touhou SET ";
                if($fname != "" && $race != "") $sql_query .= "name='{$fname}', race='{$race}' WHERE id={$tid};";
                elseif($fname != "") $sql_query .= "name='{$fname}' WHERE id={$tid};";
                elseif($race != "") $sql_query .= "race='{$race}' WHERE id={$tid};";
                echo $sql_query;
                $conn->query($sql_query);   
            }
            elseif(count($_GET) > 0){
                $get_id = $_GET["tid"];
                $fname = $_GET["fname"];
                $race = $_GET["race"];
                $and = FALSE;
                $sql_query = "SELECT * FROM touhou";
                if($get_id != ""){
                    $sql_query .= " WHERE id={$get_id}";
                    $and = TRUE;
                }
                if($fname != ""){
                    if($and) $sql_query .= " and name='{$fname}'";
                    else{
                        $sql_query .= " WHERE name='{$fname}'";
                        $and = TRUE;
                    }
                }
                if($race != ""){
                    if($and) $sql_query .= " and race='{$race}'";
                    else $sql_query .= " WHERE race='{$race}'";
                }
                $sql_query .= ";";
                echo $sql_query.'<br>';
                $result = $conn->query($sql_query);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                    echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Race: " . $row["race"]. "<br>";
                    }
                } else {
                    echo "0 results";
                }
            }
        }
    ?>
    <br>
    <img src="/flandre.webp" alt="">
</body>
</html>