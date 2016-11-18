<?PHP

if (isset($_POST['url_action'])) {
  
    switch (filter_input(INPUT_POST, 'url_action')) {
        case 'add':
            $fname = filter_input(INPUT_POST, 'fname');
            $furl = filter_input(INPUT_POST, 'furl');
//            echo "adding to pages - ".$fname."  ".$furl;

            $sql = "INSERT INTO pages (name, url, sorter) VALUES (:fname, :furl, :fsorter)";
            $query = $core_db->prepare($sql);
            $fname = filter_input(INPUT_POST, 'fname');
            $furl = filter_input(INPUT_POST, 'furl');
            $fsorter = filter_input(INPUT_POST, 'fsorter');            
// bind the placeholder names to specific script variables
            $query->bindParam(":fname", $fname);
            $query->bindParam(":furl", $furl);
            $query->bindParam(":fsorter", $fsorter);
            $query->execute();
            break;

        case 'edit':
//            $fname = filter_input(INPUT_POST, 'fname');
//            $furl = filter_input(INPUT_POST, 'furl');
            $sql = "UPDATE pages SET name = :fname, url = :furl, sorter = :fsorter WHERE id = :fid";
            $query = $core_db->prepare($sql);
            $fid = filter_input(INPUT_POST, 'fid');
            $fname = filter_input(INPUT_POST, 'fname');
            $furl = filter_input(INPUT_POST, 'furl');
            $fsorter = filter_input(INPUT_POST, 'fsorter');
// bind the placeholder names to specific script variables
            $query->bindParam(":fid", $fid);
            $query->bindParam(":fname", $fname);
            $query->bindParam(":furl", $furl);
            $query->bindParam(":fsorter", $fsorter);
            $query->execute();
            break;

        case 'delete':
            $sql = "DELETE FROM pages WHERE id = :id";
            $query = $core_db->prepare($sql);
// bind the placeholder names to specific script variables
            $query->bindParam(":id", filter_input(INPUT_POST, 'fid'));
            $query->execute();
            break;

        default:
            break;
    }
}


