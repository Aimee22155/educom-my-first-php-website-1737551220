<?php
    session_start();
    require_once "functions.php";
    function showContent() { 

        $name= '';
        $email = '';
        $password = '';
        $repeatpassword = '';
              
        if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
            $name= htmlspecialchars ($_POST['Name']);
            $email = htmlspecialchars ($_POST['Email']);
            $password = htmlspecialchars ($_POST['Password']);
            $repeatpassword = htmlspecialchars ($_POST['Repeatpassword']);

            if (($txtfile = fopen("../users/users.txt", "r")) !== false) {
                while (($data = fgetcsv($txtfile, 1000,"|")) !== false) {
                    if ($email == $data[0]) {
                        fclose($txtfile);

                        echo "email is already being used";
                        echo '<div class="button"><a href="index.php?page=Register">Return</a></div>';
                        exit();
                    }
                }
            }               
            
            if ($password != $repeatpassword) {
                echo "password doesn't match";
                echo '<div class="button"><a href="index.php?page=Register">Return</a></div>';
                exit();
            }    

            $txtfile = fopen("../users/users.txt", "a");
            $teken = "\n";               
            fwrite($txtfile, $teken);

            $teken = "|";               
                fwrite($txtfile, $email);    
                fwrite($txtfile, $teken);
                fwrite($txtfile, $name);
                fwrite($txtfile, $teken);
                fwrite($txtfile, $password);
            fclose($txtfile);

            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;

            require_once "securepage.php";
            return;
            exit();
        }

        echo "              
            <section class='forms'>
            <div>
            <form method='POST' action='index.php?page=Register'>
            Name: <input type='text' name='Name' value='$name' required><br><br>
            Email: <input type='text' name='Email' value='$email' required><br><br>
            Password: <input type='text' name='Password' value='$password' required><br><br>
            Repeatpassword: <input type='text' name='Repeatpassword' value='$repeatpassword' required><br><br>
            <input type='submit' name='thebutton' value='Login!' required><br><br>
            </form>
            </div>
            </section>
            <!-- end content -->             
        ";
    }
?>