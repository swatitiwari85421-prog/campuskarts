<?php
$pageTitle="Login";require_once "includes/header.php";$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $email=trim($_POST['email']??'');$password=$_POST['password']??'';
 if(!filter_var($email,FILTER_VALIDATE_EMAIL)||$password==='')$error="Enter a valid email and password.";
 else{$stmt=$conn->prepare("SELECT id,name,password FROM users WHERE email=?");$stmt->bind_param("s",$email);$stmt->execute();$user=$stmt->get_result()->fetch_assoc();
  if($user&&password_verify($password,$user['password'])){session_regenerate_id(true);$_SESSION['user_id']=$user['id'];$_SESSION['user_name']=$user['name'];$_SESSION['flash']="You are now logged in.";header("Location: index.php");exit;}
  $error="Incorrect email or password.";
 }
}
?>
<div class="row justify-content-center"><div class="col-lg-5"><div class="form-card">
 <p class="text-primary fw-bold mb-1">WELCOME BACK</p><h1 class="section-title">Login</h1><p class="text-muted">Continue exploring your campus marketplace.</p>
 <?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
 <form method="post"><div class="mb-3"><label class="form-label">Email address</label><input type="email" name="email" class="form-control" required></div><div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div><button class="btn btn-campus w-100">Login</button></form>
 <p class="text-center mt-3 mb-0">New to CampusKart? <a href="register.php">Create an account</a></p>
</div></div></div>
<?php require_once "includes/footer.php"; ?>