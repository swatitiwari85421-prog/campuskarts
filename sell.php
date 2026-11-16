<?php
require_once "config/db.php";require_once "includes/functions.php";require_login();
$title=trim($_POST['title']??'');$price=(float)($_POST['price']??0);$condition=$_POST['condition']??'Good';$image=trim($_POST['image']??'');$category=(int)($_POST['category_id']??0);$description=trim($_POST['description']??'');
$validConditions=['New','Good','Fair'];
if($title===''||$price<=0||!filter_var($image,FILTER_VALIDATE_URL)||$category<=0||!in_array($condition,$validConditions,true)){
 $_SESSION['flash']="Please complete all listing fields with valid values.";header("Location: products.php#sell-item");exit;
}
$stmt=$conn->prepare("INSERT INTO products(title,price,`condition`,image,category_id,seller_id,description) VALUES(?,?,?,?,?,?,?)");
$stmt->bind_param("sdssiis",$title,$price,$condition,$image,$category,$_SESSION['user_id'],$description);
if($stmt->execute())$_SESSION['flash']="Your item is now listed on CampusKart!";
else $_SESSION['flash']="Could not publish your listing. Please try again.";
header("Location: products.php");exit;
?>