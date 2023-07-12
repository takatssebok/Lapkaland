<!-- configuration file -->
<?php require_once('../add/config.php'); 

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!-- head -->
<?php include("../head.php");  ?>

<!-- title  -->
<title>Új poszt - Lapkaland</title>

<!-- include TinyMCE -->
<?php include("TinyMCE.php");  ?>

<!-- header -->
  <?php include("header.php");?>

  <div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="content">
        
            <h1>Új poszt hozzáadása</h1>

            <?php

            //if form has been submitted process it
            if(isset($_POST['submit'])){ 

                //collect form data
                extract($_POST);

                //very basic validations
                
                if($postHeadline ==''){            
                    $error[] = 'Adja meg a címet!';           
                }

                if($postDescription ==''){           
                    $error[] = 'Adja meg a rövid leírást!';         
                }

                if($postContent ==''){           
                    $error[] = 'Adja meg a tartalmat!';           
                }
                
                
                if(!isset($error)){

                try {


                    $postSlug = slug($postHeadline);

                    //insert into database
                    $stmt = $db->prepare('INSERT INTO sitePosts (postHeadline,postSlug,postDescription,postContent,created_at,postTags) VALUES (:postHeadline, :postSlug, :postDescription, :postContent, :created_at, :postTags)') ;
        
                    $stmt->execute(array(
                        ':postHeadline' => $postHeadline,
                        ':postSlug' => $postSlug,
                        ':postDescription' => $postDescription,
                        ':postContent' => $postContent,
                        ':created_at' => date('Y-m-d H:i:s'),
                        ':postTags' => $postTags
                    ));
                
                

            //add categories 

            $postId = $db->lastInsertId();
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
            header('Location: index.php?action=hozzáadva');
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
        <form action="" method="post">

                <h5><label>A poszt címe</label></h5>
                <input type="text" name="postHeadline" style="width:100%;height:40px" value="<?php if(isset($error)){ echo $_POST['postHeadline'];}?>">

                <h5><label>Rövid leírás </label></h5>
                <textarea name="postDescription" style="display:block;width:100%;height:20vh" ><?php if(isset($error)){ echo $_POST['postDescription'];}?></textarea>

                <h5><label>Tartalom</label></h5>
                <textarea name="postContent" id="textarea1" cols="120" rows='30'><?php if(isset($error)){ echo $_POST['postContent'];}?></textarea>
                
                <fieldset>
                <h5><legend>Kategóriák</legend></h5>      

                    <?php    
                    $checked = null;
                    $stmt2 = $db->query('SELECT categoryId, categoryName FROM siteCategories ORDER BY categoryName');

                    while($row2 = $stmt2->fetch()){

                        if(isset($_POST['categoryId'])){

                            if(in_array($row2['categoryId'], $_POST['categoryId'])){
                            $checked="checked='checked'";
                            }else{
                            

                            }
                        }

                    echo "<input type='checkbox' name='categoryId[]' value='".$row2['categoryId']."' $checked> ".$row2['categoryName']."<br />";
                        }

                    ?>
                
                </fieldset>

                <h5><label>Poszt címkék (Szóköz nélkül, vesszővel tagoljuk!)</label></h5>
                <input type='text' name='postTags' value='<?php if(isset($error)){ echo $_POST['postTags'];}?>' style="width:100%;height:40px">

                <button type="submit" class="btn btn-outline-success" value="Submit" name="submit">Poszt hozzáadása</button>

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
