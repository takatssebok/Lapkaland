<!-- configuration file -->
<?php require_once('../add/config.php'); 

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Poszt szerkesztése</title>

<!-- include TinyMCE -->
<?php include("TinyMCE.php");  ?>

<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
            <div class="content">
            
                <h2>Poszt szerkesztése</h2>

                <?php

                if(isset($_POST['submit'])){

                    //collect form data
                    extract($_POST);

                    //very basic validations
                    if($postId ==''){
                        $error[] = 'Ennek a posztnak nincs érvényes ID-ja.';
                    }

                    if($postHeadline ==''){
                        $error[] = 'Adja meg a címet!';
                    }

                    if($postDescription==''){
                        $error[] = 'Adja meg a rövid leírást!';
                    }

                    if($postContent ==''){
                        $error[] = 'Adja meg a tartalmat!';
                    }


                    if(!isset($error)){

                    try {



                //insert into database
                $stmt = $db->prepare('UPDATE sitePosts SET postHeadline = :postHeadline, postSlug = :postSlug, postDescription= :postDescription, postContent = :postContent, postTags = :postTags WHERE postId = :postId') ;
                $stmt->execute(array(
                ':postHeadline' => $postHeadline,
                ':postSlug' => $postSlug,
                ':postDescription' => $postDescription,
                ':postContent' => $postContent,
                ':postTags' => $postTags,
                ':postId' => $postId
            ));

                $stmt = $db->prepare('DELETE FROM siteLinkCategories WHERE postId = :postId');
                $stmt->execute(array(':postId' => $postId));

                if(is_array($categoryId)){
                    foreach($_POST['categoryId'] as $categoryId){
                        $stmt = $db->prepare('INSERT INTO siteLinkCategories (postId,categoryId)VALUES(:postId,:categoryId)');
                        $stmt->execute(array(
                            ':postId' => $postId,
                            ':categoryId' => $categoryId
                        ));
                    }
                }

                //redirect to index page
                header('Location: index.php?action=módosítva');
                exit;

            }catch(PDOException $e) {
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

                    $stmt = $db->prepare('SELECT postId, postSlug, postHeadline, postDescription, postContent, postTags FROM sitePosts WHERE postId = :postId') ;
                    $stmt->execute(array(':postId' => $_GET['id']));
                    $row = $stmt->fetch(); 

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }

            ?>

            <form action='' method='post'>
                    <input type='hidden' name='postId' value="<?php echo $row['postId'];?>">

                    <h5><label>Poszt címe</label></h5>
                    <input type='text' name='postHeadline' style="width:100%;height:40px" value="<?php echo $row['postHeadline'];?>">
                    
                    <h5><label>Poszt slug (manuálisan módosítható)</label></h5>
                    <input type='text' name='postSlug' style="width:100%;height:40px" value='<?php echo $row['postSlug'];?>'>

                    <h5><label>Rövid leírás </label></h5>
                    <textarea name='postDescription' style="display:block;width:100%;height:20vh"><?php echo $row['postDescription'];?></textarea>

                    <h5><label>Tartalom</label></h5>
                    <textarea name='postContent' id='textarea1' cols='120' rows='30'><?php echo $row['postContent'];?></textarea>
                    

                    <fieldset>
                        <h5><legend>Kategóriák</legend></h5>

                        <?php
                        $checked = null;
                        $stmt2 = $db->query('SELECT categoryId, categoryName FROM siteCategories ORDER BY categoryName');
                        while($row2 = $stmt2->fetch()){

                            $stmt3 = $db->prepare('SELECT categoryId FROM siteLinkCategories WHERE categoryId = :categoryId AND postId = :postId') ;
                            $stmt3->execute(array(':categoryId' => $row2['categoryId'], ':postId' => $row['postId']));
                            $row3 = $stmt3->fetch(); 

                            if($row3['categoryId'] == $row2['categoryId']){
                                $checked = 'checked=checked';
                            } else {
                                $checked = null;
                            }

                            echo "<input type='checkbox' name='categoryId[]' value='".$row2['categoryId']."' $checked> ".$row2['categoryName']."<br />";
                        }

                        ?>
                
                     </fieldset>
                <p> 
                <h5><label>Poszt címkék (Szóköz nélkül, vesszővel tagoljuk!)</label></h5>
                <input type='text' name='postTags' style="width:100%;height:40px;"value='<?php echo $row['postTags'];?>'>
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
