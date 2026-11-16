<?php
ob_start();
$pageTitle="Checkout";require_once "includes/header.php";require_login();
$userId=(int)$_SESSION['user_id'];
$stmt=$conn->prepare("SELECT c.qty,p.id,p.title,p.price FROM cart c JOIN products p ON c.product_id=p.id WHERE c.user_id=?");$stmt->bind_param("i",$userId);$stmt->execute();$items=$stmt->get_result();$total=0;$rows=[];
while($r=$items->fetch_assoc()){$rows[]=$r;$total+=$r['qty']*$r['price'];}
if(!$rows){$_SESSION['flash']="Your cart is empty.";header("Location: cart.php");exit;}
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $address=trim($_POST['address']??'');
 if(strlen($address)<10)$error="Please enter a complete delivery address.";
 else{
  $conn->begin_transaction();
  try{
   $order=$conn->prepare("INSERT INTO orders(user_id,total,address) VALUES(?,?,?)");$order->bind_param("ids",$userId,$total,$address);$order->execute();$orderId=$order->insert_id;
   $clear=$conn->prepare("DELETE FROM cart WHERE user_id=?");$clear->bind_param("i",$userId);$clear->execute();$conn->commit();
   $_SESSION['last_order_id']=$orderId;header("Location: order_confirmation.php");exit;
  }catch(Throwable $ex){$conn->rollback();$error="We could not place your order. Please try again.";}
 }
}
?>
<div class="page-heading"><p class="text-primary fw-bold mb-1">ALMOST THERE</p><h1 class="section-title mb-0">Checkout</h1></div>
<div class="row g-4"><div class="col-lg-7"><div class="form-card"><h4 class="section-title mb-3">Delivery address</h4><?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post"><label class="form-label">Full address</label><textarea class="form-control mb-3" name="address" rows="5" placeholder="House/hostel, room number, street, city, state, PIN code" required><?= e($_POST['address']??'') ?></textarea><button class="btn btn-campus btn-lg">Place order <i class="bi bi-check-circle"></i></button></form></div></div>
<div class="col-lg-5"><div class="form-card"><h4 class="section-title">Order summary</h4><?php foreach($rows as $r): ?><div class="d-flex justify-content-between py-2 border-bottom"><span><?= e($r['title']) ?> × <?= (int)$r['qty'] ?></span><strong><?= money($r['price']*$r['qty']) ?></strong></div><?php endforeach; ?><div class="d-flex justify-content-between mt-3"><span class="fw-bold">Total</span><h4 class="price"><?= money($total) ?></h4></div><small class="text-muted">Please review your items before placing the order.</small></div></div></div>
<?php require_once "includes/footer.php"; ?>