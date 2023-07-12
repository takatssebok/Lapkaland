<!-- configuration file -->
<?php require_once('../add/config.php'); 
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Oldal szerkesztése - Lapkaland</title>


<!-- include TinyMCE -->
<?php include("TinyMCE.php");  ?>


<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="content">
        
        <h2>Oldal szerkesztése</h2>

            <?php

        
            if(isset($_POST['submit'])){


                //collect form data
                extract($_POST);

                //very basic validation
                if($pageId ==''){
                    $error[] = 'Érvénytelen ID .';
                }

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
            $stmt = $db->prepare('UPDATE sitePages SET pageTitle = :pageTitle, pageSlug = :pageSlug, pageContent = :pageContent WHERE pageId = :pageId') ;
        $stmt->execute(array(
            ':pageTitle' => $pageTitle,
            ':pageSlug' => $pageSlug,
            ':pageContent' => $pageContent,
            ':pageId' => $pageId
        ));

            //redirect to index page
            header('Location: sitePages.php?action=módosítva');
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

                $stmt = $db->prepare('SELECT pageId, pageSlug, pageTitle, pageContent FROM sitePages WHERE pageId = :pageId') ;
                    $stmt->execute(array(':pageId' => $_GET['pageId']));
                    $row = $stmt->fetch(); 

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }

            ?>

            <form action='' method='post'>
                <input type='hidden' name='pageId' value='<?php echo $row['pageId'];?>'>
            <p> 
                <h5><label>Oldal címe</label></h5>
                <input type='text' name='pageTitle' style="width:100%;height:40px" value='<?php echo $row['pageTitle'];?>'>
            </p>   
            <p>           
                <h5><label>Tartalom</label></h5>
                <textarea name='pageContent' id='textarea1' class='mceEditor' cols='120' rows='20'><?php echo $row['pageContent'];?></textarea>
            </p> 
                <button type="submit" class="btn btn-outline-success" value="Submit" name="submit">Módosít</button>
                
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
