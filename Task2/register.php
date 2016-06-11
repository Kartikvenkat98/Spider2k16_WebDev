<?php
  if(isset($_POST['submit']))
  {
     include('conn.php');    //includes the script which connects to mysql database
	 global $nameErr, $rollErr, $mailErr, $addrErr;
	 global $name, $rollno, $dept, $email, $addr, $about;
     $nameErr = $rollErr = $mailErr = $addrErr = "";
     $name = $rollno = $dept = $email = $addr = $about = "";
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
     elseif(!preg_match("/(@nitt.edu)$/",$_POST['mail'])) {
       $mailErr ='Mail id must end with @nitt.edu';
       $flag=0;
     }
     else
       $email=$_POST['mail'];
	   
     if(!preg_match("/^\d{9}$/",$_POST['rollno'])) 
	 {
       $rollErr = 'Roll number must be of exactly nine digits';
       $flag=0;
     }
     else 
	   $rollno=$_POST['rollno'];
       
     if(empty($_POST['addr'])) 
	 {
       $addrErr = 'Address field cannot be blank';
       $flag=0;
     }
     else
	 {
        $addr=$_POST['addr'];
     	$dept=$_POST['dept'];
     	$about=$_POST['abt'];
	 }
	 
     if ($flag==1) 
	 {
       $pscode=substr(md5(rand()),0,9);
	   $sqlinsert=$conn->prepare("INSERT INTO spider VALUES(?,?,?,?,?,?,?)");
       if($sqlinsert) 
	   {
         $sqlinsert->bind_param("sisssss",$name,$rollno,$dept,$email,$addr,$about,$pscode);
       }
       else 
	   {
         die("Error preparing statements");
       }
       $result = $sqlinsert->execute();
       //$sqlinsert="INSERT INTO spider VALUES('$name','$rollno','$dept','$email','$addr','$about','$pscode')";
       //$result = mysqli_query($conn,$sqlinsert);
       if($result) 
	   {
         echo 'Registration successful. <br>';
         echo 'Your passcode is ',$pscode,'.<br> Keep this for future reference and editing.<br>';
      }
      else 
	  {
         echo 'Error Type : ',mysqli_error($conn),'<br>';
         die('Error inserting into database');
      }
    }
    mysqli_close($conn);
  }
?>


<html>
  <head>
    <meta charset="utf-8">
    <title>Add Record</title>
    <style>
      body 
	  {
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
      <h1>Student Registration Details</h1>
    </center>
    <form name="student" method="post" action="register.php">
      <h3>Name</h3>
      <input type="text" name="name" size="50" value="<?php global $name; echo $name;?>" placeholder="Enter your name" required>
      <span class="error"><?php global $nameErr; echo $nameErr;?></span><br/>
      <h3>Roll number</h3>
      <input type="number" name="rollno" size="50" value="<?php global $rollno; echo $rollno;?>" placeholder="Enter your roll number" required>
      <span class="error"><?php global $rollErr; echo $rollErr;?></span><br/>
      <h3>Department</h3>
      <input list="dept" name="dept" size="50" value="<?php global $dept; echo $dept;?>" placeholder="Enter your department" required>
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
      <input type="email" name="mail" size="50" value="<?php global $email; echo $email;?>" placeholder="Enter your email" required>
      <span class="error"><?php global $mailErr; echo $mailErr;?></span><br/>
      <h3>Address</h3>
      <textarea cols="50" rows="4" name="addr"><?php global $addr; echo $addr; ?></textarea>
      <span class="error"><?php global $addrErr; echo $addrErr;?></span><br/>
      <h3>About me</h3>
      <textarea cols="50" rows="4" name="abt"><?php global $about; echo $about; ?></textarea>
      <br/><br/>
      <input type="submit" name="submit" value="Submit">
      <input type="reset" value="Reset">
    </form>
  </body>
</html>
