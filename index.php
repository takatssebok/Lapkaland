<!-- connection file  -->
<?php require_once('add/config.php'); ?>

<!-- head -->
<?php include("head.php");  ?>
    
<!-- title -->
<title>Lapkaland</title>

<!-- header -->
<?php include("header.php"); ?>

<div class="container-fluid">
    <div class="row">
       
        <div class="col-md-9">
        <div class="col-xs-12">
            <div class="content">
            
            <?php   
                //Set blog posts limit
                define("PER_PAGE_LIMIT", 5); 
        
                $search_query = 'SELECT * FROM  sitePosts ORDER BY postId DESC ';
            
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
                $pagination_stmt->execute();

                $row_count = $pagination_stmt->rowCount();

                if(!empty($row_count)){
                    $per_page_item .= '<div style="text-align:right;margin:5px 5px;">';
                    $page_count=ceil($row_count/PER_PAGE_LIMIT);

                    if($page_count>1) {
                        for($i=1;$i<=$page_count;$i++){
                            if($i==$page){
                                $per_page_item .= '<input style="margin:5px 5px;" type="submit" name="page" value="' . $i . '" class="btn btn-outline-success btn-lg" role="button">';
                            } else {
                                $per_page_item .= '<input style="margin:5px 5px;" type="submit" name="page" value="' . $i . '" class="btn btn-outline-danger btn-lg" role="button">';
                            }
                        }
                    }
                    $per_page_item .= "</div>";
                }

                $query = $search_query.$limit;
                $pdo_stmt = $db->prepare($query);
                $pdo_stmt->execute();
                $result = $pdo_stmt->fetchAll();
            ?>
            
            <!-- Form -->
            <form action="" method="get">
                    <?php
                    if(!empty($result)) { 
                        foreach($result as $row) {
                    ?>
                    
                    <?php
                    //Blog Title 
                    echo '<div style="margin:10px 0px"><h2><a href="'.$row['postSlug'].'">'.$row['postHeadline'].'</a></h2></div>';
                    echo '<hr>';
                    
                    // Blog post Date and Time 
                    echo '<p><i>Közzétéve:</i> '.date('Y.m.d.', strtotime($row['created_at'])).' <i>Kategória:</i> ';
                        $stmt2 = $db->prepare('SELECT categoryName, categorySlug   FROM siteCategories, siteLinkCategories WHERE siteCategories.categoryId = siteLinkCategories.categoryId AND siteLinkCategories.postId = :postId');
                        $stmt2->execute(array(':postId' => $row['postId']));
                        $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        $links = array();
                        foreach ($catRow as $cat){
                            $links[] = "<a href='category/".$cat['categorySlug']."'>".$cat['categoryName']."</a>";
                        }
                        echo implode(", ", $links);
                     
                        echo ' <i>Címke:</i> ';
                        $links = array();
                        $parts = explode(',', $row['postTags']);
                        foreach ($parts as $tags)
                        {
                            $links[] = "<a href='tag/".$tags."'>".$tags."</a>";
                        }
                        echo implode(", ", $links);
                        echo '</p>';
                        echo '<hr>';
                        echo '<p>'.$row['postDescription'].'</p>'; 
                        echo '<p><a class="btn btn-outline-dark" href="' .$base_url .$row['postSlug'].'" role="button">Tovább olvas</a></p>';                     
                    ?>
                
                    <?php
                        }
                    }
                    else{ 
                    echo "Nincs eredmény a következőre: ". $searching;
                    } 
                    ?>
                <table><tbody><tr></tr></tbody></table>
                <?php echo $per_page_item; ?>
            </form>

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


<!-- Footer -->
<?php include("footer.php");  ?> 
