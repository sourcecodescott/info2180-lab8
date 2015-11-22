<?php
#Connect to db
mysql_connect(
"172.16.150.74",
"sourcecodescott"
);
mysql_select_db("world");

#parameters
$LOOKUP = $_REQUEST['lookup'];
$ALL = $_REQUEST['all'];
$FORMAT = $_REQUEST['format'];

# execute a SQL query on the database
#If no lookup term given...
if(sizeof($LOOKUP)==0){
  #and 'all' was checked...
  if($ALL == 'true'){
    #query the db
    $results = mysql_query("SELECT * FROM countries WHERE name LIKE '%$LOOKUP%';");
    
    #if 'xml' was checked
    if($FORMAT == 'xml'){
      #output XML file
      #XML OUTPUT CODE-------------------------------------------------------
      header('Content-Type: text/xml');
      echo '<?xml version="1.0" encoding="UTF-16"?>'; ?>
<countrydata><?php
      while ($row = mysql_fetch_array($results)) {
        ?>
<country>
<name><?php echo $row["name"]; ?></name>
<ruler><?php echo $row["head_of_state"]; ?></ruler>
</country>
        <?php
      } ?>
</countrydata>
        <?php
        #-------------------------------------------------------------------
        
    }else{
      #otherwise, generate html response...
      print $results;
      # loop through each country
      
      while ($row = mysql_fetch_array($results)) {
        ?>
        <li> <?php echo $row["name"]; ?>, ruled by <?php echo $row["head_of_state"]; ?> </li>
        <?php
      }
    }
    
  #if 'all' was not checked...
  }else{
    // Effectively output nothing, but so client side still receives a response:
    ?>
      
      <?php
  }
  
#if a lookup term was given...  
}else{
  #and 'xml' was checked...
  if($FORMAT == 'xml'){
    #output XML
    #XML OUTPUT CODE---------------------------------------------------------
      header('Content-Type: text/xml');
      echo '<?xml version="1.0" encoding="UTF-16"?>'; ?>
<countrydata><?php
      while ($row = mysql_fetch_array($results)) {
        ?>
<country>
<name><?php echo $row["name"]; ?></name>
<ruler><?php echo $row["head_of_state"]; ?></ruler>";
</country>
        <?php
      } ?>
</countrydata>
        <?php
        #-------------------------------------------------------------------
        
  #otherwise, generate html
  }else{
    $results = mysql_query("SELECT * FROM countries WHERE name LIKE '%$LOOKUP%';");
    print $results;
    # loop through each country
    
    while ($row = mysql_fetch_array($results)) {
      ?>
      <li> <?php echo $row["name"]; ?>, ruled by <?php echo $row["head_of_state"]; ?> </li>
      <?php
    }
  }
}
?>
