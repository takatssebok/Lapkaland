    
</head>

<body>
<!-- connection file  -->
<?php require_once('add/config.php'); ?>

<div class="container-fluid"  style="margin: 0; padding: 0">
    <!-- navbar -->
    
    <nav class="navbar p-2 navbar-customclass justify-content-center navbar-expand-md navbar-dark">
        <!-- logo with reference to the startpage -->       
            <a href="<?= $base_url ?>" class="navbar-brand">
                <img src="<?= $base_url ?>picture/logos/1-logo-nagykor-L.png" width='160'>
            </a>
       
        <!-- navbar toggler -->
        <button class="navbar-toggler bg-dark" type="button" data-toggle="collapse" data-target="#navbarToggler"  aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarToggler">
        
            <!-- navbar points -->
            <ul class="navbar-nav mr-auto">
                
            <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>">Kezdőlap</a></li>
                <?php
                $pageUrl= $base_url."page/"; 
                        try {

                            $stmt = $db->query('SELECT pageTitle,pageSlug FROM sitePages ORDER BY pageId ASC');
                            while($rowlink = $stmt->fetch()){
                                
                                echo '<li class="nav-item"><a class="nav-link" href="'.$pageUrl.''.$rowlink['pageSlug'].'">'.$rowlink['pageTitle'].'</a></li>';
                            }

                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }
                ?>
            </ul>
            
            <!-- search field -->
            <?php
            $searching="";
            if(!empty($_GET['search']['keyword'])) {
                    $searching = $_GET['search']['keyword'];
            }?>

            <form class="form-inline my-2 my-lg-0" method="get" action="<?= $base_url ?>search.php">
                <input class="form-control mr-sm-2" style="background:#fff" type="search" placeholder="Keresés" name="search[keyword]" value="<?php echo $searching; ?>" id="keyword" maxlength="30">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Keresés</button>
            </form>
        </div>
       
    </nav>         
<!-- end of navbar -->