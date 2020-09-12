<?include('signUpAndLogin.php')?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
<title>Sign up - Jinder</title>
<link rel="stylesheet" type="text/css" href="style.css">
    </script>
    </head>
<body class="loginbody">
      	  <img src="final2.jpg" alt="logo" style='position:absolute; top:0; left:3;' width="250" height="143"/>

  <h1 class="h1login">

		Welcome to Jinder
  </h1>
	<a href="homepage.html" class="allbuttons" type="submit" name="SignUp" value="SignUp">Homepage</a>
  
<div class="signUp">
<div class="form">
<form action="signUpAndLogin.php" method="post">
    <h2 class="h2login">Sign Up</h2>
	<div class="fontcolor">
<table>
	<tr><td>First Name:</td><td><input type="text" placeholder="John" name="fname" size="30" value="<?=$_Session['fname']?>"/></td></tr>
	<tr><td>Last Name:</td><td><input type="text" placeholder="Hazel" name="lname" size="30" /></td></tr>
	<tr><td>DOB:</td><td> <input type="date" name="dob" size="30" /></td></tr>
 	<tr><td>Email:</td><td> <input type="text" placeholder="johnhazel@gmail.com" name="email" size="30" /></td></tr>
 	<tr><td>Username:</td><td> <input type="text" placeholder="johnhazel" name="uname" size="30" /></td></tr>
 	<tr><td>Password:</td><td> <input type="password" placeholder="Password" name="pswd" size="30" /></td></tr>      
 	<tr><td>Confirm Password:</td><td> <input type="password" placeholder="Confirm Password" name="pswdr" size="30" /></td></tr> 
<input type="hidden" name="function" value="sign_up">	
</table>
</div>
<p>
	<input class="allbuttons" type="submit" name="SignUp" value="SignUp" />
	<input class="allbuttons" type="reset" name="Reset" value="Reset" />
</p>

</form>
<script type = "text/javascript"  src = "loginValidation_r.js" ></script>
</div>
</div>

<footer>
<div class = "fontcolor">
      <p>&copy;. Jinder Corp, 2018. All rights reserved.</p>
</div>
<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</footer>
</body>
</html>
