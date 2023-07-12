<!-- connection file  -->
<?php require_once('../add/config.php');

//is user logged in? 
if( $user->is_logged_in() ){ header('Location: index.php'); } 
?>

<!-- head -->
<?php include("../head.php");  ?>
    <!-- title -->
    <title>Admin bejelentkezés</title>

    <link rel="stylesheet" href="property/style.css">

</head>

<body>
        <div id="login">

        <?php 

        //Login form for submit 
            if(isset($_POST['submit'])){

                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                
                if($user->login($username,$password)){ 

                    //If looged in, it directs to index page 
                    header('Location: index.php');
                    exit;
                

                } else {
                    $message = '<p class="invalid">Hibás felhasználónév vagy jelszó!</p>';
                }

            }

            if(isset($message)){ echo $message; }
        ?>

        
            <div class="inner-container">
            <form action="" method="POST" class="form" id="login_form">
                <h4><label>Felhasználónév</label></h4>
                <input type="text" name="username" autofocus="autofocus" value=""  required />
            
                <h4><label>Jelszó</label></h4>
                <input type="password" name="password" value="" required />
                <br>
                <input type="submit" class="btn btn-outline-success btn-lg" name="submit" value="Bejelentkezés"  />

            </form>
          
            </div>
      
        </div>
</body>
</html>
