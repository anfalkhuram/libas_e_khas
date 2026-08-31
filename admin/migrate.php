<?php
require '../inc/db.php';
$conn->query("UPDATE orders SET status = 'Delivered' WHERE status = 'Completed'");
echo "Done";
?>
