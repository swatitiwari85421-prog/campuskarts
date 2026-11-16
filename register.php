<?php
$pageTitle="Register"; require_once "includes/header.php";
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 $name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$phone=trim($_POST['phone']??'');$password=$_POST['password']??'';
 if($name===''||$email===''||$phone===''||$password==='')$errors[]="All fields are required.";
 if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]="Enter a valid email address.";
 if(strlen($password)<8)$errors[]="Password must contain at least 8 characters.";
 if(!$errors){
  $check=$conn->prepare("SELECT id FROM users WHERE email=?");$check->bind_param("s",$email);$check->execute();
  if($check->get_result()->num_rows)$errors[]="An account with this email already exists.";
  else{$hash=password_hash($password,PASSWORD_DEFAULT);$stmt=$conn->prepare("INSERT INTO users(name,email,password,phone) VALUES(?,?,?,?)");$stmt->bind_param("ssss",$name,$email,$hash,$phone);
   if($stmt->execute()){$_SESSION['user_id']=$stmt->insert_id;$_SESSION['user_name']=$name;$_SESSION['flash']="Welcome to CampusKart! Your account is ready.";header("Location: index.php");exit;}else $errors[]="Registration could not be completed.";}
 }
}
?>
<div class="row justify-content-center"><div class="col-lg-6"><div class="form-card">
 <p class="text-primary fw-bold mb-1">CREATE AN ACCOUNT</p><h1 class="section-title">Join CampusKart</h1><p class="text-muted">A student marketplace made for students.</p>
 <?php foreach($errors as $error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endforeach; ?>
 <form method="post" novalidate>
  <div class="mb-3"><label class="form-label">Full name</label><input class="form-control" name="name" value="<?= e($_POST['name']??'') ?>" required></div>
  <div class="mb-3"><label class="form-label">Email address</label><input class="form-control" type="email" name="email" value="<?= e($_POST['email']??'') ?>" required></div>
  <div class="mb-3"><label class="form-label">Phone number</label><input class="form-control" name="phone" value="<?= e($_POST['phone']??'') ?>" required></div>
  <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" minlength="8" required><div class="form-text">At least 8 characters.</div></div>
  <button class="btn btn-campus w-100">Create account</button>
 </form><p class="text-center mt-3 mb-0">Already registered? <a href="login.php">Login</a></p>
</div></div></div>
<?php require_once "includes/footer.php"; ?>