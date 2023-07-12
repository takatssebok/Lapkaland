<!-- connection file -->
<?php require_once('../add/config.php');


if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Kategória szerkesztése - Lapkaland</title>
<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="content">
        <h2>Kategória szerkesztése</h2>


            <?php

            //if form has been submitted process it
            if(isset($_POST['submit'])){

                $_POST = array_map( 'stripslashes', $_POST );

                //collect form data
                extract($_POST);

                //very basic validation
                if($categoryId ==''){
                    $error[] = 'Érvénytelen ID.';
                }

                if($categoryName ==''){
                    $error[] = 'Adja meg a kategória nevét!';
                }

                if(!isset($error)){

                    try {

                        $categorySlug = slug($categoryName);

                        //insert into database
                        $stmt = $db->prepare('UPDATE siteCategories SET categoryName = :categoryName, categorySlug = :categorySlug WHERE categoryId = :categoryId') ;
                        $stmt->execute(array(
                            ':categoryName' => $categoryName,
                            ':categorySlug' => $categorySlug,
                            ':categoryId' => $categoryId
                        ));

                        //redirect to categories page
                        header('Location: siteCategories.php?action=frissítve');
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
                    echo '<div class="alert alert-danger" style="font-weight:bold;padding-bottom:0px"> <p>'.$error.'</p> </div>';
                }
            }

                try {

                    $stmt = $db->prepare('SELECT categoryId, categoryName FROM siteCategories WHERE categoryId = :categoryId') ;
                    $stmt->execute(array(':categoryId' => $_GET['id']));
                    $row = $stmt->fetch(); 

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }

            ?>

            <form action="" method="post">
                <input type='hidden' name='categoryId' value='<?php echo $row['categoryId'];?>'>

                <p>
                    <h5><label>Kategória neve</label></h5>
                    <input type='text' name='categoryName' value='<?php echo $row['categoryName'];?>'>
                </p>
                
                <p>
                    <button type="submit" class="btn btn-outline-success" value="Submit" name="submit">Módosít</button>
                </p>

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
