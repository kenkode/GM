<?php 
 

error_reporting(E_ALL);
ini_set('display_errors','1');
?>


<?php 
include_once('sscripts/connect_to_mysql.php');

if(isset($_POST['product_name'])){	
$product_name=($_POST['product_name']);
$phone=($_POST['phone']);
$price=($_POST['price']);
$category=($_POST['category']);
$subcategory=($_POST['subcategory']);
$details=($_POST['details']);
$location=($_POST['location']);



	
	$sqlin = "insert into products  (prod_name,price,details,category,subcategory,date_added,PhoneNo,Location) values ('".$product_name."','".$price."','".$details."','".$category."','".$subcategory."',now(),'".$phone."','".$location."')";
	mysql_query($sqlin)or die(mysql_error());
	$pid=mysql_insert_id();
	
	$newname="$pid.jpg";
	move_uploaded_file($_FILES['product_image']['tmp_name'],"inventory_images/$newname");
	header("location:addads.php");
	exit();
	}
?>



 <html>
<head>
 <title>.::postads</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
 <body>
 <nav class="fixed-nav-bar">
<?php include_once("header.php");?>
</nav>
<br>
&nbsp;
 
    


<div id="dinv">
<br>
<h1 align="center"> POST THE AD HERE</h1>
<form action="addads.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
<table cellspacing="0"cellpadding="6px">
<tr>
<td width="20%" align="right">Product Name</td>
<td width="80%">
  <input type="text" name="product_name" id="product_name"size="64" required>
</td>
</tr>
<tr>
<td width="20%" align="right">Phone number</td>
<td width="80%">
  <input type="text" name="phone" id="phone"size="64" required>
</td>
</tr>
<tr>
<td align="right">Product Price</td>
<td>
   Ksh<input type="text" name="price" id="price"size="12" required>
</td>
</tr>
<tr>
<td align="right">Location</td>
<td>
   <input type="text" name="location" id="location" size="64" placeholder="e.g County,subcounty" required>
</td>
</tr>
<tr>
<td align="right">Category</td>
<td>
<select name="category" id="category">
<option value="Farm Product">Farm Product</option>
<option value="Animal Product"> Animal Product</option>
</select>
</td>
</tr>
<tr>
<td align="right">Subcategories</td>
<td>
<select name="subcategory" id="subcategory">
<option value=""></option>
<option value="Milk">Milk</option>
<option value="Potatoes">Potatoes</option>
<option value="Tomatoes">Tomatoes</option>
<option value="Bananas">Bananas</option>
<option value="Beans">Beans</option>
<option value="Maize">Maize</option>
<option value="pepper">Pepper</option>
<option value="Beef">Beef</option>
<option value="Mutton">Mutton</option>
<option value="Pork">Pork</option> 
<option value="Sweetpotato">Sweetpotato</option>

</select></td>
</tr>
<tr>
  <td align="right">Product Details</td>
  <td>
    <textarea name="details" id="product_details" cols="64" rows="5" required></textarea>
</td>
</tr>
<tr>
  <td height="60" align="right">product Image</td>
  <td>
    <input type="file" name="product_image" id="product_image" required>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
  <input type="submit" name="add_items" id="add_items" value="Post AD">
</td>
</tr>
</table>
</form>
</div>
</div>


<div id="pageFooter">
<?php
include_once "footer.php";
?>
</div>
 

 </body>
 </html>