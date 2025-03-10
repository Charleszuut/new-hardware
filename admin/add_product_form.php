<php?
require_once '../includes/auth.php';
require_once '../includes/db.php';


<form method="POST" action="add_product.php" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <input type="text" class="form-control" name="name" placeholder="Product Name" required>
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="category" placeholder="Category" required>
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="unit" placeholder="Unit of Measurement" required>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control" name="unitCost" placeholder="Unit Cost" step="0.01" required>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control" name="price" placeholder="Price" step="0.01" required>
        </div>
        <div class="col-md-1">
            <button type="submit" name="add_product" class="btn btn-success w-100">Add</button>
        </div>
    </div>
</form>