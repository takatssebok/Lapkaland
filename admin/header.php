<link href="../property/style.css" rel="stylesheet" type="text/css">
<link href="property/style.css" rel="stylesheet" type="text/css">
<link href="property/css_minimal.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
        $(document).ready( function () {
        $('#tab').DataTable();
        } ); 
</script>


</head>

<body>
<div class="container-fluid"  style="margin: 0; padding: 0">
    <nav class="navbar navbar-customclass justify-content-center navbar-expand-md navbar-dark">
    
    <!-- logo with reference to the startpage -->       
        <a href="<?= $base_url ?>admin" class="navbar-brand">
            <img src="<?= $base_url ?>picture/logos/1-logo-nagykor-L.png" width='160'>
        </a>
   
    <!-- navbar toggler -->
    <button class="navbar-toggler bg-dark" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarToggler">
        <!-- navbar points -->
        <ul class="navbar-nav mr-auto">
                             
            <li class="nav-item"><a class="nav-link" href='index.php'>Posztok</a></li>
            <li class="nav-item"><a class="nav-link" href="siteCategories.php">Kategóriák</a></li> 
            <li class="nav-item"><a class="nav-link" href='sitePages.php'>Oldalak</a> </li>
            <li class="nav-item"><a class="nav-link" href='siteUsers.php'>Felhasználók</a></li>
            <li class="nav-item"><a class="nav-link" href="../" target="_blank">Blog </a></li>
            <li class="nav-item"><a class="nav-link" href='logout.php'><font color="red">Kijelentkezés</font></a></li>
        </ul>

       </div>
   
   </nav>         
   <!-- end of navbar -->
