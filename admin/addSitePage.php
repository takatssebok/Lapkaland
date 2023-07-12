<!-- connection file -->
<?php require_once('../add/config.php'); 

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>

<!-- title -->
<title>Új oldal hozzáadása - Lapkaland</title>

<!-- include TinyMCE -->
<?php include("TinyMCE.php");  ?>

<!-- header -->
<?php include("header.php"); ?>


<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="content">
 
                <h2>Új oldal hozzáadása</h2>

                <?php

                //if form has been submitted process it
                if(isset($_POST['submit'])){

            

                    //collect form data
                    extract($_POST);

                    //very basic validations
                    if($pageTitle ==''){
                        $error[] = 'Adja meg az oldal címét!';
                    }

                    if($pageContent ==''){
                        $error[] = 'Adja meg az oldal tartalmát!';
                    }

                    if(!isset($error)){

                    try {

                $pageSlug = slug($pageTitle);

            //insert into database
            $stmt = $db->prepare('INSERT INTO sitePages (pageTitle,pageSlug,pageContent) VALUES (:pageTitle, :pageSlug, :pageContent)') ;
            
            $stmt->execute(array(
                ':pageTitle' => $pageTitle,
                ':pageSlug' => $pageSlug,    
                ':pageContent' => $pageContent    
            ));

                //redirect to index page
                header('Location: sitePages.php?action=hozzáadva');
                exit;

            }catch(PDOException $e) {
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
            <form action='' method='post'>
                    <p>
                    <h5><label>Oldal címe</label></h5>
                    <input type='text' name='pageTitle' style="width:100%;height:40px" value='<?php if(isset($error)){ echo $_POST['pageTitle'];}?>'>
                    </p>

                    <p>
                    <h5><label>Tartalom</label></h5>
                    <textarea name='pageContent' id='textarea1' class='mceEditor' cols='120' rows='20' ><?php if(isset($error)){ echo $_POST['pageContent'];}?></textarea>
                    </p>

                    <p> 
                    <button type="submit" class="btn btn-outline-success" value="Submit" name="submit">Oldal hozzáadása</button>
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
