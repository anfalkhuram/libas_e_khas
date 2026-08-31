<?php 
    require_once ('../inc/db.php');

    // Handle AJAX toggle status
    if (isset($_POST['ajax_toggle_status'])) {
        $toggle_id = intval($_POST['ajax_toggle_status']);
        $stmt = $conn->prepare("SELECT s.status, c.status as parent_status FROM sub_categories s JOIN categories c ON s.category_id = c.id WHERE s.id = ?");
        $stmt->bind_param("i", $toggle_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $new_status = ($row['status'] == 1) ? 0 : 1;
            
            if ($new_status == 1 && $row['parent_status'] == 0) {
                echo json_encode(['status' => 'error', 'message' => 'Cannot activate: Parent category is inactive']);
                exit;
            }
            $update_stmt = $conn->prepare("UPDATE sub_categories SET status = ? WHERE id = ?");
            $update_stmt->bind_param("ii", $new_status, $toggle_id);
            if ($update_stmt->execute()) {
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
        $stmt = $conn->prepare("DELETE FROM sub_categories WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            header("Location: sub-categories.php?msg=delete_success");
            exit;
        } else {
            header("Location: sub-categories.php?msg=delete_error");
            exit;
        }
        $stmt->close();
    }

    // Handle form submission (Add)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_sub_category'])) {
        $name = $_POST['name'];
        $category_id = intval($_POST['category_id']);
        $status = intval($_POST['status']);

        if ($status == 1) {
            $c_stmt = $conn->prepare("SELECT status FROM categories WHERE id = ?");
            $c_stmt->bind_param("i", $category_id);
            $c_stmt->execute();
            $c_res = $c_stmt->get_result();
            $c_row = $c_res->fetch_assoc();
            if ($c_row['status'] == 0) $status = 0;
            $c_stmt->close();
        }

        $stmt = $conn->prepare("INSERT INTO sub_categories (name, category_id, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $name, $category_id, $status);
        
        if ($stmt->execute()) {
            header("Location: sub-categories.php?msg=add_success");
            exit;
        } else {
            header("Location: sub-categories.php?msg=add_error");
            exit;
        }
        $stmt->close();
    }

    // Handle form submission (Edit)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_sub_category'])) {
        $id = intval($_POST['sub_category_id']);
        $name = $_POST['name'];
        $category_id = intval($_POST['category_id']);
        $status = intval($_POST['status']);

        if ($status == 1) {
            $c_stmt = $conn->prepare("SELECT status FROM categories WHERE id = ?");
            $c_stmt->bind_param("i", $category_id);
            $c_stmt->execute();
            $c_res = $c_stmt->get_result();
            $c_row = $c_res->fetch_assoc();
            if ($c_row['status'] == 0) $status = 0;
            $c_stmt->close();
        }

        $stmt = $conn->prepare("UPDATE sub_categories SET name=?, category_id=?, status=? WHERE id=?");
        $stmt->bind_param("siii", $name, $category_id, $status, $id);
        
        if ($stmt->execute()) {
            header("Location: sub-categories.php?msg=edit_success");
            exit;
        } else {
            header("Location: sub-categories.php?msg=edit_error");
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
                        case 'add_success': $msg_text = 'Sub Category added successfully!'; break;
                        case 'add_error': $msg_text = 'Error adding sub category.'; break;
                        case 'edit_success': $msg_text = 'Sub Category updated successfully!'; break;
                        case 'edit_error': $msg_text = 'Error updating sub category.'; break;
                        case 'delete_success': $msg_text = 'Sub Category deleted successfully!'; break;
                        case 'delete_error': $msg_text = 'Error deleting sub category.'; break;
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
                <h2 class="font-heading mb-0">Sub Categories</h2>
                <button class="btn btn-dark font-body" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal"><i class="fas fa-plus me-2"></i>Add Sub Category</button>
            </div>

            <div class="bg-white p-4 rounded shadow-sm border-top border-3 border-gold">
                <div class="table-responsive">
                    <table class="table table-hover font-body align-middle datatable w-100">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Total Products</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT s.*, c.name as category_name, (SELECT COUNT(*) FROM products p WHERE p.sub_category_id = s.id) as product_count FROM sub_categories s LEFT JOIN categories c ON s.category_id = c.id ORDER BY s.id DESC");
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>'.$row['id'].'</td>';
                                    echo '<td>'.htmlspecialchars($row['category_name']).'</td>';
                                    echo '<td><strong>'.htmlspecialchars($row['name']).'</strong></td>';
                                    echo '<td>'.$row['product_count'].'</td>';
                                    $status_text = ($row['status'] == 1) ? 'Active' : 'Inactive';
                                    $badge_class = ($row['status'] == 1) ? 'bg-success' : 'bg-secondary';
                                    echo '<td><a href="javascript:void(0)" class="text-decoration-none toggle-status-btn" data-id="'.$row['id'].'" title="Click to Toggle Status"><span class="badge '.$badge_class.' px-3 py-2 status-badge">'.$status_text.'</span></a></td>';
                                    echo '<td>
                                        <button class="btn btn-sm btn-outline-dark me-1 edit-btn" data-id="'.$row['id'].'" data-name="'.htmlspecialchars($row['name']).'" data-category_id="'.$row['category_id'].'" data-status="'.$row['status'].'" data-bs-toggle="modal" data-bs-target="#editSubCategoryModal"><i class="fas fa-edit"></i></button>
                                        <a href="javascript:void(0)" data-url="sub-categories.php?delete_id='.$row['id'].'" class="btn btn-sm btn-outline-danger delete-subcat-btn"><i class="fas fa-trash"></i></a>
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

    <!-- Add Sub Category Modal -->
    <div class="modal fade" id="addSubCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header bg-dark rounded-0">
                    <h5 class="modal-title font-heading text-white">Add New Sub Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-body">
                    <form method="POST" action="sub-categories.php">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Parent Category</label>
                            <select name="category_id" class="form-control rounded-0 border-dark shadow-none" required>
                                <option value="">Select Category</option>
                                <?php
                                $cat_res = $conn->query("SELECT id, name FROM categories WHERE status = 1 ORDER BY name ASC");
                                if ($cat_res) {
                                    while ($cat = $cat_res->fetch_assoc()) {
                                        echo '<option value="'.$cat['id'].'">'.htmlspecialchars($cat['name']).'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Sub Category Name</label>
                            <input type="text" name="name" class="form-control rounded-0 border-dark shadow-none" required>
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
                            <button type="submit" name="add_sub_category" class="btn btn-primary font-body">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Sub Category Modal -->
    <div class="modal fade" id="editSubCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header bg-dark text-white rounded-0">
                    <h5 class="modal-title font-heading text-white">Edit Sub Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body font-body">
                    <form method="POST" action="sub-categories.php">
                        <input type="hidden" name="sub_category_id" id="edit_sub_category_id">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Parent Category</label>
                            <select name="category_id" id="edit_category_id" class="form-control rounded-0 border-dark shadow-none" required>
                                <option value="">Select Category</option>
                                <?php
                                $cat_res = $conn->query("SELECT id, name FROM categories WHERE status = 1 ORDER BY name ASC");
                                if ($cat_res) {
                                    while ($cat = $cat_res->fetch_assoc()) {
                                        echo '<option value="'.$cat['id'].'">'.htmlspecialchars($cat['name']).'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Sub Category Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control rounded-0 border-dark shadow-none" required>
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
                            <button type="submit" name="edit_sub_category" class="btn btn-primary font-body">Update</button>
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
                    url: 'sub-categories.php',
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
                var category_id = $(this).data('category_id');
                var status = $(this).data('status');
                
                $('#edit_sub_category_id').val(id);
                $('#edit_name').val(name);
                $('#edit_category_id').val(category_id);
                $('#edit_status').val(status);
            });

            $('.delete-subcat-btn').on('click', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Delete Sub Category?',
                    text: "Are you sure you want to delete this sub category? This action cannot be undone.",
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
