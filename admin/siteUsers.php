<!-- connection file -->
<?php require_once('../add/config.php');

//check logged in or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }

// add / edit page
if(isset($_GET['deluser'])){ 

  
  if($_GET['deluser'] !='1'){

    $stmt = $db->prepare('DELETE FROM siteUsers WHERE userId = :userId') ;
    $stmt->execute(array(':userId' => $_GET['deluser']));

    header('Location: siteUsers.php?action=törölve');
    exit;

  }
} 
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Felhasználók - Lapkaland</title>

<!-- JavaScript -->
<script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
    if (confirm("Biztos benne, hogy törli: '" + title + "'"))
    {
      window.location.href = 'siteUsers.php?deluser=' + id;
    }
  }
</script>

<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
      
    <div class="content">
    <?php 
      //show message from add / edit page
      if(isset($_GET['action'])){ 
        echo '<div style="margin:10px 0px" class="alert alert-info"><h3>Felhasználó '.$_GET['action'].'!</h3></div>'; 
      } 
      ?>

      
      <!-- table header -->
      <table class="table table-striped stripe row-border order-column" cellspacing="3" width="100%">
      <thead>
      <tr>
        <th>Felhasználónév </th>
        <th>Email </th>
        <th>Szerkeszt </th>
        <th>Töröl </th>
      </tr>
      </thead>

      <!-- table body -->
      <tbody>
      <?php
        try {

          $stmt = $db->query('SELECT userId, username, email FROM siteUsers ORDER BY userId');
          while($row = $stmt->fetch()){
            
            echo ' <tr>';
            echo ' <td>'.$row['username'].' </td>';
            echo ' <td>'.$row['email'].' </td>';
            ?>

            <!-- buttons -->
            <td>
              <a class="btn btn-outline-primary" role="button" href="editSiteUser.php?id=<?php echo $row['userId'];?>">Szerkeszt</a>
              <?php if($row['userId'] != 1){?>
            </td>

            <td>
              <a class="btn btn-outline-danger" role="button" href="javascript:deluser('<?php echo $row['userId'];?>','<?php echo $row['username'];?>')">Töröl</a>
              <?php } 
              ?>
            </td>
            
            <?php 
            echo '</tr>';

          }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
      ?>
      </tbody>
      </table>

      <p><a class="btn btn-outline-success btn-lg" role="button" href='addSiteUser.php'>Felhasználó hozzáadása</a></p>
        <!-- closing content div -->
        </div>
     <!-- closing col-sm-9 div -->
     </div>

       
    <!-- sidebar -->
    <?php include("sidebar.php");  ?>


    <!-- Closing row div -->    
    </div>
<!-- Closing container-fluid div in index.php -->
</div>

<!-- Footer -->
<?php include("../footer.php");  ?>