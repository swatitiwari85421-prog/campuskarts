<?php
$pageTitle="Cart";require_once "includes/header.php";require_login();
$stmt=$conn->prepare("SELECT c.id AS cart_id,c.qty,p.id,p.title,p.price,p.image,p.condition FROM cart c JOIN products p ON c.product_id=p.id WHERE c.user_id=? ORDER BY c.id DESC");
$stmt->bind_param("i",$_SESSION['user_id']);$stmt->execute();$items=$stmt->get_result();$total=0;
?>
<div class="page-heading"><p class="text-primary fw-bold mb-1">YOUR BAG</p><h1 class="section-title mb-0">Shopping cart</h1></div>
<?php if(!$items->num_rows): ?><div class="empty-state"><i class="bi bi-cart-x"></i><h4 class="mt-3">Your cart is empty</h4><p class="text-muted">Find something useful for your campus life.</p><a href="products.php" class="btn btn-campus">Explore products</a></div>
<?php else: ?>
<form method="post" action="cart_action.php"><input type="hidden" name="action" value="update">
 <div class="form-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Item</th><th>Price</th><th style="width:130px">Quantity</th><th>Subtotal</th><th></th></tr></thead><tbody>
 <?php while($item=$items->fetch_assoc()):$subtotal=$item['price']*$item['qty'];$total+=$subtotal; ?>
 <tr><td><div class="d-flex align-items-center gap-3"><img class="cart-thumb" src="<?= e($item['image']) ?>" alt=""><div><div class="fw-bold"><?= e($item['title']) ?></div><small class="text-muted"><?= e($item['condition']) ?> condition</small></div></div></td><td><?= money($item['price']) ?></td><td><input type="number" min="1" max="10" class="form-control" name="qty[<?= (int)$item['cart_id'] ?>]" value="<?= (int)$item['qty'] ?>"></td><td class="fw-bold"><?= money($subtotal) ?></td><td><a class="btn btn-sm btn-outline-danger" data-confirm="Remove this item?" href="cart_action.php?action=remove&product_id=<?= (int)$item['cart_id'] ?>"><i class="bi bi-trash"></i></a></td></tr>
 <?php endwhile; ?>
 </tbody></table></div><div class="d-flex flex-wrap justify-content-between align-items-center gap-3"><button class="btn btn-outline-primary">Update cart</button><div class="text-end"><div class="text-muted">Cart total</div><h3 class="section-title"><?= money($total) ?></h3><a href="checkout.php" class="btn btn-campus btn-lg">Proceed to checkout <i class="bi bi-arrow-right"></i></a></div></div></div>
</form>
<?php endif; ?>
<?php require_once "includes/footer.php"; ?>