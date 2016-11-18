<?php
include 'functions.php';
if (check_core_db($core_db_file) == "db_connect") {
    $core_db = connect_sql3_db($core_db_file);
    include 'action_check.php';
    ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>Lan Menu Maker</title>
                <link rel="author" href="humans.txt" />
                <meta charset="UTF-8">
                <meta name="description" content="Menu list of links to Lan URLs">
                <meta name="version" content=".04-github">
                <meta name="keywords" content="HTML,CSS,PHP,SQLite">
                <meta name="author" content="Jay Carter">
                <link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="styles.css">
		<link rel="shortcut icon" href="img/favicon.ico">

	</head>
	<body>
            
           <div id="cssmenu" class="align-center">
             <ul>
                <li><a href="?page=Home"><i class="fa fa-fw fa-home"></i> Home</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-bars"></i> Menus</a>
        <ul>
  	  
                   <?PHP
                   if (isset($_GET['page'])) {
                       $cp = $_GET['page'];
                   } else {
                       $cp = "Home";
                   }
                   ?>

                   <?PHP
                   $menu_result = $core_db->query('SELECT * FROM pages order by sorter');
                   // Loop thru all data from pages table    
                   foreach ($menu_result as $p) {
                       if ($cp == $p['name']) {
                           $span = "<span id='active_ribbon'>";
                       } else {
                           $span = "<span>";
                       }
//                        echo "   <a href='?page=" . $p['name'] . "'>" . $span . $p['name'] . "</span></a>
echo "   <li><a href='?page=" . $p['name'] . "'>" . $p['name'] . "</a></li>
             ";
                   }
?>
</ul>
</li>
  <li><a href='?page=Configure'><i class="fa fa-fw fa-cog"></i>Configure</a></li>
  </ul>
   <?PHP
   echo "</div> ";
                   if (isset($cp) && ($cp == "Home")) {
                       echo "<BR><BR><BR><font color='white'> Welcome Home.</font>";
                   } elseif ($cp == "Configure") {
                       include 'configure.php';
                   } else {
//      echo "Something when wrong, please reload the page.";
                       $iframe_result = $core_db->query("SELECT url FROM pages WHERE name='$cp'");
                       while ($row = $iframe_result->fetch(PDO::FETCH_ASSOC)) {
                           $url = $row['url'];
                           ?><iframe src="<?PHP echo $url; ?>" style="position:fixed; top:30px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:50;">
                               Your browser doesn't support iframes></iframe> <?PHP
           }
       }
                   ?>   

               </body>
                            </html>    
    <?PHP
} else {
    echo "<div class=\"alert\">
  <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
  Houston, we've had a problem here!
</div>";
}