<!-- connection file -->
<?php require_once('../add/config.php');

//check login or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }

if(isset($_GET['delpage'])){ 

    $stmt = $db->prepare('DELETE FROM sitePages WHERE pageId = :pageId') ;
    $stmt->execute(array(':pageId' => $_GET['delpage']));

    header('Location: sitePages.php?action=törölve');
    exit;
} 
?>

<!-- head -->
<?php include("../head.php");  ?>
<!-- title -->
<title>Admin oldal </title>
<!-- JavaScript -->
<script language="JavaScript" type="text/javascript">
  
  function delpage(id, title)
  {
      if (confirm("Biztos, hogy törli: '" + title + "'"))
      {
          window.location.href = 'sitePages.php?delpage=' + id;
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
                echo '<div style="margin:10px 0px" class="alert alert-info"><h3>Oldal '.$_GET['action'].'!</h3></div>'; 
            } 
            ?>
            
            <!-- table header -->
            <table class="table table-striped stripe row-border order-column" cellspacing="3" width="100%">
            <thead>
            <tr>
                <th>Oldal címe</th>
                <th>Szerkeszt</th>
                <th>Töröl</th>
            </tr>
            </thead>

            
            <!-- table body -->
            <tbody>
            <?php
                try {

                    $stmt = $db->query('SELECT pageId,pageTitle,pageContent FROM sitePages ORDER BY pageId DESC');
                    while($row = $stmt->fetch()){
                        
                        echo '<tr>';
                        echo '<td>'.$row['pageTitle'].'</td>';
                        
                        ?>

                        <!-- buttons -->
                        <td>
                        <a class="btn btn-outline-primary" role="button"  href="editSitePage.php?pageId=<?php echo $row['pageId'];?>">Szerkeszt</a>
                        </td>
                        <td>
                        <a class="btn btn-outline-danger" role="button" href="javascript:delpage('<?php echo $row['pageId'];?>','<?php echo $row['pageTitle'];?>')">Töröl</a>
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

            <p><a class="btn btn-outline-success btn-lg" role="button" href='addSitePage.php'>Új oldal hozzáadása</a></p>       
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