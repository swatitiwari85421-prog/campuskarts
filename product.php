<?php
$pageTitle="Product Details";
require_once "includes/header.php";
$id=(int)($_GET['id'] ?? 0);
$stmt=$conn->prepare("SELECT p.*,c.name AS category,u.name AS seller FROM products p JOIN categories c ON p.category_id=c.id JOIN users u ON p.seller_id=u.id WHERE p.id=?");
$stmt->bind_param("i",$id);$stmt->execute();$product=$stmt->get_result()->fetch_assoc();
if(!$product){http_response_code(404);echo '<div class="empty-state"><h3>Product not found</h3><a href="products.php" class="btn btn-campus">Back to products</a></div>';require "includes/footer.php";exit;}
?>
<div class="row g-5 align-items-center">
 <div class="col-lg-6"><img class="product-detail-img shadow-sm" src="<?= e($product['image']) ?>" alt="<?= e($product['title']) ?>"></div>
 <div class="col-lg-6"><a href="products.php" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to products</a><p class="text-primary fw-bold mt-4 mb-1"><?= e($product['category']) ?></p><h1 class="section-title"><?= e($product['title']) ?></h1>
 <span class="badge <?= $product['condition']==='New'?'badge-new':($product['condition']==='Fair'?'badge-fair':'badge-good') ?>"><?= e($product['condition']) ?> condition</span>
 <h2 class="price mt-3"><?= money($product['price']) ?></h2><p class="text-muted mt-3"><?= nl2br(e($product['description'])) ?></p>
 <div class="info-card p-3 mb-4"><small class="text-muted">Seller</small><div class="fw-bold"><i class="bi bi-person-circle me-2"></i><?= e($product['seller']) ?></div></div>
 <form action="cart_action.php" method="post" class="d-flex gap-2"><input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>"><input type="hidden" name="action" value="add"><input type="number" name="qty" class="form-control" min="1" max="10" value="1" style="max-width:90px"><button class="btn btn-campus btn-lg">Add to Cart <i class="bi bi-cart-plus"></i></button></form>
 </div>
</div>
<?php require_once "includes/footer.php"; ?>