<!-- configuration file -->
<?php require_once('../add/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Felhasználó szerkesztése - Lapkaland</title>
    
<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="content">
        
        <h2>Felhasználó szerkesztése</h2>


            <?php

            //if form has been submitted process it
            if(isset($_POST['submit'])){

                //collect form data
                extract($_POST);

                //very basic validation
                if($username ==''){
                    $error[] = 'Adja meg a felhasználónevet!';
                }

                if( strlen($password) > 0){

                    if($password ==''){
                        $error[] = 'Adja meg a jelszót!';
                    }

                    if($passwordConfirm ==''){
                        $error[] = 'Erősítse meg a jelszót!';
                    }

                    if($password != $passwordConfirm){
                        $error[] = 'A megadott jelszavak nem egyeznek!';
                    }

                }
                

                if($email ==''){
                    $error[] = 'Adja meg az email-címet!';
                }

                if(!isset($error)){

                    try {

                        if(isset($password)){

                            $hashedpassword = $user->create_hash($password);

                            //update into database
                            $stmt = $db->prepare('UPDATE siteUsers SET username = :username, password = :password, email = :email WHERE userId = :userId') ;
                            $stmt->execute(array(
                                ':username' => $username,
                                ':password' => $hashedpassword,
                                ':email' => $email,
                                ':userId' => $userId
                            ));


                        } else {

                            //update database
                            $stmt = $db->prepare('UPDATE siteUsers SET username = :username, email = :email WHERE userId = :userId') ;
                            $stmt->execute(array(
                                ':username' => $username,
                                ':email' => $email,
                                ':userId' => $userId
                            ));

                        }
                        

                        //redirect to users page
                        header('Location: siteUsers.php?action=módosítva');
                        exit;

                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }

                }

            }

            ?>


            <?php
            //check for any errors
            if(isset($error)){
                foreach($error as $error){
                    echo $error.'<br>';
                }
            }

                try {

                    $stmt = $db->prepare('SELECT userId, username, email FROM siteUsers WHERE userId = :userId') ;
                    $stmt->execute(array(':userId' => $_GET['id']));
                    $row = $stmt->fetch(); 

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }

            ?>

            <form action="" method="post">
                <input type="hidden" name="userId" value="<?php echo $row['userId'];?>">

                <p><label>Felhasználónév</label><br>
                <input type="text" name="username" value="<?php echo $row['username'];?>"></p>

                <p><label>Jelszó (változás esetén)</label><br>
                <input type="password" name="password" value=""></p>

                <p><label>Jelszó megerősítése</label><br>
                <input type="password" name="passwordConfirm" value=""></p>

                <p><label>Email</label><br>
                <input type="text" name="email" value="<?php echo $row['email'];?>"></p>

                <p><button type="submit" class="btn btn-outline-success" value="Submit" name="submit">Módosít</button></p>

            </form>
        <!-- closing content div     -->
        </div>
             <!-- closing col-sm-9 div -->
         </div>

       
    <!-- sidebar -->
    <?php include("sidebar.php");  ?>

    <!-- closing row div -->
    </div>
<!-- closing content-fluid div -->
</div>

<!-- footer -->
<?php include("../footer.php");  ?>
