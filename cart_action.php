<?php
require_once "config/db.php";
require_once "includes/functions.php";
require_login();
$action=$_POST['action']??$_GET['action']??'';$productId=(int)($_POST['product_id']??$_GET['product_id']??0);$userId=(int)$_SESSION['user_id'];
if($action==='add'&&$productId>0){
 $qty=max(1,min(10,(int)($_POST['qty']??1)));
 $check=$conn->prepare("SELECT id FROM products WHERE id=?");$check->bind_param("i",$productId);$check->execute();
 if($check->get_result()->num_rows){$stmt=$conn->prepare("INSERT INTO cart(user_id,product_id,qty) VALUES(?,?,?) ON DUPLICATE KEY UPDATE qty=LEAST(qty+VALUES(qty),10)");$stmt->bind_param("iii",$userId,$productId,$qty);$stmt->execute();$_SESSION['flash']="Item added to your cart.";}
}else if($action==='update'){
 foreach(($_POST['qty']??[]) as $cartId=>$quantity){$cartId=(int)$cartId;$quantity=max(1,min(10,(int)$quantity));$stmt=$conn->prepare("UPDATE cart SET qty=? WHERE id=? AND user_id=?");$stmt->bind_param("iii",$quantity,$cartId,$userId);$stmt->execute();}
 $_SESSION['flash']="Cart updated.";
}else if($action==='remove'&&$productId>0){$stmt=$conn->prepare("DELETE FROM cart WHERE id=? AND user_id=?");$stmt->bind_param("ii",$productId,$userId);$stmt->execute();$_SESSION['flash']="Item removed from cart.";}
header("Location: cart.php");exit;
?>