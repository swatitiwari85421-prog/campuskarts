<?php
$pageTitle = "Home";
require_once "includes/header.php";
$featured = $conn->query("SELECT p.*, c.name AS category FROM products p JOIN categories c ON p.category_id=c.id ORDER BY p.created_at DESC LIMIT 4");
$categories = $conn->query("SELECT * FROM categories ORDER BY name");
?>
<section class="hero mb-5">
 <div class="hero-content">
  <span class="badge text-bg-warning mb-3">THE STUDENT MARKETPLACE</span>
  <h1>Good finds.<br>Better campus life.</h1>
  <p class="lead my-3">Buy and sell pre-loved books, gadgets and campus essentials at student-friendly prices.</p>
  <a href="products.php" class="btn btn-campus-yellow btn-lg me-2">Explore products <i class="bi bi-arrow-right"></i></a>
  <a href="products.php#sell-item" class="btn btn-outline-light btn-lg">Sell your item</a>
 </div>
</section>

<section class="mb-5">
 <div class="d-flex justify-content-between align-items-end mb-3"><div><p class="text-primary fw-bold mb-1">SHOP BY CATEGORY</p><h2 class="section-title mb-0">Find what you need</h2></div><a href="products.php" class="text-decoration-none">View all <i class="bi bi-arrow-right"></i></a></div>
 <div class="row g-3">
 <?php $icons=['Textbooks'=>'bi-book-half','Electronics'=>'bi-headphones','Stationery'=>'bi-pencil-square','Hostel Essentials'=>'bi-house-heart']; ?>
 <?php while($cat=$categories->fetch_assoc()): ?>
  <div class="col-6 col-lg-3"><a class="text-decoration-none text-dark" href="products.php?category=<?= (int)$cat['id'] ?>">
   <div class="category-card p-4 h-100"><div class="category-icon mb-3"><i class="bi <?= $icons[$cat['name']] ?? 'bi-bag' ?>"></i></div><h5 class="fw-bold mb-1"><?= e($cat['name']) ?></h5><small class="text-muted">Explore listings</small></div>
  </a></div>
 <?php endwhile; ?>
 </div>
</section>

<section class="mb-4">
 <div class="d-flex justify-content-between align-items-end mb-3"><div><p class="text-primary fw-bold mb-1">FRESH ON CAMPUS</p><h2 class="section-title mb-0">Featured items</h2></div><a href="products.php" class="text-decoration-none">Browse marketplace <i class="bi bi-arrow-right"></i></a></div>
 <div class="row g-4">
 <?php if($featured && $featured->num_rows): while($p=$featured->fetch_assoc()): ?>
  <div class="col-6 col-lg-3"><?php include "includes/product_card.php"; ?></div>
 <?php endwhile; else: ?>
  <div class="col-12"><div class="empty-state"><i class="bi bi-bag"></i><h5 class="mt-2">Listings are coming soon!</h5><p class="text-muted">Register and list the first item on CampusKart.</p><a href="register.php" class="btn btn-campus">Get started</a></div></div>
 <?php endif; ?>
 </div>
</section>
<?php require_once "includes/footer.php"; ?>