<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author Kul Bhushan Gupta" content="">
    <link rel="shortcut icon" href="images/favicon.html">

    <title>Login</title>

    <!--Core CSS -->
    <link href="<?php echo base_url();?>assets/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

        <form class="form-signin" action="<?php echo base_url();?>index.php/login/validate_login" method="post">
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" required name="UserName" value="<?php if($this->input->cookie('remember_user',TRUE)!=null) {echo $this->input->cookie('remember_user',TRUE);}?>" class="form-control" placeholder="User ID" autofocus>
                <input type="password" required name="Password"  value="<?php if($this->input->cookie('remember_password',TRUE)!=null) {echo $this->input->cookie('remember_password',TRUE);}?>" class="form-control" placeholder="Password">
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember" name="remember"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

<!--            <div class="registration">
                Don't have an account yet?
                <a class="" href="registration.html">
                    Create an account
                </a>
            </div>-->

        </div>
    </form>
          <!-- Modal -->
          <form class="form" action="<?php echo base_url();?>index.php/login/fogetPassword" method="post">
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Enter your user name to get your password.</p>
                          <input type="text" name="username" placeholder="User Name" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="submit">Submit</button>
                      </div>
                  </div>
              </div>
          </div>
          <!-- modal -->
          </form>
          
    <?php
        if(isset($message_type))
        {
    ?>
          <div id="myModal1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: block;">
            <div class="modal-dialog">
                  <div class="modal-content ">
                      <div class="modal-header <?php echo  $message_type;?>">
                          <button type="button" class="close" onclick="close_model('myModal1');" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?php 
                          if($message_type=='success') 
                          {
                              echo ucfirst($message_type);
                          }
                          else 
                          {
                              echo "Error";
                          }
                          ?></h4>
                      </div>
                      <div class="modal-body">
                         <?php echo $message;?>
                      </div>
                      <div class="modal-footer">
                          
                      </div>
                  </div>
              </div>
          </div>
          <script>
              function close_model(modelName)
              {
                  $("#myModal1").css("display", "none");
              }
          </script>
    <?php
        }
    ?>

    </div>



    <!-- Placed js at the end of the document so the pages load faster -->

    <!--Core js-->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/bs3/js/bootstrap.min.js"></script>

  </body>

</html>