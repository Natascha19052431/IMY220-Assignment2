<?php
	// See all errors and warnings
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "dbUser";
	$mysqli = mysqli_connect($server, $username, $password, $database);

	$email = isset($_POST["loginEmail"]) ? $_POST["loginEmail"] : false;
	$pass = isset($_POST["loginPass"]) ? $_POST["loginPass"] : false;	
	// if email and/or pass POST values are set, set the variables to those values, otherwise make them false
		
?>



<!DOCTYPE html>
<html>
<head>
	<title>IMY 220 - Assignment 2</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Natascha Janse van Rensburg">
	<!-- Replace Name Surname with your name and surname -->
</head>
<body>
	<div class="container">
		<?php
		
			if($email && $pass){
				$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res)){
					echo 	"<table class='table table-bordered mt-3'>
								<tr>
									<td>Name</td>
									<td>" . $row['name'] . "</td>
								<tr>
								<tr>
									<td>Surname</td>
									<td>" . $row['surname'] . "</td>
								<tr>
								<tr>
									<td>Email Address</td>
									<td>" . $row['email'] . "</td>
								<tr>
								<tr>
									<td>Birthday</td>
									<td>" . $row['birthday'] . "</td>
								<tr>
							</table>";
				
					echo 	"<form method='POST' action='login.php' enctype='multipart/form-data'> 
								<div class='form-group'>
									<input type='hidden' name='ID' id='ID' value='".$email."' />
									<input type='hidden' name='pass' id='pass' value='".$pass."' /><br/>
									<input type='file' class='form-control' name='picToUpload' id='picToUpload' /><br/>
									<input type='submit' class='btn btn-standard' value='Upload Image' name='submit' />
								</div>
						  	</form>";
						  	
						//	Gallery 
					echo "<h1 class='page-header'>Image Gallery</h1>";
					echo "<div class='row imageGallery'>";
								$curUser=$row['user_id'];
							$query = "SELECT * FROM tbgallery WHERE user_id = '$curUser'";
								$res = $mysqli->query($query);
								// if($res->num_rows!=0)
								// {
									while($row = $res->fetch_assoc()) {
										echo"

											
											<div class='col-3' style='background-image: url(gallery/".$row['filename']."); background-size: cover;background-repeat:no-repeat;'>
									</div>
		   										 
		  									";
		  								}
								// }


					echo "</div>";//gallery div
						
							
							
					}
				//}
				else{
					echo 	'<div class="alert alert-danger mt-3" role="alert">
	  							You are not registered on this site!
	  						</div>';
				}
			}
			
			else if(isset($_POST['submit'])){
			//$picFile=$_POST["picToUpload"];
			$picFile=$_FILES["picToUpload"];
		
						$target="gallery/";
							$file=($picFile["name"]);
							$size=$picFile["size"];
							$type=$picFile["type"];


							// checking the type
							if($type!="image/jpeg"&&$type!="image/pjpeg")
							{
								echo "Wrong type of file!";
							}
							else
							{
								if($size>=(1024*1024))
								{
									echo "File is too big!";
								}
								else//file meets all requirements time to upload
								{
									$fileemail=$_POST['ID'];
									$filepass=$_POST['pass'];
									$UserID;
								//	echo $filepass;
									$query = "SELECT * FROM tbusers WHERE email = '$fileemail' AND password = '$filepass'";
									$res = $mysqli->query($query);
									if($row = mysqli_fetch_array($res))
									{
										$UserID=$row['user_id'];
										
									}

										// $query = "INSERT INTO tbusers (name, surname, email, birthday, password) VALUES ('$name', '$surname', '$email', '$date', '$pass');";

										// $res = mysqli_query($mysqli, $query) == TRUE;
									move_uploaded_file($picFile["tmp_name"],$target . $picFile["name"]);
									//echo $_POST['ID'];
									$query = "INSERT INTO tbgallery (user_id, filename) VALUES ('$UserID','$file')";
									$res = $mysqli->query($query);
									if($res)
									//echo "Stored in: " . $target . $picFile["name"];
										//echo htmlentities($_POST['loginEmail']);
									$email=$fileemail;
									$pass=$filepass; 
									//header("Location:login.php");

									$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res)){
					echo 	"<table class='table table-bordered mt-3'>
								<tr>
									<td>Name</td>
									<td>" . $row['name'] . "</td>
								<tr>
								<tr>
									<td>Surname</td>
									<td>" . $row['surname'] . "</td>
								<tr>
								<tr>
									<td>Email Address</td>
									<td>" . $row['email'] . "</td>
								<tr>
								<tr>
									<td>Birthday</td>
									<td>" . $row['birthday'] . "</td>
								<tr>
							</table>";
				
					echo 	"<form method='POST' action='login.php' enctype='multipart/form-data'> 
								<div class='form-group'>
									<input type='hidden' name='ID' id='ID' value='".$email."' />
									<input type='hidden' name='pass' id='pass' value='".$pass."' /><br/>
									<input type='file' class='form-control' name='picToUpload' id='picToUpload' /><br/>
									<input type='submit' class='btn btn-standard' value='Upload Image' name='submit' />
								</div>
						  	</form>";
						  	
						//	Gallery 
					echo "<h1 class='page-header'>Image Gallery</h1>";
					echo "<div class='row imageGallery'>";
								$curUser=$row['user_id'];
							$query = "SELECT * FROM tbgallery WHERE user_id = '$curUser'";
								$res = $mysqli->query($query);
								// if($res->num_rows!=0)
								// {
									while($row = $res->fetch_assoc()) {
										echo"

											
											<div class='col-3' style='background-image: url(gallery/".$row['filename']."); background-size: cover;background-repeat:no-repeat;'>
									</div>
		   										 
		  									";
		  								}
								// }


					echo "</div>";//gallery div
						
							
							
					}
				//}
				else{
					echo 	'<div class="alert alert-danger mt-3" role="alert">
	  							You are not registered on this site!
	  						</div>';
				}
								}
							}
			}
					
			else{
				echo 	'<div class="alert alert-danger mt-3" role="alert">
	  						Could not log you in
	  					</div>';
			}
			
		?>
	</div>
</body>
</html>