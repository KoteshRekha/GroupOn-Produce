<?php include('header.php')?>
<?php include('sidebar.php')?>
<div class="main-content">
    <?php if($this->session->userdata('user_type') === 'farmer'){ ?>
                   <h2>Manage Orders</h2>

                    <?php } else {?>
 <h2>Your Orders</h2>
                    <?php } ?>
        
        <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php  //echo $this->session->userdata('user_id'); ?>
      <table class="table" >
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <?php if($this->session->userdata('user_type') === 'farmer'){ ?>
                   <th>Actions</th>

                    <?php } ?>
                    
                </tr>
            </thead>
            <tbody id="orderTableBody">
               
            </tbody>
        </table>
        <div id="orderPaginationControls"></div>

    </div>
</div>

</div>
<?php include('footer.php')?>
<script>
    $(document).ready(function() {
    let limit = 5; // Orders per page
    let offset = 0; // Start from first page
 var userType = "<?= $this->session->userdata('user_type'); ?>";
    function loadOrders(offset) {
        $.ajax({
             url: "<?= base_url('order/get_orders') ?>",
            type: "GET",
            data: { limit: limit, offset: offset },
            dataType: "json",
            success: function(response) {
                console.log(response);
                let tableRows = "";
                $.each(response.orders, function(index, order) {

                    if(userType == 'farmer'){

 tableRows += `
                        <tr>
                            <td>${order.id}</td>
                            <td>${order.customer}</td>
                            <td>${order.product_name}</td>
                            <td>${order.quantity} ${order.unit}</td>
                            <td>$ ${order.total_price}</td>
                            <td>${order.order_status}</td>
                             <td>
                            <select class="order-status form-control" data-id="${order.id}">
                                <option value="Order Placed" ${order.order_status === 'Order Placed' ? 'selected' : ''}>Order Placed</option>
                                <option value="Shipped" ${order.order_status === 'Shipped' ? 'selected' : ''}>Shipped</option>
                                <option value="Delivered" ${order.order_status === 'Delivered' ? 'selected' : ''}>Delivered</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-danger delete-order">Delete</button>
                        </td>
                        </tr>                    
                    `;

                    }else{
                         tableRows += `
                        <tr>
                            <td>${order.id}</td>
                            <td>${order.customer}</td>
                            <td>${order.product_name}</td>
                            <td>${order.quantity} ${order.unit}</td>
                            <td>$ ${order.total_price}</td>
                            <td>${order.order_status}</td>
                          
                        </tr>                    
                    `;
                    }
                   
                });

                $("#orderTableBody").html(tableRows);
                updatePaginationControls(response.total);
            

    }
    });
    }
    function updatePaginationControls(total) {
        let totalPages = Math.ceil(total / limit);
        let paginationHTML = "";

        for (let i = 0; i < totalPages; i++) {
            let pageOffset = i * limit;
            paginationHTML += `<button class="pagination-btn" data-offset="${pageOffset}">${i + 1}</button> `;
        }

        $("#orderPaginationControls").html(paginationHTML);
    }

    $(document).on("click", ".pagination-btn", function() {
        offset = $(this).data("offset");
        loadOrders(offset);
    });

    loadOrders(offset);


});

     $(document).on('change', '.order-status', function() {
            let orderId = $(this).data('id');
            let newStatus = $(this).val();
            $.ajax({
                url: "<?= base_url('order/update_status/') ?>" + orderId,
                type: "POST",
                data: { status: newStatus },
                success: function(response) {
                    toastr.success('Order status updated successfully!');
                },
                error: function() {
                    toastr.error('Error updating order status.');
                }
            });
        });

        $(document).on('click', '.delete-order', function() {
            let row = $(this).closest('tr');
            let orderId = row.data('id');
            if (confirm('Are you sure you want to delete this order?')) {
                $.ajax({
                    url: "<?= base_url('order/delete/') ?>" + orderId,
                    type: "POST",
                    success: function(response) {
                        row.remove();
                        toastr.success('Order deleted successfully!');
                    },
                    error: function() {
                        toastr.error('Error deleting order.');
                    }
                });
            }
        });
   
</script>
