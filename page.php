<!-- connection file  -->
<?php require('add/config.php'); 

  $stmt = $db->prepare('SELECT pageId,pageTitle,pageSlug,pageContent FROM sitePages WHERE pageSlug = :pageSlug');
  $stmt->execute(array(':pageSlug' => $_GET['pageId']));
  $row = $stmt->fetch();

  // if page does not exists redirect user.
  if($row['pageId'] == ''){
      header('Location: ./');
      exit;
  }
?>

<!-- head -->
<?php include("head.php"); ?>

<!-- title -->
<title><?php echo $row['pageTitle'];?></title>

<!-- header -->
<?php include("header.php"); ?>

<div class="container-fluid">
  <div class="row" style="margin-top: 20px">
    
      <div class="col-sm-9">
      <div class="col-xs-12">
      
      <div class="content">
  
         
          <!-- pagetitle -->
          <?php echo '<h1>'.$row['pageTitle'].'</h1>'; ?>
          <hr> 
          <!-- pagecontent -->
          <?php echo '<p>'.$row['pageContent'].'</p>';?>

      <!-- closing content div -->
      </div>
      <!-- closing col-xs-12 div -->
      </div>
      <!-- closing col-sm-9 div -->
      </div>
    
        <!-- Sidebar -->
        <?php include("sidebar.php");  ?>
       
  <!-- closing row div -->
  </div>
<!-- closing container-fluid div -->
</div>

<!-- footer -->
<?php include("footer.php");  ?>
 