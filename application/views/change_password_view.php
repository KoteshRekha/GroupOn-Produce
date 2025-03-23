<?php include('header.php'); ?>
<?php include('sidebar.php')?>
<div class="col-md-9">
    <h2>Change Password</h2>

    <!-- Display success or error flash messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- Display validation errors -->
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <form action="<?= base_url('profile/update_password'); ?>" method="post">
        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" name="old_password" id="old_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
            <small class="text-muted">At least 6 characters</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

<?php include('footer.php'); ?>
