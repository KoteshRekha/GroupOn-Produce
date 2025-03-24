<?php include('header.php'); ?>
   <div class="container"> 
     <div class="row"> 
         <div class="col-md-12" style="padding: 12%;text-align: center;"> 
    <h2>Forgot Password</h2>

    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?= $this->session->flashdata('error'); ?></p>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <p style="color:green;"><?= $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <?php echo validation_errors('<p style="color:red;">', '</p>'); ?>

    <form action="<?= base_url('auth/process_forgot_password'); ?>" method="post">
      <div class="col-md-12">
<div class="form-group row">
      <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email:" required>
        
</div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>
</div>
</div>
<?php include('footer.php'); ?>
