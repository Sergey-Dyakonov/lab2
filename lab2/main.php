<?php
    session_start();
    if(!isset($_SESSION['auth']))$_SESSION['auth']=false;
    if(!isset($_SESSION['role']))$_SESSION['role']=NULL;
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="assets/css/table.css">
<link rel="stylesheet" href="assets/css/button.css">
<link rel="stylesheet" href="assets/css/logo.css">
<link rel="stylesheet" href="assets/css/modal.css">
<link rel="stylesheet" href="assets/css/main.css">
</head>
<html>
    <body>
    <h1>Home page</h1>
        <?php
            if($_SESSION['auth']) echo '<h2 id="prsnl" onclick="send('.$_SESSION['id'].',\'personal.php\')">'.$_SESSION['firstname'].' | <a href="sign_out.php">Sign out</a></h2>';
            else echo "<h2><span id='show'>Sign in</span> | <a href='registration.php'>Sign up</a></h2>";
        ?>
            <div id="prompt-form-container">
                <form id="prompt-form" method="post" action="auth.php">
                    <span id="exit">&#10006</span>
                    <input type="text" name="text" required placeholder="Email" class="insert"><br>
                    <input type="password" name="password" required placeholder="Password" class="insert"><br>
                    <input type="submit" class="button" value="Sign in">
                </form>
            </div>
        <a href="main.php"><img src="assets/img/logo.png" alt="LOGO" id="logo"></a>
        <div id="logo-text">Butterfly team</div>
        <table>
            <tr>
                <th>#</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Role</th> 
            </tr>
            <?php
            require_once 'connection.php';
            $res = mysqli_query ($conn, "SELECT * FROM users u JOIN roles r ON r.id=u.role_id");
            if($res){
                $rows=mysqli_num_rows($res);
                for ($i = 0 ; $i < $rows ; ++$i){
                    $row = mysqli_fetch_row($res);
                    if(is_array($row)){
                        echo "<tr>";
                        echo "<td class='redirect' onclick='send(".$row[0].",\"personal.php\")'>".$row[0]."</td>";
                        for($i=1; $i<3; $i++ ){
                            echo "<td>".$row[$i]."</td>";
                        }
                        echo "
                        <td>".$row[6]."</td>
                        <td>".$row[8]."</td>
                        ";
                        echo "</tr>";
                    } 
                }
            } else echo "<tr>Impossible to get data from database</tr>";
            if($_SESSION['role']=="Admin") echo "<a href='registration.php'><button class='button' id='add_b'>Add user</button></a>";
            ?>
        </table>
        <script src="assets/js/send.js"></script>
        <script src="assets/js/modal.js"></script>
    </body>
</html>