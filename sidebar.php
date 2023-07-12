<div class="col-sm-3 d-none d-md-block">

<div class="sidebar" style="border: 10px double #fcdcb8; border-radius: 7px">

<ul>    
    <h3>Legutóbbi posztok</h3>
        
        <?php
        $sidebar = $db->query('SELECT postHeadline, postSlug FROM sitePosts ORDER BY postId DESC LIMIT 3');
        while($row = $sidebar->fetch()){
            echo ' <li><a href="'.$base_url.$row['postSlug'].'" >'.$row['postHeadline'].' </a ></li>';
        }
        ?>

    <h3>Kategóriák</h3>

        <?php
        $stmt = $db->query('SELECT categoryName, categorySlug FROM siteCategories ORDER BY categoryId DESC');
        while($row = $stmt->fetch()){
            echo '<li><a href="'.$base_url.'category/'.$row['categorySlug'].' ">'.$row['categoryName'].'</a></li>';
        }
        ?>

    <!-- <h3>Címkék </h3>
        <?php
        $tagsArray = [];
        $stmt = $db->query('select distinct LOWER(postTags) as postTags from sitePosts where postTags != "" group by postTags');
        while($row = $stmt->fetch()){
            $parts = explode(',', $row['postTags']);
            foreach ($parts as $tag) {
                $tagsArray[] = $tag;
            }
        }

        $finalTags = array_unique($tagsArray);
        foreach ($finalTags as $tag) {
            echo "<li><a href='".$base_url." tag/".$tag."'>".ucwords($tag)."</a></li>";
        }    
        ?> -->
</ul>
</div>
</div>