<?php // Example 26-8: profile.php
  require_once 'header.php';
//error_reporting(0);
  if (!$loggedin) die();
  ?>
  <script>
	/*$.validator.setDefaults({
		submitHandler: function() {
			//alert("submitted!");
		}
	});
	*/

	$().ready(function() {
		// validate the comment form when it is submitted
		$("#commentForm").validate();

		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				///firstname: "required",
				//lastname: "required",
				user: {
					required: true,
					minlength: 2
				},
				pass: {
					required: true,
					minlength: 5
				},
				/*
				confirm_password: {
					required: true,
					minlength: 5,
					//equalTo: "#password"
				},*/
				email: {
					required: true,
					email: true
				},
				
				/*
				topic: {
					required: "#newsletter:checked",
					minlength: 2
				},
				agree: "required"
			},
			messages: {
				firstname: "Please enter your firstname",
				lastname: "Please enter your lastname",
				*/
				user: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				pass: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				/*
				confirm_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				*/
				email: "Please enter a valid email address",
				//agree: "Please accept our policy",
				//topic: "Please select at least 2 topics"
			}
		});

		/* propose username by combining first- and lastname
		$("#username").focus(function() {
			var firstname = $("#firstname").val();
			var lastname = $("#lastname").val();
			if (firstname && lastname && !this.value) {
				this.value = firstname + "." + lastname;
			}
		});
		

		//code to hide topic selection, disable for demo
		var newsletter = $("#newsletter");
		// newsletter topics are optional, hide at first
		var inital = newsletter.is(":checked");
		var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
		var topicInputs = topics.find("input").attr("disabled", !inital);
		// show when newsletter is checked
		newsletter.click(function() {
			topics[this.checked ? "removeClass" : "addClass"]("gray");
			topicInputs.attr("disabled", !this.checked);
		}); */
	});
	</script>
  
  
  <?php

  echo "<div class='main'><h3>Your Profile</h3>";
  
  $sqlo = "SELECT email, gender, age, interests, location FROM members WHERE user='$user'";
$resulto = $connection->query($sqlo);

if ($resulto->num_rows > 0) {
    // output data of each row
    while($rowo = $resulto->fetch_assoc()) {
        echo "Email: " . $rowo['email']. "<br>Gender: " . $rowo['gender']. "<br>Date of Birth: " . $rowo['age']."<br>Interests: " . $rowo['interests']."<br>Location: " . $rowo['location']."<br>";
    }
}
  
   $user = "Please fill in";
    $pass = "Please fill in";
	$email = "Please fill in";
	$gender = "Please fill in";
	$age =  "Please fill in";
     $interests = "Please fill in";
	$location = "Please fill in";
	

  $result = queryMysql("SELECT * FROM members WHERE user='$user'");
    
  if (isset($_POST['user']))
  {
	  /*
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);
*/
    
		$user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
	$email = sanitizeString($_POST['email']);
	$gender = sanitizeString($_POST['gender']);
	$age = sanitizeString($_POST['year']);
     $interests = sanitizeString($_POST['interests']);
	$location = sanitizeString($_POST['postcode']);
	if ($result->num_rows){
         //queryMysql("UPDATE profiles SET text='$text' where user='$user'");
	 queryMysql("UPDATE members SET text='$user' where user='$user'");
     queryMysql("UPDATE members SET text='$pass' where user='$user'");
	 queryMysql("UPDATE members SET text='$email' where user='$user'");
	 queryMysql("UPDATE members SET text='$gender' where user='$user'");
	 queryMysql("UPDATE members SET text='$age' where user='$user'");
	 queryMysql("UPDATE members SET text='$location' where user='$user'");
	 queryMysql("UPDATE members SET text='$interests' where user='$user'");
    /*
	}else {
		queryMysql("INSERT INTO profiles VALUES('$user', '$user')");
	     queryMysql("INSERT INTO members VALUES('$user', '$pass')");
		 queryMysql("INSERT INTO members VALUES('$user', '$email')");
		 queryMysql("INSERT INTO members VALUES('$user', '$gender')");
		 queryMysql("INSERT INTO members VALUES('$user', '$age')");
		 queryMysql("INSERT INTO members VALUES('$user', '$location')");
		 queryMysql("INSERT INTO members VALUES('$user', '$interests')");
		 */
  }
  }
 /* else
  {
    if ($result->num_rows)
    {
      $row  = $result->fetch_array(MYSQLI_ASSOC);
      $text = stripslashes($row['text']);
    }
    else $text = "";
  }

  $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));
*/
  if (isset($_FILES['image']['name']))
  {
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }

  showProfile($user);

  echo <<<_END
    <div class="signupred" style="background: #f7c8c8;
    padding: 30px;
    margin-top: 30px;
    width: 84%;">
  <h3>Change Your Details</h3>
  <p style="font-size: 11px;">Please fill in the form underneath. These will be your new login details. </p>
    <form name="myForm" method='post' action='signup.php' class="cmxform" id="commentForm">$error
    <!--<span class='fieldname'>Username<span style="color:red;font-weight:bold;">*</span></span>
    <input type='text' maxlength='16' name='user' value='$user'
      onBlur='checkUser(this)'><span id='info' value='$user'
      onBlur='checkUser(this)'></span>-->
	  
