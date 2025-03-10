<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$supplierQuery = "SELECT SupplierID, SupplierName FROM Supplier";
$supplierResult = $conn->query($supplierQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'] ?? '';
    $productcategory = $_POST['productcategory'] ?? '';
    $unit = $_POST['unit'] ?? '';
    $unitCost = $_POST['unitCost'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $supplierID = $_POST['supplier'] ?? '';

    if (!empty($name) && !empty($productcategory) && !empty($unit) && !empty($unitCost) && !empty($price) && !empty($supplierID)) {
        $sql = "CALL InsertProduct('$name', '$productcategory', '$unit', $unitCost, $price, $supplierID)";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Product added successfully!";
        } else {
            $_SESSION['error'] = "Error adding product: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields!";
    }

    header("Location: products.php");
    exit();
}?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Product</h2>

        <form method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label>Product Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-2">
                <label for="productcategory">Category</label>
                    <select name="productcategory" class="form-control" required>
                        <option value="Tools">Tools</option>
                        <option value="Hardware">Hardware</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Building Materials">Building Materials</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Material">Material</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Unit of Measurement</label>
                    <input type="text" class="form-control" name="unit" required>
                </div>
                <div class="col-md-2">
                    <label>Unit Cost</label>
                    <input type="number" class="form-control" name="unitCost" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <label>Price</label>
                    <input type="number" class="form-control" name="price" step="0.01" required>
                </div>
                <div class="col-md-3">
                <label>Supplier</label>
                    <select name="supplier" class="form-control" required>
                        <option value="">Select Supplier</option>
                        <?php while ($row = $supplierResult->fetch_assoc()): ?>
                            <option value="<?= $row['SupplierID']; ?>"><?= $row['SupplierName']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-1 mt-4">
                    <button type="submit" name="add_product" class="btn btn-success w-100">Add</button>
                </div>
            </div>
        </form>

        <a href="products.php" class="btn btn-secondary mt-3">Back to Products</a>
    </div>
</body>
</html>
