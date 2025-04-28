<?php include('header.php'); ?>
   <div class="container"> 
     <div class="row"> 
         <div class="col-md-12" style="padding: 12%;text-align: center;"> 
    <h2>Reset Password</h2>

    <?php echo validation_errors('<p style="color:red;">', '</p>'); ?>

    <form action="<?= base_url('auth/process_reset_password'); ?>" method="post">
        <input type="hidden" name="token" value="<?= $token; ?>">        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="New Password:" name="new_password" id="new_password" required>       
        </div>

 <div class="form-group">
       
        <input type="password" class="form-control" placeholder="Confirm Password:" name="confirm_password" id="confirm_password" required>    
        </div>
        <button type="submit">Update Password</button>
    </form>
</div>
</div>
</div>
</div>
<?php include('footer.php'); ?>
