<html> 
<body> 
<div> 
<form action="page2.php" method="post"> 
<p>Page 1 Data Collection:</p> 
<input type="hidden" name="submitted" value="yes" /> 
Your Name: <input type="text" name="yourname" maxlength="150" /><br /><br /> 
<input type="submit" value="Submit" style="margin-top: 10px;" /> 
</form> 
</div> 
</body> 
</html> 


<html> 
<body> 
<div> 
<form action="page3.php" method="post"> 
<p>Page 2 Data Collection:</p> 
Selection: 
<select name="yourselection"> 
<option value="nogo">make a selection...</option> 
<option value="1">Choice 1</option> 
<option value="2">Choice 2</option> 
<option value="3">Choice 3</option> 
</select> 
<input type="hidden" name="yourname" . 
value="<?php echo $_POST['yourname']; ?>" /> 
<input type="submit" value="Submit" style="margin-top: 10px;" /> 
</form> 
</div> 
</body> 
</html> 


<html> 
<body> 
<form action="page4.php" method="post"> 
<p>Page 3 Data Collection:</p> 
Your Email: <input type="text" name="youremail" maxlength="150" /><br /> 
<input type="hidden" name="yourname". 
value="<?php echo $_POST['yourname']; ?>" /> 
<input type="hidden" name="yourselection". 
value="<?php echo _POST['yourselection']; ?>" /> 
<input type="submit" value="Submit"/> 
</form> 
</body> 
</html> 


<html> 
<body> 
<?php 
echo "Your Name: " . $_POST['yourname'] . "<br />"; 
echo "Your Selection: " . $_POST['yourselection'] . "<br />"; 
echo "Your Email: " . $_POST['youremail'] . "<br />"; 
?> 
<a href="page1.php">Try Again</a> 
</body> 
</html>