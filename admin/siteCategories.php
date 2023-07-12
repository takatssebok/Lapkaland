<!-- configuration file -->
<?php require_once('../add/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delcat'])){ 

    $stmt = $db->prepare('DELETE FROM siteCategories WHERE categoryId = :categoryId') ;
    $stmt->execute(array(':categoryId' => $_GET['delcat']));

    header('Location: siteCategories.php?action=törölve');
    exit;
} 
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Kategóriák - Lapkaland</title>

<script language="JavaScript" type="text/javascript">
  function delcat(id, title)
  {
      if (confirm("Biztos, hogy törli: '" + title + "'"))
      {
          window.location.href = 'siteCategories.php?delcat=' + id;
      }
  }
  </script>

<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="content" style="margin-top: 15px">
        <?php 
            //show message from add / edit page
            if(isset($_GET['action'])){ 
                echo '<div style="margin:10px 0px" class="alert alert-info"><h3>Kategória '.$_GET['action'].'!</h3></div>'; 
            } 
            ?>
            
            <table id="tab" style="margin-top:50px" class="table table-striped stripe row-border order-column" cellspacing="3" width="100%">
            <!-- table header -->
            <thead>
            <tr>
                <th>Cím</th>
                <th>Művelet</th>
            </tr>
            </thead>

            <!-- table body -->
            <tbody>
            <?php
                try {

                    $stmt = $db->query('SELECT categoryId, categoryName, categorySlug FROM siteCategories ORDER BY categoryName DESC');
                    while($row = $stmt->fetch()){
                        
                        echo '<tr>';
                        echo '<td>'.$row['categoryName'].'</td>';
            ?>
                        
                        <!-- buttons -->
                        <td>
                            <a class="btn btn-outline-primary" role="button" href="editSiteCategory.php?id=<?php echo $row['categoryId'];?>">Szerkeszt</a> 
                            <a class="btn btn-outline-danger" role="button" href="javascript:delcat('<?php echo $row['categoryId'];?>','<?php echo $row['categoryName'];?>')">Töröl</a>
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

            <p><a class="btn btn-outline-success btn-lg" role="button" href='addSiteCategory.php'>Új kategória létrehozása</a></p>
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