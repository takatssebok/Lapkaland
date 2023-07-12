<!-- connection file  -->
<?php require('add/config.php'); 

//statement
$stmt = $db->prepare('SELECT categoryId,categoryName FROM siteCategories WHERE categorySlug = :categorySlug');
$stmt->execute(array(':categorySlug' => $_GET['id']));
$row = $stmt->fetch();

//if category does not exists redirect user.
if($row['categoryId'] == ''){
    header('Location: ../');
    exit;
}
?>

<!-- head -->
<?php include("head.php");  ?>

<!-- title -->
<title><?php echo $row['categoryName'];?> - Lapkaland</title>

<!-- header -->
<?php include("header.php");  ?>

<div class="container-fluid">
  <div class="row">        
        <div class="col-sm-9">
        <div class="col-xs-12">

        <div class="content">

        <p><i><h4>Kategória: <?php echo $row['categoryName'];?></h4></i></p>
                    <hr>
                    
                    <?php
                    
                       
                //Set blog posts limit
                define("PER_PAGE_LIMIT", 5); 
                    
               
                /* PHP Blog Search*/
                $search_query = 
                'SELECT 
                sitePosts.postId, sitePosts.postHeadline, sitePosts.postSlug, sitePosts.postDescription, sitePosts.created_at, sitePosts.postTags 
            FROM 
                sitePosts,
                siteLinkCategories
            WHERE
                sitePosts.postId =  siteLinkCategories.postId
                AND  siteLinkCategories.categoryId = :categoryId
            ORDER BY 
                postId DESC';

                /* PHP Blog Pagination*/
                $per_page_item = '';
                $page = 1;
                $start=0;
                if(!empty($_GET["page"])) {
                    $page = $_GET["page"];
                    $start=($page-1) * PER_PAGE_LIMIT;
                }
                
                $limit=" limit " . $start . "," . PER_PAGE_LIMIT;
                $pagination_stmt = $db->prepare($search_query);
                $pagination_stmt->bindValue(':categoryId',  $row['categoryId'] , PDO::PARAM_STR);
                $pagination_stmt->execute();

                $row_count = $pagination_stmt->rowCount();
                if(!empty($row_count)){
                    $per_page_item .= '<div style="text-align:right;margin:5px 5px;">';
                    $page_count=ceil($row_count/PER_PAGE_LIMIT);
                    if($page_count>1) {
                        for($i=1;$i<=$page_count;$i++){
                            if($i==$page){
                                $per_page_item .= '<a style="margin:5px 5px;" class="btn btn-outline-success btn-lg" role="button"> ' . $i .' </a>';
                            } else {
                                $per_page_item .= '<a style="margin:5px 5px;" class="btn btn-outline-danger btn-lg" role="button" href="http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/'.$_GET['id'].'?page='.$i.'"> ' . $i .' </a>';
                            }
                        }
                    }
                    $per_page_item .= "</div>";
                }
                $query = $search_query.$limit;
                $pdo_stmt = $db->prepare($query);
                $pdo_stmt->bindValue(':categoryId',  $row['categoryId'] , PDO::PARAM_STR);
                $pdo_stmt->execute();
                
            ?>

 <?php
                   
                        while($row = $pdo_stmt->fetch()){
                            
                            echo '<div>';
                                echo '<div style="margin:10px 0px"><h2><a href="../'.$row['postSlug'].'">'.$row['postHeadline'].'</a></h2></div>';
                                // inserting creation date and categories
                                echo '<p><i>Közzétéve</i> '.date('Y.m.d.', strtotime($row['created_at'])).' <i>Kategória:</i> ';

                                    $stmt2 = $db->prepare('SELECT categoryName, categorySlug   FROM siteCategories, siteLinkCategories WHERE siteCategories.categoryId = siteLinkCategories.categoryId AND siteLinkCategories.postId = :postId');
                                    $stmt2->execute(array(':postId' => $row['postId']));

                                    $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                    $links = array();
                                    foreach ($catRow as $cat)
                                    {
                                        $links[] = "<a href='".$cat['categorySlug']."'>".$cat['categoryName']."</a>";
                                    }
                                    echo implode(", ", $links);

                                // inserting tags
                                echo ' <i>Címke:</i> ';                               
                                $links = array();
                                $parts = explode(',', $row['postTags']);
                                foreach ($parts as $tags)
                                {
                                $links[] = "<a href='../tag/".$tags."'>".$tags."</a>";
                                }
                                echo implode(", ", $links);
                                echo '</p>';
                                
                                // inserting post description    
                                echo '<p>'.$row['postDescription'].'</p>';      
                                echo '<p><a class="btn btn-outline-dark" href="../'.$row['postSlug'].'">Tovább olvas</a></p>';   

                            echo '</div>';

                        }                       

                    ?>
                     <?php echo $per_page_item; ?>

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