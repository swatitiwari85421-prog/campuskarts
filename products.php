<?php
$pageTitle="Products";
require_once "includes/header.php";
$search=trim($_GET['search'] ?? '');
$category=(int)($_GET['category'] ?? 0);
$minPrice=isset($_GET['max_price']) && $_GET['max_price']!=='' ? (float)$_GET['max_price'] : 0;
$sql="SELECT p.*, c.name AS category FROM products p JOIN categories c ON p.category_id=c.id WHERE 1=1";
$params=[]; $types="";
if($search!==""){ $sql.=" AND (p.title LIKE ? OR p.description LIKE ?)"; $like="%$search%"; $params[]=$like; $params[]=$like; $types.="ss"; }
if($category>0){$sql.=" AND p.category_id=?";$params[]=$category;$types.="i";}
if($minPrice>0){$sql.=" AND p.price<=?";$params[]=$minPrice;$types.="d";}
$sql.=" ORDER BY p.created_at DESC";
$stmt=$conn->prepare($sql);
if($params)$stmt->bind_param($types,...$params);
$stmt->execute(); $products=$stmt->get_result();
$categories=$conn->query("SELECT * FROM categories ORDER BY name");
?>
<div class="page-heading"><p class="text-primary fw-bold mb-1">CAMPUS MARKETPLACE</p><h1 class="section-title mb-1">Explore products</h1><p class="text-muted mb-0">Discover affordable finds listed by fellow students.</p></div>
<form class="form-card mb-4" method="get">
 <div class="row g-3 align-items-end">
  <div class="col-md-5"><label class="form-label fw-semibold">Search</label><input class="form-control" name="search" value="<?= e($search) ?>" placeholder="Search books, gadgets..."></div>
  <div class="col-md-3"><label class="form-label fw-semibold">Category</label><select class="form-select" name="category"><option value="0">All categories</option><?php while($c=$categories->fetch_assoc()): ?><option value="<?= (int)$c['id'] ?>" <?= $category===(int)$c['id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endwhile; ?></select></div>
  <div class="col-md-2"><label class="form-label fw-semibold">Budget</label><select class="form-select" name="max_price"><option value="">Any price</option><?php foreach([200,500,1000,2000] as $v): ?><option value="<?= $v ?>" <?= $minPrice===$v?'selected':'' ?>>Under ₹<?= $v ?></option><?php endforeach; ?></select></div>
  <div class="col-md-2 d-grid"><button class="btn btn-campus">Filter <i class="bi bi-search"></i></button></div>
 </div>
</form>
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="section-title mb-0">Available items</h4><span class="text-muted small"><?= $products->num_rows ?> result(s)</span></div>
<div class="row g-4 mb-5">
<?php if($products->num_rows): while($p=$products->fetch_assoc()): ?><div class="col-6 col-md-4 col-lg-3"><?php include "includes/product_card.php"; ?></div><?php endwhile; else: ?>
 <div class="col-12"><div class="empty-state"><i class="bi bi-search"></i><h5 class="mt-2">No matching products</h5><p class="text-muted">Try changing your search or filters.</p></div></div>
<?php endif; ?>
</div>

<section id="sell-item" class="form-card">
 <div class="row align-items-center mb-3"><div class="col-md-8"><p class="text-primary fw-bold mb-1">INNOVATIVE FEATURE</p><h2 class="section-title">Sell your item</h2><p class="text-muted mb-0">Give your books and gadgets a second life. Login is required to publish a listing.</p></div><div class="col-md-4 text-md-end"><i class="bi bi-recycle display-3 text-primary"></i></div></div>
 <?php if(!is_logged_in()): ?><a href="login.php" class="btn btn-campus">Login to list an item</a>
 <?php else: ?>
 <form action="sell.php" method="post" class="row g-3">
  <div class="col-md-6"><label class="form-label">Item title</label><input name="title" class="form-control" required maxlength="160"></div>
  <div class="col-md-3"><label class="form-label">Price (₹)</label><input name="price" type="number" min="1" step="0.01" class="form-control" required></div>
  <div class="col-md-3"><label class="form-label">Condition</label><select name="condition" class="form-select"><option>New</option><option selected>Good</option><option>Fair</option></select></div>
  <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select" required><?php $cs=$conn->query("SELECT * FROM categories");while($c=$cs->fetch_assoc()): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['name']) ?></option><?php endwhile; ?></select></div>
  <div class="col-md-8"><label class="form-label">Image URL</label><input name="image" type="url" class="form-control" placeholder="https://..." required></div>
  <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3" maxlength="2000"></textarea></div>
  <div class="col-12"><button class="btn btn-campus">Publish listing <i class="bi bi-plus-circle"></i></button></div>
 </form>
 <?php endif; ?>
</section>
<?php require_once "includes/footer.php"; ?>