<?php include('header.php')?>
<?php include('sidebar.php')?>
<style type="text/css">
    h3,h5{
        color: #fff;
    }
  
</style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-9 px-4">
    <h2>Welcome, <?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></h2>
    <div class="row" style="margin-top:1%;">
        <div class="col-md-4">
            <div class="card p-3 text-white bg-primary">
                <h5>Total Orders</h5>
                <h3><?php echo $total_orders; ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-white bg-success">
               <?php if($this->session->userdata('user_type')=='farmer'){?> <h5>Total Earnings</h5>
           <?php } else {?>
<h5>Total Spent</h5>
           <?php } ?>
                <h3>$ <?php echo number_format($total_earnings, 2); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-white bg-warning">
                <h5>Pending Orders</h5>
                <h3><?php echo $pending_orders; ?></h3>
            </div>
        </div>
    </div>


 
     <div class="row" style="margin-top:1%;margin-bottom:1%;">
        <div class="col-md-4">
            <div class="card p-3 text-white bg-info">
                <h5>Order Placed</h5>
                <h3><?php echo $placed_orders; ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-white bg-dark">
               
<h5>Completed Orders</h5>
          
                <h3><?php echo $completd_orders; ?></h3>
            </div>
        </div>
         <div class="col-md-4">
            <div class="card p-3 text-white bg-success">
               
<h5>Total Messages</h5>
          
                <h3><?php echo $total_messages; ?></h3>
            </div>
        </div>
    </div>
     <?php if($this->session->userdata('user_type')=='farmer'){?>
    <div class="row" style="margin-top:1%;margin-bottom:1%;">
       
        <div class="col-md-4">
            <div class="card p-3 text-white bg-info">
                <h5>Total Prducts</h5>
                <h3><?php echo $total_products; ?></h3>
            </div>
        </div>
    </div>
     <?php } ?>
</main>
</div>
</div>
<?php include('footer.php')?>
