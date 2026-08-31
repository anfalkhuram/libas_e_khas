<?php 
    require_once ('../inc/db.php');
    require_once ('../inc/image_helper.php');

    // Handle AJAX toggle status
    if (isset($_POST['ajax_toggle_status'])) {
        $toggle_id = intval($_POST['ajax_toggle_status']);
        $stmt = $conn->prepare("SELECT status FROM categories WHERE id = ?");
        $stmt->bind_param("i", $toggle_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $new_status = ($row['status'] == 1) ? 0 : 1;
            $update_stmt = $conn->prepare("UPDATE categories SET status = ? WHERE id = ?");
            $update_stmt->bind_param("ii", $new_status, $toggle_id);
            if ($update_stmt->execute()) {
                if ($new_status == 0) {
                    $sub_stmt = $conn->prepare("UPDATE sub_categories SET status = 0 WHERE category_id = ?");
                    $sub_stmt->bind_param("i", $toggle_id);
                    $sub_stmt->execute();
                    $sub_stmt->close();
                }
                $status_str = ($new_status == 1) ? 'Active' : 'Inactive';
                echo json_encode(['status' => 'success', 'new_status' => $status_str]);
                exit;
            }
            $update_stmt->close();
        }
        $stmt->close();
        echo json_encode(['status' => 'error', 'message' => 'Error toggling status']);
        exit;
    }

    // Handle delete category
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            header("Location: categories.php?msg=delete_success");
            exit;
        } else {
            header("Location: categories.php?msg=delete_error");
            exit;
        }
        $stmt->close();
    }

    // Handle form submission (Add)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
        $name = $_POST['name'];
        $status = intval($_POST['status']);
        $image = '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../assets/images/categories/";
            $originalName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
            $image = time() . '_' . $safeName . '.webp';
            $target_file = $target_dir . $image;
            processAndSaveWebP($_FILES["image"]["tmp_name"], $target_file);
        }

        $stmt = $conn->prepare("INSERT INTO categories (name, image, status) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $image, $status);
        
        if ($stmt->execute()) {
            header("Location: categories.php?msg=add_success");
            exit;
        } else {
            header("Location: categories.php?msg=add_error");
            exit;
        }
        $stmt->close();
    }

    // Handle form submission (Edit)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category'])) {
        $id = intval($_POST['category_id']);
        $name = $_POST['name'];
        $status = intval($_POST['status']);

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../assets/images/categories/";
            $originalName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
            $image = time() . '_' . $safeName . '.webp';
            $target_file = $target_dir . $image;
            processAndSaveWebP($_FILES["image"]["tmp_name"], $target_file);
            
            $stmt = $conn->prepare("UPDATE categories SET name=?, status=?, image=? WHERE id=?");
            $stmt->bind_param("sisi", $name, $status, $image, $id);
        } else {
            $stmt = $conn->prepare("UPDATE categories SET name=?, status=? WHERE id=?");
            $stmt->bind_param("sii", $name, $status, $id);
        }
        
        if ($stmt->execute()) {
            if ($status == 0) {
                $sub_stmt = $conn->prepare("UPDATE sub_categories SET status = 0 WHERE category_id = ?");
                $sub_stmt->bind_param("i", $id);
                $sub_stmt->execute();
                $sub_stmt->close();
            }
            header("Location: categories.php?msg=edit_success");
            exit;
        } else {
            header("Location: categories.php?msg=edit_error");
            exit;
        }
        $stmt->close();
    }

    require_once ('inc/admin-top.php');
