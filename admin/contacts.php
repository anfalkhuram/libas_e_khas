<?php
$pageName = 'Contacts';
require_once('inc/admin-top.php');
?>

<body>
    <?php
    require_once('inc/admin-sidebar.php');
    ?>
    
    <div class="admin-content">
        <?php   
        require_once('inc/admin-topbar.php');
        ?>

        <div class="container-fluid p-4">
            <h2 class="font-heading mb-4">Contact Messages</h2>

            <div class="bg-white p-4 rounded shadow-sm border-top border-3 border-gold">
                <div class="table-responsive">
                    <table class="table table-hover font-body align-middle datatable w-100">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th style="min-width: 300px;">Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once('../inc/db.php');
                            $sql = "SELECT id, name, email, phone, subject, message, created_at FROM contacts ORDER BY created_at DESC";
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    // Notice: These are already sanitized on input, but outputting with htmlspecialchars again 
                                    // or just safely echoing is good practice. We will do it to be absolutely safe.
                                    $cName = htmlspecialchars($row['name']);
                                    $cEmail = htmlspecialchars($row['email']);
                                    $cPhone = htmlspecialchars($row['phone']);
                                    $cSubject = htmlspecialchars($row['subject']);
                                    $text = htmlspecialchars($row['message']);
                                    $date = date('M d, Y H:i', strtotime($row['created_at']));
                                    
                                    $actionHtml = '<button class="btn btn-sm btn-outline-danger delete-btn" data-id="'.$id.'"><i class="fas fa-trash"></i></button>';
                                    
                                    echo "<tr>
                                            <td class='fw-medium'>$cName</td>
                                            <td><a href='mailto:$cEmail' class='text-decoration-none'>$cEmail</a></td>
                                            <td>$cPhone</td>
                                            <td>$cSubject</td>
                                            <td class='small text-muted'>$text</td>
                                            <td class='small'>$date</td>
                                            <td>$actionHtml</td>
                                          </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once('inc/admin-bottom.php');
    ?>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const id = e.currentTarget.dataset.id;
                    const result = await Swal.fire({
                        title: 'Delete this message?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    });
                    
                    if(result.isConfirmed) {
                        try {
                            const res = await fetch(`ajax/delete-contact.php?id=${id}`);
                            const data = await res.json();
                            if(data.success) {
                                await Swal.fire({icon: 'success', title: 'Deleted!', showConfirmButton: false, timer: 1500});
                                location.reload();
                            }
                            else Swal.fire('Error', data.error || 'Failed to delete', 'error');
                        } catch(err) {
                            console.error(err);
                            Swal.fire('Error', 'An error occurred.', 'error');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
