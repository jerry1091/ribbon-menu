<style>
    body {background-color: gainsboro;}
    h1 {color:crimson ;
    margin-left: 20px;
}
.center {
    margin: auto;
    width: 50%;
    border: 3px solid black;
    padding: 10px;
}
                        /* The alert message box */
                        .alert {
                            position:absolute;
 top:0px;
                            padding: 20px;
                            background-color: #f44336; /* Red */
                            color: white;
                            margin-bottom: 15px;
                        }

                        /* The close button */
                        .closebtn {
                            margin-left: 15px;
                            color: white;
                            font-weight: bold;
                            float: right;
                            font-size: 22px;
                            line-height: 20px;
                            cursor: pointer;
                            transition: 0.3s;
                        }

                        /* When moving the mouse over the close button */
                        .closebtn:hover {
                            color: black;
                        }
</style>
<?php
//Core DB Section
$core_db_file = dirname(__FILE__) . "/db/core.db";

// SQLite3 PDO connection:
function connect_sql3_db($core_db_file) {
    try {
        $file_db = new PDO('sqlite:' . $core_db_file);
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Proccess error
        echo 'Cannot connect to database: ' . $e->getMessage();
    }
    return $file_db;
}

function check_core_db($core_db_file) {
    /**************************************
     * Check if db folder exists           *
     **************************************/
    if (!file_exists(dirname(__FILE__) . "/db")) {
        mkdir(dirname(__FILE__) . "/db", 0775, true);
    }


    if (!file_exists($core_db_file)) {
//        echo "db file not found<BR>";
        if (isset($_POST['db_action']) && $_POST['db_action'] == "create") {
            echo "Attempting to create db file ....<BR>";
            $defaults = filter_input(INPUT_POST, 'fdefaults');
            create_core_db($core_db_file, $defaults);
            check_core_db($core_db_file);
        } else {
            ?>

            <div class="center">
                <h1>Database  dose not exists. </h1>
                <form method="POST">
                    <div class="checkbox">
                        <label><input type="checkbox" name="fdefaults" value="yes" checked> Load Default Pages</label>
                    </div>
                    <input type="hidden" name="db_action" value="create">
                    <!--<input type="submit" value="Create New Database">-->
                    <button type="submit">Create New Database</button>
                </form>   
            </div>

            <?php
        }
    } else {
        $result = connect_sql3_db($core_db_file)->query("SELECT name FROM sqlite_master WHERE type='table' AND name='pages'");
        $arr = $result->fetchAll();
if (array_key_exists("pages", $arr)) {
    echo "An error occurred.\n<BR>";
    print_r ($arr);
exit(1);
        }else{
//            echo "DB file exists and contains pages table... making system connection...";
           return "db_connect";
            
        }
    }
}

function create_core_db($core_db_file, $defaults) {
    echo "<div class=\"center\">";
    echo "creating db";
    try {
        /**************************************
         * Create databases and connect        *
         **************************************/
        if (file_exists($core_db_file)) {
            $message = "Core DB already exists, please contact tech support.<BR>";
            echo $message;
//        sys_message($message);
        } else {

            // Create (connect to) SQLite database in file
            $file_db = new PDO('sqlite:' . $core_db_file);
            // Set errormode to exceptions
            $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /**************************************
             * Create tables                       *
             **************************************/

            // Create table messages
            $file_db->exec("CREATE TABLE IF NOT EXISTS pages (
                    id INTEGER PRIMARY KEY AUTOINCREMENT, 
                    name TEXT, 
                    url TEXT,
                    sorter INTEGER)");
            /**************************************
             * Set initial data                    *
             **************************************/

            
            if (isset($defaults) && $defaults == "yes"){
            // Array with some default data to insert to database             
            $pages = array(
                array('name' => 'Home', 'url' => '#', 'sorter' => '1'),
                array('name' => 'Plex', 'url' => 'http://127.0.0.1:32400/web/', 'sorter' => '2'),
                array('name' => 'Plexpy', 'url' => 'http://127.0.0.1:8181', 'sorter' => '3'),
                array('name' => 'if not true', 'url' => 'http://www.if-not-true-then-false.com/', 'sorter' => '4'),
                array('name' => 'Configure', 'url' => '#', 'sorter' => '100')
            );                
            } else {
            // Array with minimal data to insert to database             
            $pages = array(
                array('name' => 'Home', 'url' => '#', 'sorter' => '1'),

                array('name' => 'Configure', 'url' => '#', 'sorter' => '100')
            );
                
            }

            /*             * ************************************
             * Play with databases and tables      *
             * ************************************ */

            // Prepare INSERT statement to SQLite3 file db
            $insert = "INSERT INTO pages (name, url, sorter) VALUES (:name, :url, :sorter)";
            $stmt = $file_db->prepare($insert);

            // Bind parameters to statement variables
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':sorter', $sorter);

            // Loop thru all pages and execute prepared insert statement
            foreach ($pages as $p) {
                // Set values to bound variables
                $name = $p['name'];
                $url = $p['url'];
                $sorter = $p['sorter'];

                // Execute statement
                $stmt->execute();
            }
        }

        // Select all data from file db pages table 
        $result = $file_db->query('SELECT * FROM pages');
        
echo "<BR>Populating db with default sites:<BR>";
        // Loop thru all data from pages table    
        foreach ($result as $p) {

            echo "Name - " . $p['name'] . " -- URL - " . $p['url'] . " -- Sort# - " .  $p['sorter'] . "<BR>";
        }
          ?>
<BR>Site will reload in <span id="seconds">5</span>.
    <script>
      var seconds = 5;
      setInterval(
        function(){
          document.getElementById('seconds').innerHTML = --seconds;
        }, 1000
      );
    </script>
<?PHP
header("Refresh:5");

    } catch (PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
    }
    echo "</div>";
}
