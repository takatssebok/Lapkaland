<!-- connection file  -->
<?php require_once('add/config.php'); ?>

<!-- head -->
<?php include("head.php");  ?>
    
<!-- title -->
<title>Lapkaland - Keresés</title>

<!-- header -->
<?php include("header.php"); ?>

<div class="container-fluid">
    <div class="row">
       
    <div class="col-sm-9">
      <div class="col-xs-12">
            <div class="content">
            
            <?php   
                //Set blog posts limit
                define("PER_PAGE_LIMIT", 5); 
                    
                $searching = '';
                if(!empty($_GET['search']['keyword'])) {
                    $searching = $_GET['search']['keyword'];
                }
                /* PHP Blog Search*/
                $search_query = 'SELECT * FROM  sitePosts WHERE postHeadline LIKE :keyword OR postDescription LIKE :keyword OR postTags LIKE :keyword OR postContent LIKE :keyword ORDER BY postId DESC ';
            
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
                $pagination_stmt->bindValue(':keyword', '%' . $searching . '%', PDO::PARAM_STR);
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
                                $per_page_item .= '<a style="margin:5px 5px;" class="btn btn-outline-danger btn-lg" role="button" href="search.php?page='.$i.($searching?"&search[keyword]=".$searching:"").'"> ' . $i .' </a>';
                            }
                        }
                    }
                    $per_page_item .= "</div>";
                }
                $query = $search_query.$limit;
                $pdo_stmt = $db->prepare($query);
                $pdo_stmt->bindValue(':keyword', '%' . $searching . '%', PDO::PARAM_STR);
                $pdo_stmt->execute();
                $result = $pdo_stmt->fetchAll();
            ?>

<!-- form -->

            <form>

                    <?php 
                    if(!empty($_GET['search']['keyword'])) {
                            $searching = $_GET['search']['keyword'];
                    }?>
                
                    <?php
                    if(!empty($result)) { 
                        echo "<p><i><h4>A keresett kifejezés: ". $searching ."</h4></i></p> <hr>";
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
                        echo '<p><a class="btn btn-outline-dark" href="../Lapkaland/'.$row['postSlug'].'" role="button">Tovább olvas</a></p>';                     
                    ?>
                
                    <?php
                        }
                    }
                    else{ 
                    echo "<p><i><h4>Nincs eredmény a következőre: ". $searching . "</h4></i></p> <hr>";
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
