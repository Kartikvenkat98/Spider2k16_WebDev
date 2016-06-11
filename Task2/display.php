<?php
  session_start();
  if(isset($_GET['seeAll']))
  {
    include('conn.php');
	 $sort = $_GET['sort'];
    if($sort == "ByRoll")
      $seeAllQuery = "SELECT * FROM students";
    else
      $seeAllQuery = "SELECT * FROM students ORDER BY NAME";
    //$seeAllQuery = "SELECT * FROM spider";
    $resAll = mysqli_query($conn,$seeAllQuery);
    if($resAll) 
	{
      echo "<table>";
      echo '<tr><th>Name</th><th>Roll No</th><th>Department</th><th>Email</th><th>Address</th><th>About Me</th></tr>';
      while($tuple = mysqli_fetch_array($resAll,MYSQLI_ASSOC)) 
	  {
        echo '<tr><td>';
        echo $tuple['NAME'];
        echo '</td><td>';
        echo $tuple['ROLL_NO'];
        echo '</td><td>';
        echo $tuple['DEPT'];
        echo '</td><td>';
        echo $tuple['MAIL'];
        echo '</td><td>';
        echo $tuple['ADDRESS'];
        echo '</td><td>';
        echo $tuple['ABOUT ME'];
        echo '</td></tr>';
      }
    }
    else 
	{
      die("Error extracting from database");
    }
    mysqli_close($conn);
  }
  if(isset($_GET['sub']))
  {
    include('conn.php');     //includes the script which connects to the mysql database
	//$sort = $_GET['sort'];
    $column=$pattern="";
    $flag=1;
    if(!empty($_GET['column'])) 
	{
      $column = $_GET['column'];
    }
    else 
	{
      echo "Select a value for 'Search By' field. <br>";
      $flag=0;
    }
    if(!empty($_GET['pattern'])) {
      $pattern = $_GET['pattern'];
    }
    else 
	{	
      echo "Fill in the 'Search Value' field. <br>";
      $flag = 0;
    }
    if($flag==1) 
	{
		if($sort == "ByRoll")
        	$sqlquery = "SELECT * FROM students WHERE $column LIKE '%".$pattern."%'";
        else
        	$sqlquery = "SELECT * FROM students WHERE $column LIKE '%".$pattern."%' ORDER BY NAME";
      //$sqlquery = "SELECT * FROM spider WHERE $column LIKE '%".$pattern."%'";
      $result = mysqli_query($conn,$sqlquery);
      if($result) 
	  {
          $num_rows = mysqli_num_rows($result);
          if($num_rows > 0) 
		  {
            $cntres = 'Results found : '.$num_rows.'<br>';
            echo "<table>";
            echo '<tr><th>Name</th><th>Roll No</th><th>Department</th><th>Email</th><th>Address</th><th>About Me</th></tr>';
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
              echo '<tr><td>';
              echo $row['NAME'];
              echo '</td><td>';
              echo $row['ROLL_NO'];
              echo '</td><td>';
              echo $row['DEPT'];
              echo '</td><td>';
              echo $row['MAIL'];
              echo '</td><td>';
              echo $row['ADDRESS'];
              echo '</td><td>';
              echo $row['ABOUT ME'];
              echo '</td></tr>';
              $editStud = $row;
            }
          }
          else 
		  {
            $cntres = "Sorry!! No results found!<br>";
          }
        }
        else 
		{
          die('Error extracting data');
        }
      }
      mysqli_close($conn);
  }
?>


<html>
  <head>
    <meta charset="utf-8">
    <title>View Student Record</title>
    <style>
      body 
	  {
        font-family: Arial, Helvetica, sans-serif;
        color: #999;
        font-weight: 200;
      }
      th 
	  {
        background-color: #999;
        color:white;
        font-weight: 200;
      }
      th,td 
	  {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        padding: 10px;
        border-bottom: 1px solid darkgray;
      }
      tr:nth-child(even) 
	  {
        background-color: lightgray;
        color : black;
      }
    </style>
  </head>
  <body>
    <form name="search" method="get" action="display.php">
      <h3>Search By</h3>
      <select name="column">
        <option value="ROLL_NO">Roll Number</option>
        <option value="NAME">Name</option>
      </select>
      <h3>Search value</h3>
      <input type="text" size="40" name="pattern"/><br /><br />
      <input type="submit" name="sub" value="Submit"/>
      <input type="submit" name="seeAll" value="View All Students"/><br />
      <input type="radio" name="sort" value="ByRoll" checked>Sorted By Roll Number<br/>
      <input type="radio" name="sort" value="ByName">Sorted By Name<br/>
    </form>
    <br/><br/><br/>
    <span style="font-weight:400"><?php global $cntres; echo $cntres; ?></span>
    <br/><br/>
    <?php
		global $num_rows;
      	if($num_rows == 1) 
		{
        	if($editStud)
          	$_SESSION['data'] = $editStud;
        else
        	echo 'Cant store session object';
        echo "<button type='button' onclick=\"location.href='editdetails.php'\">Edit</button>";
        }
    ?>
  </body> 
</html>