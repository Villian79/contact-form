<?php 
  //Message vars
  $msg = '';
  $msgClass = '';

  if(filter_has_var(INPUT_POST, 'submit')){
    //Get form data
    $email    = htmlspecialchars($_POST['email']);
    $name     = htmlspecialchars($_POST['name']);
    $message  = htmlspecialchars($_POST['message']);

    //Check required fields
    if(!empty($name) && !empty($email) && !empty($message)){
      //Passed
      if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        //Failed
        $msg = 'Please submit a valid email address';
        $msgClass = 'alert-danger';
      }
      else{
        //Passed
        //Email vars
        $toEmail  = 'ivilinchuk@gmail.com';
        $subject  = 'Contact request from '.$name;
        $body     = '<h2>Contact Request</h2>
                      <h4>Name</h4><p>'.$name.'</p>
                      <h4>Email</h4><p>'.$email.'</p>
                      <h4>Message</h4><p>'.$message.'</p>';
        //Email headers
        $headers  = 'MIME-Version: 1.0' .'\r\n';
        $headers .= 'Content-Type:text/html;charset:UTF-8' .'\r\n';

        //Additional headers
        $headers .= 'From: ' .$name. '<'.$email.'>' .'\r\n';

        if(mail($email, $subject, $body, $headers)){
          $msg = 'Your message was sent successfully';
          $msgClass = 'alert-success';
        }
        else{
          $msg = 'Your message has not been sent';
          $msgClass = 'alert-danger';
        }
      }
    }
    else{
      //Failed
      $msg = 'Please fill in all fields';
      $msgClass = 'alert-danger';
    }
  };
?>

<!DOCTYPE html>
<html>
<head>
  <title>Contact Us</title>
  <link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.min.css">
</head>
<body>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">My Website</a>
      </div>
    </div>
  </nav>
  <div class="container">
    <?php if($msg != ''): ?>
      <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" 
            value="<?php echo (isset($_POST['name'])) ? $name : ""; ?>">
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" 
            value="<?php echo (isset($_POST['email'])) ? $email : ""; ?>">
          <small class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        
        <div class="form-group">
          <label for="message">Enter</label>
          <textarea class="form-control" id="message" name="message">
            <?php echo (isset($_POST['message'])) ? $message : "";?>
          </textarea>
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </fieldset>
    </form>
  </div>
</body>
</html>