<label for="user">New Username<span style="color:red;font-weight:bold;">*</span></label>
				<input id="user" name="user" type="text" value='$user' required><br>
	  
	  
    <!---<span class='fieldname'>New Password<span style="color:red;font-weight:bold;">*</span></span>
    <input type='password' maxlength='16' name='pass'
      value='$pass'>-->
	  
	  <label for="pass">New Password<span style="color:red;font-weight:bold;">*</span></label>
				<input id="pass" name="pass" type="password" value='$pass' required>
	  <br>
	  
	  
	   <!--<span class='fieldname'>New Email<span style="color:red;font-weight:bold;">*</span></span>
    <input type='text' maxlength='50' name='email'
      value='$email'>-->
	  
	  <label for="email">New Email<span style="color:red;font-weight:bold;">*</span></label>
				<input id="email" name="email" type="email" value='$email' required>
	  
	  <br>
	  </div>
	  <div class="aboutf" style="padding: 30px;
    margin-top: 10px;
    width: 84%;
    background: #e6fbde;">
	  <h3>More about yourself <span style="color:#b7b7b7;">(optional)</span></h3>
	  <p style="font-size: 11px;">Tell us more about yourself so we can make the website suit you better. Those fields are not required to be filled in.</p>
	  
	  <span class='gender'>Gender</span>
    <select name="gender">
   <option value="male">Male</option>
   <option value="female">Female</option>
   <option value="other">Other</option>
</select> <br><br>
<span class='fieldname'>Date of birth</span><br>
<select name="day">
   <option value="1">1</option>
   <option value="2">2</option>
   <option value="3">3</option>
   <option value="4">4</option>
   <option value="5">5</option>
   <option value="6">6</option>
   <option value="7">7</option>
   <option value="8">8</option>
   <option value="9">9</option>
   <option value="10">10</option>
   <option value="11">11</option>
   <option value="12">12</option>
   <option value="13">13</option>
   <option value="14">14</option>
   <option value="15">15</option>
   <option value="16">16</option>
   <option value="17">17</option>
   <option value="18">18</option>
   <option value="19">19</option>
   <option value="20">20</option>
   <option value="21">21</option>
   <option value="22">22</option>
   <option value="23">23</option>
   <option value="24">24</option>
   <option value="25">25</option>
   <option value="26">26</option>
   <option value="27">27</option>
   <option value="28">28</option>
   <option value="29">29</option>
   <option value="30">30</option>
   <option value="31">31</option>
</select> 
<select name="month">
   <option value="January">January</option>
   <option value="February">February</option>
   <option value="March">March</option>
   <option value="April">April</option>
   <option value="May">May</option>
   <option value="June">June</option>
   <option value="July">July</option>
   <option value="August">August</option>
   <option value="September">September</option>
   <option value="October">October</option>
   <option value="November">November</option>
   <option value="December">December</option>
   </select> 
   <select name="year">
   <option value="2000">2000</option>
   <option value="1999">1999</option>
   <option value="1998">1998</option>
   <option value="1997">1997</option>
   <option value="1996">1996</option>
   <option value="1995">1995</option>
   <option value="1994">1994</option>
   <option value="1993">1993</option>
   <option value="1992">1992</option>
   <option value="1991">1991</option>
   <option value="1990">1990</option>
   <option value="1989">1989</option>
   <option value="1988">1988</option>
   <option value="1987">1987</option>
   <option value="1986">1986</option>
   <option value="1985">1985</option>
   <option value="1984">1984</option>
   <option value="1983">1983</option>
   <option value="1982">1982</option>
   <option value="1981">1981</option>
   <option value="1980">1980</option>
   <option value="1979">1979</option>
   <option value="1978">1978</option>
   <option value="1977">1977</option>
   <option value="1976">1976</option>
   <option value="1975">1975</option>
   <option value="1974">1974</option>
   <option value="1973">1973</option>
   <option value="1972">1972</option>
   <option value="1971">1971</option>
   <option value="1970">1970</option>
   <option value="1969">1969</option>
   <option value="1968">1968</option>
   <option value="1967">1967</option>
   <option value="1966">1966</option>
   <option value="1965">1965</option>
   <option value="1964">1964</option>
   <option value="1963">1963</option>
   <option value="1962">1962</option>
   <option value="1961">1961</option>
   <option value="1960">1960</option>
   <option value="1959">1959</option>
   <option value="1958">1958</option>
   <option value="1957">1957</option>
   <option value="1956">1956</option>
   <option value="1955">1955</option>
   <option value="1954">1954</option>
   <option value="1953">1953</option>
   <option value="1952">1952</option>
   <option value="1951">1951</option>
   <option value="1950">1950</option>
   <option value="1949">1949</option>
   <option value="1948">1948</option>
   <option value="1947">1947</option>
   <option value="1946">1946</option>
   <option value="1945">1945</option>
   <option value="1944">1944</option>
   <option value="1942">1942</option>
   <option value="1941">1941</option>
   <option value="1940">1940</option>
</select> <br><br>
<span class='fieldname'>Interests</span>
    <input type='text' maxlength='200' name='interests'
      value='$interests'><br>
	  </div>
	  <div class="location" style="padding: 30px;
    margin-top: 10px;
    width: 84%;
    background: #f1ddc9;
	margin-bottom: 20px;">
<h3>What's your location? <span style="color:#b7b7b7;">(optional)</span></h3>
<p style="font-size: 11px;">We can find the best local services for you.</p>
<span class='fieldname'>Full Name</span>
    <input type='text' maxlength='50' name='fname'
      value='$fname'><br>
    <span class='fieldname'>Street</span>
    <input type='text' maxlength='50' name='street'
      value='$street'><br>
	   <span class='fieldname'>County</span>
    <input type='text' maxlength='50' name='county'
      value='$county'><br>
	   <span class='fieldname'>Country</span>
    <input type='text' maxlength='50' name='country'
      value='$country'><br>
	  <span class='fieldname'>Post Code</span>
    <input type='text' maxlength='50' name='postcode'
      value='$postcode'><br>
	  </div>
   
	  
	  
_END;
?>



    Image: <input type='file' name='image' size='14'>
    <input type='submit' value='Save Profile'>
    </form></div><br>
  </body>
</html>
