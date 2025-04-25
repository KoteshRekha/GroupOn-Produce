<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>Groupon Produce</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo base_url() ?>assets/images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">
    <!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (Make sure jQuery is included before Toastr) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style type="text/css">
    
    .navbar-brand {
    font-size: 24px;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #008080 !important; /* Teal color */
}
#paginationControls
{margin-left: 2%;}
#orderPaginationControls
{margin-left: 2%;}
</style>
</head>

<body>
    <!-- Start Main Top -->
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				
                   <!-- <div class="right-phone-box">
                        <p>Call US :- <a href="#"> +11 900 800 100</a></p>
                    </div>-->
                    <div class="our-link">
                        <ul>
                            <?php if ($this->session->userdata('logged_in')) { ?>

                                <li><a href="<?php echo base_url()?>my-account"><i class="fa fa-user s_color"></i> My Account</a></li>
                            <?php } ?>
                            <!--<li><a href="#"><i class="fa fa-user s_color"></i> My Account</a></li>
                            <li><a href="#"><i class="fas fa-location-arrow"></i> Our location</a></li>
                            <li><a href="#"><i class="fas fa-headset"></i> Contact Us</a></li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="login-box d-flex">
				<!--		<select id="basic" class="selectpicker show-tick form-control" data-placeholder="Sign In">
							<option>Register Here</option>
							<option>Sign In</option>
						</select>-->
                       
			
               <?php if ($this->session->userdata('logged_in')) {?>
    <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-danger">Logout</a>
<?php } else{ ?>

 <select id="authDropdown" class="selectpicker form-control">
    <option value="">Select an Option</option>
    <option value="register">Register Here</option>
    <option value="login">Sign In</option>
</select>
<?php  } ?> 	
<script>
<?php if ($this->session->flashdata('success')): ?>
    toastr.success("<?= $this->session->flashdata('success'); ?>");
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')): ?>
    toastr.error("<?= $this->session->flashdata('error'); ?>");
  <?php endif; ?>
</script>
<!-- Login & Register Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <h2 class="modal-title" id="loginModalLabel">Sign In</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>               
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" class="form-control" id="login-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" class="form-control" id="login-password" name="password" required>
                    </div>
                    <a href="<?php echo base_url(); ?>Auth/forgot_password">Forgot Password</a>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="registerModalLabel">Register</h2>
            </div>
            <div class="modal-body">
                <form id="registerForm">
                    <div class="form-group">
                        <label for="user-type">I am a</label>
                        <select class="form-control" id="user-type" name="user_type" required>
                            <option value="farmer">Farmer</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="register-first-name">First Name</label>
                            <input type="text" class="form-control" id="register-first-name" name="first_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="register-last-name">Last Name</label>
                            <input type="text" class="form-control" id="register-last-name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group">
    <label for="register-email">Email</label>
    <input 
        type="email" 
        class="form-control" 
        id="register-email" 
        name="email" 
        maxlength="100" 
        required
    >
</div>

                    <div class="form-group">
    <label for="register-phone">Phone Number</label>
    <input 
        type="tel" 
        class="form-control" 
        id="register-phone" 
        name="phone" 
        maxlength="10" 
        pattern="^\d{1,10}$"
        title="Please enter a valid phone number (up to 10 digits)" 
        required
    >
</div>
                    <div class="form-group">
                        <label for="register-address">Address</label>
                        <input type="text" class="form-control" id="register-address" name="address"  required>
                    </div>
                 
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="register-state">State</label>
                            <input type="text" class="form-control" id="register-state" name="state"  required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="register-city">City</label>
                            <input type="text" class="form-control" id="register-city" name="city"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="register-postal-code">Postal Code</label>
                        <input type="text" class="form-control" id="register-postal-code" name="postal_code" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="register-password">Password</label>
                            <input type="password" class="form-control" name="password" id="register-password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="register-confirm-password">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" id="register-confirm-password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
  </div>                     
       </div>          

                   <!-- <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT80
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT30
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now 
                                </li>
                            </ul>
                        </div>
                    </div>-->
               
            </div>
        </div>
    </div>
    <!-- End Main Top -->

  
    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation 
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
         <a class="navbar-brand fw-bold text-success" href="<?php echo base_url(); ?>">Groupon Produce</a>

                </div>-->
                <div class="navbar-header">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
    </button>
    <a class="navbar-brand" href="<?php echo base_url(); ?>">
        <img src="<?php echo base_url('assets/images/grouponLogo2.png'); ?>" alt="Groupon Produce" style="height: 100px;">
    </a>
</div>

                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item <?php echo ($this->uri->uri_string() == '') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
</li>

                       
                       <li class="nav-item <?php echo ($this->uri->segment(1) == 'about') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo base_url(); ?>about">About Us</a>
</li>
<li class="nav-item <?php echo ($this->uri->segment(1) == 'shop') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo base_url(); ?>shop">Shop</a>
</li>
<li class="nav-item <?php echo ($this->uri->segment(1) == 'contact') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo base_url(); ?>contact">Contact Us</a>
</li>

                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                 <?php if($this->session->userdata('user_type') == 'farmer'){ ?>

               <?php } else {?>
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        <li class="side-menu" id="side-menu">
                            <a href="<?= base_url('cart/view'); ?>">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="badge" id="cart_count">0</span>
                                <p>My Cart</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php } ?>
                <!-- End Atribute Navigation -->
            </div>
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    <ul class="cart-list" id="cart_list">

                          <?php 
                          
                          if (!empty($cart_items)): ?>
        <?php foreach ($cart_items as $item): ?>

            <li>
                            <a href="#" class="photo"><img src="<?php echo base_url() ?>assets/images/img-pro-01.jpg" class="cart-thumb" alt="" /></a>
                            <h6><a href="#"><?= $item['name']; ?> </a></h6>
                            <p><?= $item['quantity']; ?>x - <span class="price">$<?= number_format($item['price'] * $item['quantity'], 2); ?></span></p>
                        </li>

            <?php endforeach; ?>
    <?php else: ?>
        <li>
                        <span class="float-right"><strong>Cart is Empty</span>
                        </li>
         <?php endif; ?>
                        
                       
                        <li class="total">
                            <a href="<?php echo base_url();?>cart/view" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                            <span class="float-right"><strong>Total</strong>: $180.00</span>
                        </li>
                    </ul>
                </li>
            </div>
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
      <!-- Start Top Search -->
    <div class="top-search">
    <div class="container">
        <!-- Wrap the input-group in a form -->
        <form action="<?= base_url('search/results'); ?>" method="get">
            <div class="input-group">
                <!-- Search icon -->
                <span class="input-group-addon">
                    <i class="fa fa-search"></i>
                </span>
                
                <!-- Search field -->
                <input 
                    type="text" 
                    class="form-control" 
                    name="q" 
                    placeholder="Search" 
                    required
                >

                <!-- Close icon (to hide/close the search bar) -->
                <span class="input-group-addon close-search">
                    <i class="fa fa-times"></i>
                </span>
            </div>
        </form>
    </div>
</div>

    <!-- End Top Search -->