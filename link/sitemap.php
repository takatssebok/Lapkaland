<?php 
//sitemap.php to sitemap.xml using .htaccess file 
require_once('../add/config.php');

$pages = $db->query('SELECT pageSlug FROM sitePages ORDER BY pageId ASC');
$post = $db->query('SELECT postSlug FROM sitePosts ORDER BY postId ASC');
$category = $db->query('SELECT categorySlug FROM siteCategories ORDER BY categoryId ASC');
$tag= $db->query('SELECT postTags FROM sitePosts ORDER BY postId ASC');
               

//Page base URL 
$page_base_url = $base_url."page/";
//Category base URL
$category_base_url = $base_url. "category/";
//tag base URL
$tag_base_url = $base_url. "tag/";


header("Content-Type: application/xml; charset=utf-8");

echo '<!--?xml version="1.0" encoding="UTF-8"?-->'.PHP_EOL; 

echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
echo '<url>' . PHP_EOL;
 echo '<loc>'.$base_url.'</loc>' . PHP_EOL;
 echo '<changefreq>daily</changefreq>' . PHP_EOL;
 echo '</url>' . PHP_EOL;


while($row = $pages->fetch()){

 echo '<url>' . PHP_EOL;
 echo '<loc>'.$page_base_url. $row["pageSlug"] .'</loc>' . PHP_EOL;
 echo '<changefreq>daily</changefreq>' . PHP_EOL;
 echo '</url>' . PHP_EOL;
}


 while($row = $post->fetch()){

 echo '<url>' . PHP_EOL;
 echo '<loc>'.$base_url. $row["postSlug"] .'</loc>' . PHP_EOL;
 echo '<changefreq>daily</changefreq>' . PHP_EOL;
 echo '</url>' . PHP_EOL;
}
while($row = $category->fetch()){

 echo '<url>' . PHP_EOL;
 echo '<loc>'.$category_base_url. $row["categorySlug"] .'</loc>' . PHP_EOL;
 echo '<changefreq>daily</changefreq>' . PHP_EOL;
 echo '</url>' . PHP_EOL;
}
while($row = $tag->fetch()){

 echo '<url>' . PHP_EOL;
 echo '<loc>'.$tag_base_url. $row["postTags"] .'</loc>' . PHP_EOL;
 echo '<changefreq>daily</changefreq>' . PHP_EOL;
 echo '</url>' . PHP_EOL;
}



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
        
        echo '<url>' . PHP_EOL;
 echo '<loc>'.$tag_base_url.$tag.'</loc>' . PHP_EOL;
 echo '<changefreq>daily</changefreq>' . PHP_EOL;
 echo '</url>' . PHP_EOL;
    }

echo '</urlset>' . PHP_EOL;

?>