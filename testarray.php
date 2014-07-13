<?php $phpArray = array(
          0 => 001-1234567
    )
?>
<?php
  mysql_connect("localhost", "root", "") or die ("Faile to connect!");
  mysql_select_db("mydb") or die ("Can't not find this database!");
    
?>

  <?php

       $temp = array();
       $a = array();
       $i=0;
       $list = mysql_query("SELECT * FROM place ");
       while($row = mysql_fetch_array($list, MYSQL_NUM)) {
          
          $temp = $row;
          $a[$i] = $temp;
          
          echo $a[$i][1] . " " . $row[2];
          echo "<br>";
          $i++;
          } 
     echo count($a);

  mysql_free_result($list);
   ?>
<script type="text/javascript">

    var jArray = <?php echo json_encode($a ); ?>;

    for(var i=0;i<3;i++){

        alert(jArray[i][1]);
    }

 </script>




 

