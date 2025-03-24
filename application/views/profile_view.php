<?php include('header.php'); ?>
<?php include('sidebar.php')?>
<div class="main-content col-md-9">
    <h2>Update Profile</h2>

    <!-- Display success or error flash messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- Display validation errors -->
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <form action="<?= base_url('profile/update'); ?>" method="post">
<div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" 
                   value="<?= set_value('first_name', $user->first_name); ?>" required>
        </div>
            <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" 
                   value="<?= set_value('last_name', $user->last_name); ?>" required>
        </div>
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" 
                   value="<?= set_value('mobile', $user->phone); ?>" required>
        </div>
<div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?= set_value('email', $user->email); ?>" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" 
                   value="<?= set_value('address', $user->address); ?>" required>
        </div>        

        <div class="form-group">
            <label>State</label>
            <input type="text" name="state" class="form-control" 
                   value="<?= set_value('state', $user->state); ?>" required>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" 
                   value="<?= set_value('city', $user->city); ?>" required>
        </div>

        <div class="form-group">
            <label>Postal Code</label>
            <input type="text" name="postal_code" class="form-control" 
                   value="<?= set_value('postal_code', $user->postal_code); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>

    </form>
</div>
</div>
   
</div>

<?php include('footer.php'); ?>
