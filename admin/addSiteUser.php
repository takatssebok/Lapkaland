<!-- connection file -->
<?php require_once('../add/config.php');

//loggedin or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Lapkaland</title>

<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="content">        

            <h2>Felhasználó hozzáadása</h2>

            <?php

            //if form has been submitted process it
            if(isset($_POST['submit'])){

                //collect form data
                extract($_POST);

                //very basic validation
                if($username ==''){
                    $error[] = 'Adja meg a felhasználónevet!';
                }

                if($password ==''){
                    $error[] = 'Adja meg a jelszót!';
                }

                if($passwordConfirm ==''){
                    $error[] = 'Erősítse meg a jelszót!';
                }

                if($password != $passwordConfirm){
                    $error[] = 'A megadott jelszavak nem egyeznek!';
                }

                if($email ==''){
                    $error[] = 'Adja meg email-címét!';
                }

                if(!isset($error)){

                    $hashedpassword = $user->create_hash($password);

                    try {

                        //insert into database
                        $stmt = $db->prepare('INSERT INTO siteUsers (username,password,email) VALUES (:username, :password, :email)') ;
                        $stmt->execute(array(
                            ':username' => $username,
                            ':password' => $hashedpassword,
                            ':email' => $email
                        ));

                        //redirect to user page 
                        header('Location: siteUsers.php?action=hozzáadva');
                        exit;

                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }

                }

            }

            //alert in case of errors
            if(isset($error)){
                foreach($error as $error){
                    echo '<div class="alert alert-danger" style="font-weight:bold;padding-bottom:0px"> <p>'.$error.'</p> </div>';
                }
            }
            ?>

            <form action="" method="post">
                <p>
                <h5><label>Felhasználónév</label></h5>
                <input type="text" name="username" value="<?php if(isset($error)){ echo $_POST['username'];}?>">
                </p>
                <p>
                <h5><label>Jelszó</label></h5>
                <input type="password" name="password" value="<?php if(isset($error)){ echo $_POST['password'];}?>">
                </p>
                <p>
                <h5><label>Jelszó megerősítése</label></h5>
                <input type="password" name="passwordConfirm" value="<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>">
                </p>
                <p>
                <h5><label>Email</label></h5>
                <input style="margin-bottom:20px" type="text" name="email" value="<?php if(isset($error)){ echo $_POST['email'];}?>">
                </p>
                <p><button type="submit" class="btn btn-outline-success" value="Submit" name="submit">Felhasználó hozzáadása</button></p>

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
