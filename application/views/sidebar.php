  <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky p-3">
                    <h4 class="text-center font-weight-bold">My Account</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url()?>my-account"> <i class="fa fa-user"></i> Dashboard</a></li>
 
<?php
if($this->session->userdata('user_type') == 'farmer'){?>
                         <li class="nav-item"><a class="nav-link active" href="<?php echo base_url(); ?>manage-products"> <i class="fa fa-user"></i> Manage Products</a></li>
<?php } ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>manage-orders"> <i class="fa fa-gift"></i> Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Profile"> <i class="fa fa-lock"></i> Update Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Profile/change_password"> <i class="fa fa-location-arrow"></i> Change Password</a></li>
                        
                        

                    </ul>
                </div>
            </nav>
            