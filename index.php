<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>
<script type="text/javascript"> 

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

</script>
<style>
html,body {margin:0; padding:0; height:100%; width:100%}
body {font-family:sans-serif; font-size:180%;}
input {font-size:130%; margin:.5em }

</style>
</head>
<body>
<form id=f method=post>

<div id=tos style="display:none; position:absolute; z-index:2; top:10%; left:10%; width:80%; height:80%; border:2px solid black; background:white ">
<iframe style="border:none" border=0 width=100% src="http://hackerdojo.pbworks.com/api_v2/op/GetPage/page/Policies/_type/html" height=80%>
</iframe>
<center><input style="margin:1em" type=button onclick="ok();" value="I agree to the terms above"></center>

</div>

<div id=thanks style="padding:3em; display:none; position:absolute; z-index:2; top:35%; left:35%; width:20%; border:2px solid black; background:#baffbc ">
  <center>Thank You</center>
</div>


<center>
<img style="margin:1.5em" src="logo.png" width=690 height=244 >

<h2>Please Sign In</h2>

E-mail: <input id=em type=text name=email>
<br>


<input type=button value=Member onclick="go('Member')"/>
<input type=button value=Guest onclick="go('Guest')"/>
<input type=button value="Event Attendee" onclick="go('Event')"/>

<input id=ttt type=hidden name=type value=""/>
<script>
function go(x) {
  if (isEmail(document.getElementById("em").value)) {
    document.getElementById("ttt").value = x;
    document.getElementById("tos").style.display = 'block';
  } else {
    alert("Please enter a valid e-mail address");
  }

}
function ok() {
  document.getElementById("tos").style.display = 'none';
  document.getElementById("thanks").style.display = 'block';
  setTimeout('document.getElementById("f").submit();',1000);
}
var isEmail_re       = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
function isEmail (s) {
   return String(s).search (isEmail_re) != -1;
}
</script>

<?
if ($_POST['email']) {
$fp = fopen('data.txt', 'a');
fwrite($fp, $_POST['email'].",".$_POST['type'].",".time()."\n");
fclose($fp);

// In addition to the following account being "insert only" permission, you will need to ask Brian to
// whitelist your IP address you wish to connect from

$link = mysql_connect('dojodb.dustball.com', 'dojoinsertonly', 'insert1line');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db('hackerdojo', $link);
if (!$db_selected) {
    die ('Can\'t use db : ' . mysql_error());
}

if ($_POST['type']) {

  $result = mysql_query(
    'insert into log (email,type,ts) values (\'' .
    mysql_real_escape_string($_POST['email'])."','" .
    mysql_real_escape_string($_POST['type'])."',now())"
  );

  if (!$result) {
      die('Invalid query: ' . mysql_error());
  }
}


}





?>
</form>
</center>


</body>
</html>
