<style>
    table, th {
    color: #fff;
}
</style>
<center>
<table border=1>
    <TR style="color: #fff;"><TD colspan="4">
    <center>
        <h3>
            ULR Admin:
        </h3>
    </center>
</TD>
</TR>

<TH>Name</TH><TH>URL</TH><TH>Add/Edit/Delete</TH>
<?php
$query = $core_db->query("SELECT * FROM pages order by sorter");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
       $id = $row['id'];
       $name = $row['name'];
       $url = $row['url'];
       $sorter = $row['sorter'];
       
?>
<TR><form action="" method="post">
        <TD><input type="text" name="fname" value="<?php echo $name; ?>"/></TD>
        <TD><input type="text" name="furl" value="<?php echo $url; ?>"/></TD>
        <TD><input type="text" name="fsorter" value="<?php echo $sorter; ?>"/></TD>
        <TD>
            <div style="float: left; width: 50px;">
            <input type="hidden" name="fid" value="<?php echo $id; ?>"> 
            <input type="hidden" name="url_action" value="edit">
            <input type="submit" value=" Edit "/>
            </div>
 </form> 
<div style="float: right; width: 50px;">
<form action="" method="post">
 <input type="hidden" name="fid" value="<?php echo $id; ?>">   
 <input type="hidden" name="url_action" value="delete">
            <input type="submit" value=" Delete "/>   
</form>
    
</div>
<br style="clear: both;" />
        </TD></TR>

<?php
}
?>

<font color="#fff">      <TR style="color: #fff;"><TD colspan="4">
         <h3>Add New URL:</h3></font>
    </TD>
</TR>
<TR>
<TD><form action="" method="post"><input type="text" name="fname" placeholder="Site name"/></TD>
<TD><input type="text" name="furl" placeholder="Site URL"/></TD>
<TD><input type="text" name="fsorter" placeholder="Order"/></TD>
        <TD><input type="hidden" name="url_action" value="add">
            <input type="submit" value=" Add "/></TD>
</form>
</TR>


</table>

</center>








