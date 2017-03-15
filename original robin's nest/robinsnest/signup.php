<?php // Example 26-5: signup.php
  require_once 'header.php';
error_reporting(0);
?>
<!--<script>
function validateForm() {
    var x = document.forms["myForm"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        return false;
    }
}
</script>-->

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
  echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        O('info').innerHTML = ''
        return
      }

      params  = "user=" + user.value
      request = new ajaxRequest()
      request.open("POST", "checkuser.php", true)
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      request.setRequestHeader("Content-length", params.length)
      request.setRequestHeader("Connection", "close")

      request.onreadystatechange = function()
      {
        if (this.readyState == 4)
          if (this.status == 200)
            if (this.responseText != null)
              O('info').innerHTML = this.responseText
      }
      request.send(params)
    }

    function ajaxRequest()
    {
      try { var request = new XMLHttpRequest() }
      catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
          try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          catch(e3) {
            request = false
      } } }
      return request
    }
  </script>
  <div class='main'><h3>Please enter your details to sign up</h3>
  <p>Fields with <span style="color:red;font-weight:bold;">*</span> <strong>MUST</strong> be filled in</p>
_END;




  $error = $user = $pass = "";
  if (isset($_SESSION['user'])) destroySession();
  
  
  $user = "Please fill in";
    $pass = "Please fill in";
	$email = "Please fill in";
	$gender = "Please fill in";
	$age =  "Please fill in";
     $interests = "Please fill in";
	$location = "Please fill in";


  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
	
	//$passnew = password_hash($pass, PASSWORD_DEFAULT);
	//echo $passnew;
	//echo $hashed_password;
	$email = sanitizeString($_POST['email']);
	$gender = sanitizeString($_POST['gender']);
	$age = sanitizeString($_POST['year']);
     $interests = sanitizeString($_POST['interests']);
	$location = sanitizeString($_POST['postcode']);
	
	//if(password_verify($pass, $hashed_password)) {

    if ($user == "" || $pass == "")
      $error = "Not all fields were entered<br><br>";
	
    else
    {
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");

      if ($result->num_rows)
        $error = "That username already exists<br><br>";
      else
      {
        queryMysql("INSERT INTO members VALUES('$user', '$pass', '$email', '$gender', '$age', '$location', '$interests')");
        die("<h4>Account created</h4>Please Log in.<br><br>");
      }
    }
  }
  //}

  echo <<<_END
  <div class="signupred" style="background: #f7c8c8;
    padding: 30px;
    margin-top: 30px;
    width: 84%;">
  <h3>Login Details</h3>
  <p style="font-size: 11px;">Please fill in the form underneath. These will be your login details.</p>
    <form name="myForm" method='post' action='signup.php' class="cmxform" id="commentForm">$error
    <!--<span class='fieldname'>Username<span style="color:red;font-weight:bold;">*</span></span>
    <input type='text' maxlength='16' name='user' value='$user'
      onBlur='checkUser(this)'><span id='info' value='$user'
      onBlur='checkUser(this)'></span>-->
	  
<label for="user">Username<span style="color:red;font-weight:bold;">*</span></label>
				<input id="user" name="user" type="text" value='$user' required><br>
	  
	  
    <!---<span class='fieldname'>Password<span style="color:red;font-weight:bold;">*</span></span>
    <input type='password' maxlength='16' name='pass'
      value='$pass'>-->
	  
	  <label for="pass">Password<span style="color:red;font-weight:bold;">*</span></label>
				<input id="pass" name="pass" type="password" value='$pass' required>
	  <br>
	  
	  
	   <!--<span class='fieldname'>Email<span style="color:red;font-weight:bold;">*</span></span>
    <input type='text' maxlength='50' name='email'
      value='$email'>-->
	  
	  <label for="email">Email<span style="color:red;font-weight:bold;">*</span></label>
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

    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Sign up'>
    </form></div><br>
  </body>
</html>
