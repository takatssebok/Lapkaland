
<?php 
// connection file
require_once('../add/config.php');

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>

<!-- title -->
<title>Új kategória hozzáadása - Lapkaland</title>
    
<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
            <div class="content">
            <h2>Kategória hozzáadása</h2>

                <?php

                //if form has been submitted process it
                if(isset($_POST['submit'])){

                    $_POST = array_map( 'stripslashes', $_POST );

                    //collect form data
                    extract($_POST);

                    //very basic validation
                    if($categoryName ==''){
                        $error[] = 'Adja meg a kategóriát!';
                    }

                    if(!isset($error)){

                        try {

                            $categorySlug = slug($categoryName);

                            //insert into database
                            $stmt = $db->prepare('INSERT INTO siteCategories (categoryName,categorySlug) VALUES (:categoryName, :categorySlug)') ;
                            $stmt->execute(array(
                                ':categoryName' => $categoryName,
                                ':categorySlug' => $categorySlug
                            ));

                            //redirect to index page
                            header('Location: siteCategories.php?action=hozzáadva');
                            exit;

                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }

                    }

                }

                //check for any errors
                if(isset($error)){
                    foreach($error as $error){
                        echo '<div class="alert alert-danger" style="font-weight:bold;padding-bottom:0px"> <p>'.$error.'</p> </div>';
                    }
                }
                ?>

                <form action="" method="post">
                    <p>
                    <h5><label>Kategória megnevezése</label></h5>
                    <input type='text' name='categoryName' value='<?php if(isset($error)){ echo $_POST['categoryName'];}?>'>
                    </p>
                    <p><button type="submit" class="btn btn-outline-success" value="Submit" name="submit">Hozzáad</button></p>
                    
                </form>
        <!-- closing content div -->
        </div>

        <!-- closing col-sm-9 div -->
        </div>

       
        <!-- sidebar -->
        <?php include("sidebar.php");  ?>
      

    <!-- closing row div -->
    </div>
<!-- closing content-fluid div -->
</div>

<!-- footer</div> -->
<?php include("../footer.php");  ?>