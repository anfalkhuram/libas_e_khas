<?php 
    require_once ('inc/admin-top.php');
?>
<body>

    <!-- Sidebar & Topbar would be dynamically included in a real app, duplicating here for static layout -->
    
    <?php 
        require_once ('inc/admin-sidebar.php');
    ?>
    <div class="admin-content">
        <?php 
            require_once ('inc/admin-topbar.php');
        ?>

        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-heading mb-0">Products List</h2>
                <a href="add-product" class="btn btn-dark font-body"><i class="fas fa-plus me-2"></i>Add New Product</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover font-body align-middle datatable w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Availability</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once('../inc/db.php');
                        $prod_sql = "SELECT p.*, c.name as category_name, c.status as cat_status, s.status as subcat_status FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN sub_categories s ON p.sub_category_id = s.id ORDER BY p.id DESC";
                        $prod_res = $conn->query($prod_sql);
                        if($prod_res && $prod_res->num_rows > 0) {
                            while($row = $prod_res->fetch_assoc()) {
                                $img = htmlspecialchars($row['main_image']);
                                $name = htmlspecialchars($row['name']);
                                $category = htmlspecialchars($row['category_name']);
                                $price = number_format($row['price'], 2);
                                $stock = intval($row['stock']);
                                $availability = htmlspecialchars($row['availability']);
                                
                                // Determine status badge based on availability
                                $badgeClass = ($availability === 'In Stock') ? 'bg-success' : (($availability === 'Low Stock') ? 'bg-warning' : 'bg-danger');
                                
                                // The image path stored is likely 'assets/images/products/...', so we prefix with '../' for the admin context
                                $img_src = '../' . $img;
                                
                                echo '<tr id="product-row-'.$row['id'].'">';
                                echo '<td><img src="'.$img_src.'" class="admin-table-img-md" alt="'.$name.'" style="width:50px; height:auto; object-fit:cover;"></td>';
                                echo '<td><strong>'.$name.'</strong></td>';
                                echo '<td>'.$category.'</td>';
                                echo '<td>PKR '.$price.'</td>';
                                echo '<td>'.$stock.'</td>';
                                echo '<td><span class="badge '.$badgeClass.'">'.$availability.'</span></td>';
                                
                                $prod_status = intval($row['status'] ?? 1);
                                $cat_status = isset($row['cat_status']) ? intval($row['cat_status']) : 1;
                                $subcat_status = isset($row['subcat_status']) ? intval($row['subcat_status']) : 1;
                                $effective_status = ($prod_status === 1 && $cat_status === 1 && $subcat_status === 1) ? 1 : 0;
                                $statusBadgeClass = ($effective_status === 1) ? 'bg-success' : 'bg-danger';
                                $statusText = ($effective_status === 1) ? 'Active' : 'Inactive';
                                echo '<td><a href="javascript:void(0)" onclick="toggleStatus('.$row['id'].')" class="text-decoration-none" title="Click to toggle"><span class="badge '.$statusBadgeClass.'" id="status-badge-'.$row['id'].'">'.$statusText.'</span></a></td>';

                                echo '<td>
                                        <div class="d-flex flex-nowrap gap-1">
                                            <a href="../product-details?id='.$row['id'].'" class="btn btn-sm btn-outline-primary" target="_blank" title="View"><i class="fas fa-eye"></i></a>
                                            <a href="edit-product.php?id='.$row['id'].'" class="btn btn-sm btn-outline-dark" title="Edit"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteProduct('.$row['id'].')"><i class="fas fa-trash"></i></button>
                                        </div>
                                      </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center">No products found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php 
        require_once ('inc/admin-bottom.php');
    ?>
    <script>
    async function toggleStatus(id) {
        try {
            const res = await fetch('ajax/toggle-product-status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + id
            });
            const data = await res.json();
            if (data.success) {
                const badge = document.getElementById('status-badge-' + id);
                if (badge) {
                    if (data.effective_status === 1) {
                        badge.className = 'badge bg-success';
                        badge.innerText = 'Active';
                    } else {
                        badge.className = 'badge bg-danger';
                        badge.innerText = 'Inactive';
                    }
                }
            } else {
                Swal.fire('Error', data.error || 'Failed to toggle status', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'A network error occurred.', 'error');
        }
    }

    async function deleteProduct(id) {
        const result = await Swal.fire({
            title: 'Delete Product?',
            text: "Are you sure you want to delete this product? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        });
        
        if (!result.isConfirmed) {
            return;
        }
        try {
            const res = await fetch('ajax/delete-product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + id
            });
            const data = await res.json();
            if (data.success) {
                await Swal.fire({icon: 'success', title: 'Deleted!', showConfirmButton: false, timer: 1500});
                document.getElementById('product-row-' + id).remove();
            } else {
                Swal.fire('Error', data.error || 'Failed to delete', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'A network error occurred.', 'error');
        }
    }
    </script>
</body>
</html>
