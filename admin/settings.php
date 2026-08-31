<?php
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
            <h2 class="font-heading mb-4">Website Settings</h2>

            <div class="row g-4 font-body">
                <div class="col-lg-3">
                    <div class="list-group rounded-0 shadow-sm border-0">
                        <a href="#" class="list-group-item list-group-item-action active bg-dark border-dark" aria-current="true">General Settings</a>
                        <a href="#" class="list-group-item list-group-item-action">Payment Gateway</a>
                        <a href="#" class="list-group-item list-group-item-action">Shipping Zones</a>
                        <a href="#" class="list-group-item list-group-item-action">Tax Settings</a>
                        <a href="#" class="list-group-item list-group-item-action">Admin Profile</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm border-top border-3 border-gold">
                        <h4 class="mb-4">General Settings</h4>

                        <form>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Store Name</label>
                                <input type="text" class="form-control rounded-0 border-dark shadow-none" value="Libas e Khas">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Store Email</label>
                                <input type="email" class="form-control rounded-0 border-dark shadow-none" value="info@libasekhas.com">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small">Store Phone</label>
                                <input type="tel" class="form-control rounded-0 border-dark shadow-none" value="+92 300 1234567">
                            </div>

                            <h5 class="mb-3 mt-5 border-bottom pb-2">Store Address</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Address Line 1</label>
                                <input type="text" class="form-control rounded-0 border-dark shadow-none" value="123 Fashion Avenue">
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">City</label>
                                    <input type="text" class="form-control rounded-0 border-dark shadow-none" value="Lahore">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Country</label>
                                    <select class="form-select rounded-0 border-dark shadow-none">
                                        <option value="PK" selected>Pakistan</option>
                                    </select>
                                </div>
                            </div>

                            <h5 class="mb-3 mt-5 border-bottom pb-2">Currency</h5>
                            <div class="mb-4">
                                <label class="form-label fw-bold small">Default Currency</label>
                                <select class="form-select rounded-0 border-dark shadow-none">
                                    <option value="PKR" selected>PKR - Pakistani Rupee</option>
                                    <option value="USD">USD - US Dollar</option>
                                    <option value="GBP">GBP - British Pound</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary px-5 mt-3">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once('inc/admin-bottom.php');
    ?>
</body>

</html>