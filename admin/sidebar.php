
<div class="col-sm-3 d-none d-md-block"> 
<div class="sidebar" style="border: 10px double #fcdcb8; border-radius: 7px">
    <h3>Menüpontok</h3>
    <ul>
        <li><a href="index.php">Posztok áttekintése </a></li>
        <li><a href="addSitePost.php">Új blog poszt hozzáadása </a></li>
        <li><a href="siteCategories.php">Kategóriák </a></li>
        <li><a href="addSiteCategory.php">Új kategória hozzáadása </a></li>
        <li><a href="siteUsers.php">Felhasználók </a></li>
        <li><a href="addSiteUser.php">Új felhasználó hozzáadása  </a></li>
        <li><a href="sitePages.php">Oldalak </a></li>
        <li><a href="addSitePage.php">Új oldal hozzáadása </a>     </li>
        <li><a target="_blank" href="../">Blog főoldal </a></li>
    </ul>
    
    <?php 
    $sql = $db->query('select count(*) from sitePosts')->fetchColumn(); 
    echo'<h3>Összes poszt: '.'<font color="red">'.$sql.'</font>'.'</h3>' ;
    ?>


</div>
</div>
