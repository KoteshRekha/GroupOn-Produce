<?php include('header.php')?>
<?php include('sidebar.php')?>
<div class="main-content">
        <h2>Manage Products</h2>
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

         <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">Add New Product</button>
      <table class="table" >
            <thead>
                <tr>
                     <th>Image</th>
                     <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
               
            </tbody>


        </table>
        <div id="paginationControls"></div>
    </div>
</div>
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('product/add') ?>" method="POST" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label for="productImage">Product Image</label>
                        <input type="file" class="form-control" id="productImage" name="productImage" required>
                    </div>
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Category</label>
                       <select class="form-control" name="productCategory" id="ProductCategory" required>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Price</label>
                        <input type="number" class="form-control" id="productPrice"  name="productPrice"  required>
                    </div>
                    <div class="form-group">
                        <label for="productStock">Stock</label>
                        <input type="number" class="form-control" id="productStock" name="productStock" required>
                    </div>
                     <div class="form-group">
                        <label for="editProductUnit">Unit</label>
                        <input type="text" class="form-control" name="unit" id="ProductUnit" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('product/update_product') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editProductId">
                    
                    <div class="form-group">
                        <label>Current Product Image</label><br>
                        <img id="editProductImagePreview" src="" alt="Product Image" width="100">
                    </div>

                    <div class="form-group">
                        <label for="editProductImage">Change Product Image</label>
                        <input type="file" class="form-control" name="image" id="editProductImage">
                    </div>
                    
                    <div class="form-group">
                        <label for="editProductName">Product Name</label>
                        <input type="text" class="form-control" name="name" id="editProductName" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editProductCategory">Category</label>
                     
                        <select class="form-control" name="category" id="editProductCategory" required>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="editProductPrice">Price</label>
                        <input type="number" class="form-control" name="price" id="editProductPrice" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editProductStock">Stock</label>
                        <input type="number" class="form-control" name="stock" id="editProductStock" required>
                    </div>
                      <div class="form-group">
                        <label for="editProductUnit">Unit</label>
                        <input type="text" class="form-control" name="unit" id="editProductUnit" required>
                    </div>

                    <button type="submit" class="btn btn-warning">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include('footer.php')?>
<script type="text/javascript">
    $(document).ready(function() {

        let limit = 5; // Items per page
    let offset = 0; // Start from first page
       function loadProducts(offset) {
      $.ajax({
            url: "<?= base_url('product/get_products') ?>",
            type: "GET",
            data: { limit: limit, offset: offset },
            dataType: "json",
            success: function(response) {
                console.log(response);
                let tableRows = "";
                $.each(response.products, function(index, product) {
                    tableRows += `
                        <tr data-id="${product.id}" data-unit="${product.unit}" data-name="${product.product_name}" data-category="${product.category}" data-category_id="${product.category_id}" data-price="${product.price}" data-stock="${product.stock}" data-image="${product.image}">
                            <td><img src="${product.image}" alt="${product.product_name}" width="50" height="50"></td>
                            <td>${product.product_name}</td>
                            <td>${product.category}</td>
                            <td>$ ${product.price}/${product.unit}</td>
                            <td>${product.stock} ${product.unit}</td>
                            <td>
                                <button class="btn btn-warning edit-product" data-toggle="modal" data-target="#editProductModal">Edit</button>
                                <button class="btn btn-danger delete-product">Delete</button>
                            </td>
                        </tr>
                    `;
                });

                $("#productTableBody").html(tableRows);
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

        $("#paginationControls").html(paginationHTML);
    }

    $(document).on("click", ".pagination-btn", function() {
        offset = $(this).data("offset");
        loadProducts(offset);
    });

    loadProducts(offset);
        });


$(document).ready(function() {
    // Use event delegation for dynamically loaded elements
    $(document).on('click', '.edit-product', function() {
        let row = $(this).closest('tr');

        // Debugging - Check if row contains data
        console.log("Row Data: ", row.data());

        // Fill modal fields
        $('#editProductId').val(row.data('id'));
        $('#editProductName').val(row.data('name'));
        $('#editProductCategory').val(row.data('category_id'));
        $('#editProductPrice').val(row.data('price'));
        $('#editProductStock').val(row.data('stock'));
         $('#editProductUnit').val(row.data('unit'));

        $('#editProductImagePreview').attr('src', row.data('image'));

    });

    $(document).on('click', '.delete-product', function() {
            let row = $(this).closest('tr');
            let productId = row.data('id');
            alert(productId);
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: "<?= base_url('product/delete/') ?>" + productId,
                    type: "POST",
                    success: function(response) {
                        row.remove();
                        toastr.success('Product deleted successfully!');
                    },
                    error: function() {
                        toastr.error('Error deleting product.');
                    }
                });
            }
        });
});

</script>