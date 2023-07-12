<!-- connection file  -->
<?php require('add/config.php');

//statement
$stmt = $db->prepare('SELECT postId, postDescription, postSlug, postHeadline, postContent, postTags, created_at FROM sitePosts WHERE postSlug = :postSlug');
$stmt->execute(array(':postSlug' => $_GET['id']));
$row = $stmt->fetch();
$postIdc=$row['postId'];

//if post does not exists redirect user.
if($row['postId'] == ''){
    header('Location: ./');
    exit;
}
?>

<!-- head -->
<?php include("head.php");  ?>

<!-- title -->
<title><?php echo $row['postHeadline'];?> - Lapkaland</title>
  <meta name="description" content="<?php echo $row['postDescription'];?>">
  <meta name="keywords" content="<?php echo $row['postTags'];?>">

<!-- header -->
<?php include("header.php"); ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-9">
        <div class="col-xs-12">
            <div class="content">

                <?php
                    echo '<div>';
                        echo '<h1>'.$row['postHeadline'].'</h1>';

                        echo '<p><i>Közzétéve:</i> '.date('Y.m.d.', strtotime($row['created_at'])).' <i>Kategória:</i> ';

                        $stmt2 = $db->prepare('SELECT categoryName, categorySlug   FROM siteCategories, siteLinkCategories WHERE siteCategories.categoryId = siteLinkCategories.categoryId AND siteLinkCategories.postId = :postId');
                        $stmt2->execute(array(':postId' => $row['postId']));

                        $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        $links = array();
                        foreach ($catRow as $cat){
                            $links[] = "<a href='category/".$cat['categorySlug']."'>".$cat['categoryName']."</a>";
                        }
                        echo implode(", ", $links);

                        echo '</p>';
                        echo '<hr>';

                        echo '<p><i>Címke:</i> ';
                        $links = array();
                        $parts = explode(',', $row['postTags']);
                        foreach ($parts as $tags)
                        {
                        $links[] = "<a href='tag/".$tags."'>".$tags."</a>";
                        }
                        echo implode(", ", $links);
                        echo '</p>';

                        echo '<p>'.$row['postContent'].'</p>';

                    echo '</div>';
                ?>
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
<!-- closing content-fluid div  -->
</div>

<?php
$baseUrl=$base_url;
 $slug=$row['postSlug'];
?>

<!-- disqus comments  -->

<div id="disqus_thread"></div>
<script>
    /**
    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://lapkaland.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>


<h3>Ajánlott újabb posztok:</h3>

<?php
// run query//select by current id and display the next 3 blog posts
$recom= $db->query("SELECT * from sitePosts where postId > $postIdc order by postId ASC limit 3");

// look through query
       while($row1 = $recom->fetch()){
         echo '<p><a href="'.$row1['postSlug'].'">'.$row1['postHeadline'].'</a></p>';

}
?>

<h3> Korábbi posztok:</h3>
<?php

// run query//select by current id and display the previous 3 posts

$previous= $db->query("SELECT * from sitePosts where postId<$postIdc order by postId DESC limit 3");

// look through query
       while($row1 = $previous->fetch()){
         echo '<p><a href="'.$row1['postSlug'].'">'.$row1['postHeadline'].'</a></p>';

}
?>

<!-- footer -->
<?php include("footer.php");  ?>