?>
<body>

    <?php 
        require_once ('inc/admin-sidebar.php');
    ?>

    <div class="admin-content">
        <?php 
        require_once ('inc/admin-topbar.php');
        ?>
        <div class="container-fluid p-4">
            <!-- Toast Alert Container -->
            <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 1055;">
            <?php 
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                    $alert_class = strpos($msg, 'error') !== false ? 'alert-danger' : 'alert-success';
                    $msg_text = '';
                    switch ($msg) {
                        case 'add_success': $msg_text = 'Category added successfully!'; break;
                        case 'add_error': $msg_text = 'Error adding category.'; break;
                        case 'edit_success': $msg_text = 'Category updated successfully!'; break;
                        case 'edit_error': $msg_text = 'Error updating category.'; break;
                        case 'delete_success': $msg_text = 'Category deleted successfully!'; break;
                        case 'delete_error': $msg_text = 'Error deleting category.'; break;
                        case 'status_success': $msg_text = 'Status toggled successfully!'; break;
                        case 'status_error': $msg_text = 'Error toggling status.'; break;
                    }
                    if ($msg_text) {
                        echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show shadow-sm border-0" role="alert" style="min-width: 300px;">
                                <strong><i class="fas fa-info-circle me-2"></i>' . $msg_text . '</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    }
                }
            ?>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-heading mb-0">Categories</h2>
                <button class="btn btn-dark font-body" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="fas fa-plus me-2"></i>Add Category</button>
            </div>

            <div class="bg-white p-4 rounded shadow-sm border-top border-3 border-gold">
                <div class="table-responsive">
                    <table class="table table-hover font-body align-middle datatable w-100">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Category Name</th>
                                <th>Total Products</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) as product_count FROM categories c ORDER BY c.id DESC");
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $image_path = !empty($row['image']) ? '../assets/images/categories/'.$row['image'] : 'https://via.placeholder.com/150';
                                    echo '<tr>';
                                    echo '<td>'.$row['id'].'</td>';
                                    echo '<td><img src="'.$image_path.'" class="admin-table-img-sm" style="width: 50px; height: 50px; object-fit: cover;"></td>';
                                    echo '<td><strong>'.htmlspecialchars($row['name']).'</strong></td>';
                                    $status_text = ($row['status'] == 1) ? 'Active' : 'Inactive';
                                    $badge_class = ($row['status'] == 1) ? 'bg-success' : 'bg-secondary';
                                    echo '<td>'.$row['product_count'].'</td>';
                                    echo '<td><a href="javascript:void(0)" class="text-decoration-none toggle-status-btn" data-id="'.$row['id'].'" title="Click to Toggle Status"><span class="badge '.$badge_class.' px-3 py-2 status-badge">'.$status_text.'</span></a></td>';
                                    echo '<td>
                                        <button class="btn btn-sm btn-outline-dark me-1 edit-btn" data-id="'.$row['id'].'" data-name="'.htmlspecialchars($row['name']).'" data-status="'.$row['status'].'" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><i class="fas fa-edit"></i></button>
                                        <a href="javascript:void(0)" data-url="categories.php?delete_id='.$row['id'].'" class="btn btn-sm btn-outline-danger delete-category-btn"><i class="fas fa-trash"></i></a>
                                    </td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header bg-dark text-white rounded-0">
                    <h5 class="modal-title font-heading text-white">Add New Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-body">
                    <form method="POST" action="categories.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Category Name</label>
                            <input type="text" name="name" class="form-control rounded-0 border-dark shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Category Image</label>
                            <input class="form-control rounded-0 border-dark shadow-none" type="file" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Status</label>
                            <select name="status" class="form-control rounded-0 border-dark shadow-none">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="modal-footer border-top-0 px-0 pb-0">
                            <button type="button" class="btn btn-outline-dark rounded-0 font-body" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="add_category" class="btn btn-primary font-body">Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header bg-dark text-white rounded-0">
                    <h5 class="modal-title font-heading text-white">Edit Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-body">
                    <form method="POST" action="categories.php" enctype="multipart/form-data">
                        <input type="hidden" name="category_id" id="edit_category_id">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Category Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control rounded-0 border-dark shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Category Image (Leave blank to keep current)</label>
                            <input class="form-control rounded-0 border-dark shadow-none" type="file" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Status</label>
                            <select name="status" id="edit_status" class="form-control rounded-0 border-dark shadow-none">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="modal-footer border-top-0 px-0 pb-0">
                            <button type="button" class="btn btn-outline-dark rounded-0 font-body" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="edit_category" class="btn btn-primary font-body">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->

    <?php 
        require_once ('inc/admin-bottom.php');
    ?>
   
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Remove GET parameters from URL to prevent message replay on refresh
            if (window.history.replaceState) {
                var url = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({path: url}, '', url);
            }
            // Auto dismiss alert toast after 3 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);

            function showToast(message, type) {
                var icon = type == 'success' ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger';
                var alertClass = type == 'success' ? 'alert-success' : 'alert-danger';
                var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show shadow-sm border-0" role="alert" style="min-width: 300px;">' +
                                '<strong><i class="fas ' + icon + ' me-2"></i>' + message + '</strong>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>';
                $('#toast-container').html(alertHtml);
                setTimeout(function() {
                    $('#toast-container .alert').alert('close');
                }, 3000);
            }

            $('.toggle-status-btn').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                var id = btn.data('id');
                var badge = btn.find('.status-badge');
                
                $.ajax({
                    url: 'categories.php',
                    type: 'POST',
                    data: { ajax_toggle_status: id },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status == 'success') {
                            if(response.new_status == 'Active') {
                                badge.removeClass('bg-secondary').addClass('bg-success').text('Active');
                            } else {
                                badge.removeClass('bg-success').addClass('bg-secondary').text('Inactive');
                            }
                            showToast('Status toggled successfully!', 'success');
                        } else {
                            showToast('Error toggling status', 'error');
                        }
                    },
                    error: function() {
                        showToast('Request failed', 'error');
                    }
                });
            });

            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var status = $(this).data('status');
                
                $('#edit_category_id').val(id);
                $('#edit_name').val(name);
                $('#edit_status').val(status);
            });

            $('.delete-category-btn').on('click', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Delete Category?',
                    text: "Are you sure you want to delete this category? This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
</body>
</html>
