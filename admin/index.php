<?php 
//include connection file 
require_once('../add/config.php');

//check login or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }

if(isset($_GET['delpost'])){ 

    $stmt = $db->prepare('DELETE FROM sitePosts WHERE postId = :postId') ;
    $stmt->execute(array(':postId' => $_GET['delpost']));

    header('Location: index.php?action=törölve');
    exit;
} 
?>

<?php include("../head.php");  ?>

<title>Admin oldal </title>
  
<script language="JavaScript" type="text/javascript">
    function delpost(id, title)
    {
        if (confirm("Biztos törli: '" + title + "'?"))
        {
            window.location.href = 'index.php?delpost=' + id;
        }
    }
</script>

<!-- Header -->
<?php include("header.php");  ?>

  <div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
            <div class="content" style="margin-top:15px">


                  <?php 
                    //show message from add / edit post page
                    if(isset($_GET['action'])){ 
                        echo '<div style="margin:10px 0px" class="alert alert-info"><h3>Poszt '.$_GET['action'].'!</h3></div>'; 
                    } 
                    ?>

                    <!-- table header -->
                    <table id="tab" class="table table-striped stripe row-border order-column" cellspacing="3" width="100%">
                    <thead>
                    <tr>
                        <th>Cím</th>
                        <th>Publikálás dátuma</th>
                        <th>Aktualizál</th>
                        <th>Töröl</th>
                    </tr>
                    </thead>
                    
                     <!-- table body -->
                    <tbody>
                    <?php
                        try {

                            $stmt = $db->query('SELECT postId, postHeadline, created_at FROM sitePosts ORDER BY postId DESC');
                            while($row = $stmt->fetch())
                            {
                                
                                echo '<tr>';
                                echo '<td>'.$row['postHeadline'].'</td>';
                                echo '<td>'.date('Y.m.d.', strtotime($row['created_at'])).'</td>';
                                ?>

                                <td>
                                    <a class="btn btn-outline-primary" href="editSitePost.php?id=<?php echo $row['postId'];?> "role="button">Szerkeszt </a ></td> <td>
                                    <a class="btn btn-outline-danger" href="javascript:delpost('<?php echo $row['postId'];?>','<?php echo $row['postHeadline'];?>')" role="button">Töröl </a >
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
                    
                    <p><a class="btn btn-outline-success btn-lg" href='addSitePost.php' role="button">Új poszt hozzáadása</a></p>       

                   
            </div>
        </div>

        <!-- Sidebar -->                   
        <?php include("sidebar.php");  ?>
     

        <!-- Closing row div -->    
        </div>
    <!-- Closing container-fluid div in index.php -->
    </div>

<!-- Footer -->
<?php include("../footer.php");  ?>
