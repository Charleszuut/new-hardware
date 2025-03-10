<?php
session_start();
include '../includes/auth.php';
include '../includes/db.php';


// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM Products WHERE ProductID=$id";
    $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header_admin.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Manage Products</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Include Add Product Form -->
        <div class="d-flex justify-content-end mb-3">
            <a href="add_product.php" class="btn btn-primary">Add New Product</a>
        </div>




        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Unit Cost</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM Products";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row['ProductID']; ?></td>
                        <td><?php echo $row['ProductName']; ?></td>
                        <td><?php echo $row['ProductCategory']; ?></td>
                        <td><?php echo $row['UnitofMeasurement']; ?></td>
                        <td>₱<?php echo number_format($row['UnitCost'], 2); ?></td>
                        <td>₱<?php echo number_format($row['Price'], 2); ?></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['ProductID']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?php echo $row['ProductID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
