<?php
  session_start();
  $editStud = $_SESSION['data'];
  if(isset($_POST['submit']))
  {
    include('conn.php');
    global $nameErr, $pscodeErr, $mailErr, $addrErr;
	global $name, $pscode, $dept, $email, $addr, $about;
    $nameErr=$pscodeErr=$mailErr=$addrErr="";
    $name=$pscode=$dept=$email=$addr=$about="";
    $flag=1;
    if(!preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) 
	{
       $nameErr = 'Name can contain only letters and whitespaces';
       $flag=0;
    }
    else
       $name=$_POST['name'];
	   
    if(!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) 
	{
      $mailErr = 'Invalid email format';
      $flag=0;
    }
    elseif(!preg_match("/(@nitt.edu)$/",$_POST['mail'])) 
	{
      $mailErr ='Mail id must end with @nitt.edu';
      $flag=0;
    }
    else
      $email=$_POST['mail'];
	  
    if(empty($_POST['addr'])) 
	{
      $addrErr = 'Address field cannot be blank';
      $flag=0;
    }
    else
      $addr=$_POST['addr'];
    if(!preg_match("/^[a-zA-Z0-9]{9}$/",$_POST['pscode']))  {
      $pscodeErr = "Invalid format for passcode";
      $flag = 0;
    }
    else 
	{
      $pscode = $_POST['pscode'];
    }
	
    $rollno=$_POST['rollno'];
    $dept=$_POST['dept'];
    $about=$_POST['abt'];
	
    if($flag == 1) 
	{
      $sqlget = "SELECT * FROM spider WHERE ROLL_NO=$rollno";
      $checkresult = mysqli_query($conn,$sqlget);
      if($checkresult) {
        $updateStud = mysqli_fetch_array($checkresult,MYSQLI_ASSOC);
      }
      else 
	  {
        die('Error extracting data');
      }
      $userCode = $updateStud['PASSCODE'];
      if(strcmp($userCode,$pscode) == 0) 
	  {
		   $sqlupdate = $conn->prepare("UPDATE students SET NAME=?,DEPT=?,MAIL=?,ADDRESS=?,ABOUT=? WHERE ROLL_NO=?");
           if($sqlupdate) {
           	$sqlupdate->bind_param("sssssi",$name,$dept,$email,$addr,$about,$rollno);
        }
        else 
		{
          die("Error preparing statement");
        }
        $result = $sqlupdate->execute();
        //$sqlupdate = "UPDATE spider SET NAME='$name',DEPT='$dept',MAIL='$email',ADDRESS='$addr',ABOUT ME='$about' WHERE ROLL_NO=$rollno";
        //$result = mysqli_query($conn,$sqlupdate);
        if($result) 
		{
          echo 'Database updated successfully!!<br>';
        }
        else 
		{
          die('Error updating data');
        }
      }
      else 
	  {
        echo 'Error : Passcode does not match.<br>';
        echo $rollno;
      }
    }
    mysqli_close($conn);
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Update Record</title>
    <style>
      body {
        font-family: Arial, Helvetica, sans-serif;
        color: #999;
      }
      h1,h3 
	  {
        font-weight: 200;
      }
      .error 
	  {
        color: red;
      }
    </style>
  </head>
  <body>
    <center>
      <h1>Edit Student Details</h1>
    </center>
    <form name="student" method="post" action="editdetails.php">
      <h3>Name</h3>
      <input type="text" name="name" size="50" placeholder="Enter your name" value="<?php echo $editStud['NAME']; ?>" required>
      <span class="error"><?php global $nameErr; echo $nameErr;?></span><br/>
      <h3>Roll number</h3>
      <input type="number" name="rollno" size="50" placeholder="Enter your roll number" value="<?php echo $editStud['ROLL_NO']; ?>" readonly>
      <h3>Department</h3>
      <input list="dept" name="dept" size="50" placeholder="Enter your department" value="<?php echo $editStud['DEPT']; ?>" required>
        <datalist id="dept">
          <option value="Architecture">
          <option value="Chemical Engineering">
          <option value="Civil Engineering">
          <option value="Computer Science and Engineering">
          <option value="Electronics and Communication Engineering">
          <option value="Electrical and Electronics Engineering">
          <option value="Instrumentation and Control Engineering">
          <option value="Mechanical Engineering">
          <option value="Metallurgical and Materials Engineering">
          <option value="Production Engineering">
        </datalist>
      <h3>Email</h3>
      <input type="email" name="mail" size="50" placeholder="Enter your email" value="<?php echo $editStud['MAIL']; ?>"required>
      <span class="error"><?php global $mailErr; echo $mailErr;?></span><br/>
      <h3>Address</h3>
      <textarea cols="50" rows="4" name="addr"><?php echo $editStud['ADDRESS']; ?></textarea>
      <span class="error"><?php global $addrErr; echo $addrErr;?></span><br/>
      <h3>About me</h3>
      <textarea cols="50" rows="4" name="abt"><?php echo $editStud['ABOUT ME']; ?></textarea>
      <h3>Passcode</h3>
      <input type="text" size="50" name="pscode" placeholder="Enter passcode"/>
      <span class="error"><?php global $pscodeErr; echo $pscodeErr;?></span><br/>
      <br/><br/>
      <input type="submit" name="submit" value="Submit">
      <input type="reset" value="Reset">
    </form>
  </body>
</html>