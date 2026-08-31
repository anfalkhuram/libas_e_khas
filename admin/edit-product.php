<?php
require_once('../inc/db.php');
require_once('inc/admin-top.php');

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id === 0) {
    die('Invalid product ID');
}

$prodRes = $conn->query("SELECT * FROM products WHERE id = $product_id");
if (!$prodRes || $prodRes->num_rows === 0) {
    die('Product not found');
}
$product = $prodRes->fetch_assoc();

$categories = [];
$catRes = $conn->query("SELECT id, name FROM categories WHERE status = 1 ORDER BY name ASC");
if ($catRes) {
    while ($row = $catRes->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch sizes
$dbSizes = [];
$sizeRes = $conn->query("SELECT * FROM sizes WHERE status = 1 ORDER BY sort_order ASC");
if ($sizeRes) {
    while ($row = $sizeRes->fetch_assoc()) {
        $dbSizes[] = $row;
    }
}

// Fetch existing colors
$dbColors = [];
$colRes = $conn->query("SELECT * FROM product_colors WHERE product_id = $product_id ORDER BY sort_order ASC");
if ($colRes) {
    while ($row = $colRes->fetch_assoc()) {
        $dbColors[] = $row;
    }
}

// Fetch existing options
$dbOptions = [];
$optRes = $conn->query("SELECT * FROM product_options WHERE product_id = $product_id ORDER BY sort_order ASC");
if ($optRes) {
    while ($row = $optRes->fetch_assoc()) {
        $dbOptions[] = $row;
    }
}

// Fetch existing variations
$dbVariations = [];
$varRes = $conn->query("SELECT pv.*, pc.color_name, po.option_name, s.name as size_name 
                        FROM product_variations pv 
                        LEFT JOIN product_colors pc ON pv.color_id = pc.id 
                        LEFT JOIN product_options po ON pv.option_id = po.id 
                        LEFT JOIN sizes s ON pv.size_id = s.id 
                        WHERE pv.product_id = $product_id");
if ($varRes) {
    while ($row = $varRes->fetch_assoc()) {
        $dbVariations[] = $row;
    }
}
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
            <h2 class="font-heading mb-4">Edit Product</h2>

            <form id="editProductForm" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <div class="row font-body">
                    <div class="col-lg-8">
                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold mb-4 rounded-0">
                            <h5 class="mb-4">Basic Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Product Title</label>
                                <input type="text" name="name" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. Velvet Embroidered Suit" value="<?= htmlspecialchars($product['name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Short Description</label>
                                <textarea name="shortDescription" class="form-control rounded-0 shadow-none border-secondary" rows="2" placeholder="Brief summary for the product cards"><?= htmlspecialchars($product['shortDescription']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Description</label>
                                <textarea id="summernote" name="description" class="form-control rounded-0 shadow-none border-secondary" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Regular Price (PKR)</label>
                                    <input type="number" name="price" class="form-control rounded-0 shadow-none border-secondary" placeholder="0.00" value="<?= $product['price'] ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mt-4 pt-2">
                                        <input type="checkbox" name="sale" id="isSale" class="form-check-input me-1 rounded-0" <?= $product['sale'] ? 'checked' : '' ?>> On Sale
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Sale Price (PKR)</label>
                                    <input type="number" name="salePrice" id="salePrice" class="form-control rounded-0 shadow-none border-secondary" placeholder="0.00" value="<?= $product['salePrice'] ?>" <?= $product['sale'] ? '' : 'disabled' ?>>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold mb-4 rounded-0">
                            <h5 class="mb-4">Attributes</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fabric</label>
                                    <input type="text" name="fabric" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. Pure Silk" value="<?= htmlspecialchars($product['fabric'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Collection</label>
                                    <input type="text" name="collection" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. Festive Evening" value="<?= htmlspecialchars($product['collection'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Sizes <small class="text-muted fw-normal d-block fs-8">(Comma separated - Legacy)</small></label>
                                    <input type="text" name="sizes" class="form-control rounded-0 shadow-none border-secondary" placeholder="S, M, L, XL, Custom" value="<?= htmlspecialchars($product['sizes'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Colors <small class="text-muted fw-normal d-block fs-8">(Comma separated - Legacy)</small></label>
                                    <input type="text" name="colors" class="form-control rounded-0 shadow-none border-secondary" placeholder="Red, Blue, As Pictured" value="<?= htmlspecialchars($product['colors'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Pieces <small class="d-block">&nbsp;</small></label>
                                    <input type="text" name="pieces" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. 3 Piece" value="<?= htmlspecialchars($product['pieces'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Variations Section -->
                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold mb-4 rounded-0">
                            <h5 class="mb-4">Product Variations</h5>
                            
                            <div class="row g-4">
                                <!-- Colors -->
                                <div class="col-12">
                                    <h6 class="fw-bold">Colors</h6>
                                    <div id="colorsContainer" class="d-flex flex-column gap-2 mb-2">
                                        <?php foreach($dbColors as $c): ?>
                                            <div class="d-flex gap-2 align-items-center color-row" data-id="<?= $c['id'] ?>">
                                                <input type="text" class="form-control form-control-sm rounded-0 var-color-name w-50" value="<?= htmlspecialchars($c['color_name']) ?>">
                                                <input type="file" class="form-control form-control-sm rounded-0 var-color-img w-50" accept="image/*">
                                                <?php if($c['image']): ?>
                                                    <img src="../<?= $c['image'] ?>" alt="Color" style="height: 30px; width: 30px; object-fit: cover;" class="rounded-0 border">
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-sm btn-danger rounded-0 remove-row-btn"><i class="fas fa-times"></i></button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" id="addColorBtn" class="btn btn-sm btn-outline-dark rounded-0">+ Add Color</button>
                                </div>

                                <!-- Options -->
                                <div class="col-12">
                                    <h6 class="fw-bold">Options (e.g. Shirt + Trousers)</h6>
                                    <div id="optionsContainer" class="d-flex flex-column gap-2 mb-2">
                                        <?php foreach($dbOptions as $o): ?>
                                            <div class="d-flex gap-2 align-items-center option-row" data-id="<?= $o['id'] ?>">
                                                <input type="text" class="form-control form-control-sm rounded-0 var-option-name" value="<?= htmlspecialchars($o['option_name']) ?>">
                                                <button type="button" class="btn btn-sm btn-danger rounded-0 remove-row-btn"><i class="fas fa-times"></i></button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" id="addOptionBtn" class="btn btn-sm btn-outline-dark rounded-0">+ Add Option</button>
                                </div>

                                <!-- Sizes -->
                                <?php 
                                    // Collect sizes used in variations to pre-check them
                                    $usedSizes = [];
                                    foreach($dbVariations as $v) {
                                        if($v['size_id']) $usedSizes[] = $v['size_id'];
                                    }
                                    $usedSizes = array_unique($usedSizes);
                                ?>
                                <div class="col-12">
                                    <h6 class="fw-bold">Sizes</h6>
                                    <div class="d-flex flex-wrap gap-3">
                                        <?php foreach ($dbSizes as $sz): ?>
                                            <div class="form-check">
                                                <input class="form-check-input var-size-cb rounded-0" type="checkbox" value="<?= $sz['id'] ?>" id="size_<?= $sz['id'] ?>" data-name="<?= htmlspecialchars($sz['name']) ?>" <?= in_array($sz['id'], $usedSizes) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="size_<?= $sz['id'] ?>">
                                                    <?= htmlspecialchars($sz['name']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 border-top pt-4 text-end">
                                <button type="button" id="generateVariationsBtn" class="btn btn-dark rounded-0 px-4">Generate Variations</button>
                            </div>

                            <div id="variationsTableContainer" class="mt-4 table-responsive <?= empty($dbVariations) ? 'd-none' : '' ?>">
                                <table class="table table-bordered table-sm text-center align-middle" style="font-size: 0.85rem;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Color</th>
                                            <th>Option</th>
                                            <th>Size</th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Sale Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variationsTableBody">
                                        <?php foreach($dbVariations as $idx => $v): ?>
                                            <tr data-id="<?= $v['id'] ?>" data-color="<?= htmlspecialchars($v['color_name'] ?? '') ?>" data-option="<?= htmlspecialchars($v['option_name'] ?? '') ?>" data-size-id="<?= $v['size_id'] ?>" data-size-name="<?= htmlspecialchars($v['size_name'] ?? '') ?>">
                                                <td><?= htmlspecialchars($v['color_name'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($v['option_name'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($v['size_name'] ?? '-') ?></td>
                                                <td><input type="text" class="form-control form-control-sm rounded-0 var-sku" value="<?= htmlspecialchars($v['sku'] ?? '') ?>"></td>
                                                <td><input type="number" class="form-control form-control-sm rounded-0 var-price" value="<?= $v['price'] ?>"></td>
                                                <td><input type="number" class="form-control form-control-sm rounded-0 var-sale" value="<?= $v['original_price'] ?? '' ?>"></td>
                                                <td><input type="number" class="form-control form-control-sm rounded-0 var-stock" value="<?= $v['stock_quantity'] ?>"></td>
                                                <td>
                                                    <select class="form-select form-select-sm rounded-0 var-status">
                                                        <option value="1" <?= $v['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                        <option value="0" <?= $v['status'] == 0 ? 'selected' : '' ?>>Disabled</option>
                                                    </select>
                                                </td>
                                                <td><button type="button" class="btn btn-sm btn-danger rounded-0 remove-var-btn"><i class="fas fa-trash"></i></button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold rounded-0 mb-4 mb-lg-0">
                            <h5 class="mb-4">Media (Leave blank to keep existing)</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Main Image</label>
                                    <input type="file" name="main_image" class="form-control rounded-0 shadow-none border-secondary" accept="image/*">
                                    <?php if($product['main_image']): ?>
                                        <img src="../<?= $product['main_image'] ?>" alt="Main" style="max-width: 100px; margin-top: 10px;">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Hover Image</label>
                                    <input type="file" name="hover_image" class="form-control rounded-0 shadow-none border-secondary" accept="image/*">
                                    <?php if($product['hover_image']): ?>
                                        <img src="../<?= $product['hover_image'] ?>" alt="Hover" style="max-width: 100px; margin-top: 10px;">
                                    <?php endif; ?>
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="form-label fw-bold">Gallery Images (Select maximum 5 images)</label>
                                    <input type="file" name="gallery_images[]" id="gallery_images" class="form-control rounded-0 shadow-none border-secondary" accept="image/*" multiple>
                                    <small id="gallery_error" class="text-danger d-none">You can only select up to 5 images.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold mb-4 rounded-0">
                            <h5 class="mb-4">Organization</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" id="categorySelect" class="form-select rounded-0 shadow-none border-secondary" required>
                                    <option value="">Select Category...</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub Category</label>
                                <select name="sub_category_id" id="subCategorySelect" class="form-select rounded-0 shadow-none border-secondary" required>
                                    <option value="">Select Sub Category...</option>
                                    <!-- Will be populated by JS -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Stock Quantity</label>
                                <input type="number" name="stock" class="form-control rounded-0 shadow-none border-secondary" value="<?= $product['stock'] ?>" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Availability</label>
                                <select name="availability" class="form-select rounded-0 shadow-none border-secondary">
                                    <option value="In Stock" <?= $product['availability'] === 'In Stock' ? 'selected' : '' ?>>In Stock</option>
                                    <option value="Out of Stock" <?= $product['availability'] === 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
                                    <option value="Low Stock" <?= $product['availability'] === 'Low Stock' ? 'selected' : '' ?>>Low Stock</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tags (Comma separated)</label>
                                <input type="text" name="tags" class="form-control rounded-0 shadow-none border-secondary" placeholder="Bridal, Velvet, Red" value="<?= htmlspecialchars($product['tags'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" id="submitBtn" class="btn btn-dark font-body py-3 rounded-0 fw-bold">UPDATE PRODUCT</button>
                        </div>
                        <div id="formMessage" class="mt-3"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <?php
    require_once('inc/admin-bottom.php');
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isSaleCb = document.getElementById('isSale');
            const salePriceInp = document.getElementById('salePrice');
            
            isSaleCb.addEventListener('change', (e) => {
                if(e.target.checked) {
                    salePriceInp.disabled = false;
                    salePriceInp.required = true;
                } else {
                    salePriceInp.disabled = true;
                    salePriceInp.required = false;
                    salePriceInp.value = '';
                }
            });

            const categorySelect = document.getElementById('categorySelect');
            const subCategorySelect = document.getElementById('subCategorySelect');
            const initialSubCategoryId = <?= $product['sub_category_id'] ? $product['sub_category_id'] : 'null' ?>;
            const galleryInput = document.getElementById('gallery_images');
            const galleryError = document.getElementById('gallery_error');

            if(galleryInput) {
                galleryInput.addEventListener('change', function() {
                    if (this.files.length > 5) {
                        galleryError.classList.remove('d-none');
                        this.value = ''; // Clear the selected files
                    } else {
                        galleryError.classList.add('d-none');
                    }
                });
            }

            async function loadSubCategories(categoryId, selectedSubId = null) {
                subCategorySelect.innerHTML = '<option value="">Select Sub Category...</option>';
                if (!categoryId) return;

                try {
                    const res = await fetch(`ajax/get-subcategories.php?category_id=${categoryId}`);
                    const data = await res.json();
                    
                    data.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id; 
                        opt.textContent = sub.name;
                        if (selectedSubId && selectedSubId == sub.id) {
                            opt.selected = true;
                        }
                        subCategorySelect.appendChild(opt);
                    });
                } catch(err) {
                    console.error('Error fetching subcategories:', err);
                }
            }

            categorySelect.addEventListener('change', (e) => {
                loadSubCategories(e.target.value);
            });

            // Initial load
            if (categorySelect.value) {
                loadSubCategories(categorySelect.value, initialSubCategoryId);
            }

            const form = document.getElementById('editProductForm');
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('formMessage');

            // Variations Logic
            const colorsContainer = document.getElementById('colorsContainer');
            const optionsContainer = document.getElementById('optionsContainer');
            const addColorBtn = document.getElementById('addColorBtn');
            const addOptionBtn = document.getElementById('addOptionBtn');
            const generateVariationsBtn = document.getElementById('generateVariationsBtn');
            const variationsTableContainer = document.getElementById('variationsTableContainer');
            const variationsTableBody = document.getElementById('variationsTableBody');

            let colorCount = 0;
            let optionCount = 0;

            // Handle removal of existing rows
            document.querySelectorAll('.remove-row-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.d-flex').remove();
                });
            });
            document.querySelectorAll('.remove-var-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });

            addColorBtn.addEventListener('click', () => {
                colorCount++;
                const div = document.createElement('div');
                div.className = 'd-flex gap-2 align-items-center color-row';
                div.dataset.id = 'new_' + colorCount;
                div.innerHTML = `
                    <input type="text" class="form-control form-control-sm rounded-0 var-color-name w-50" placeholder="Color Name (e.g. Rock Blue)">
                    <input type="file" class="form-control form-control-sm rounded-0 var-color-img w-50" accept="image/*">
                    <button type="button" class="btn btn-sm btn-danger rounded-0 remove-row-btn"><i class="fas fa-times"></i></button>
                `;
                colorsContainer.appendChild(div);
                div.querySelector('.remove-row-btn').addEventListener('click', () => div.remove());
            });

            addOptionBtn.addEventListener('click', () => {
                optionCount++;
                const div = document.createElement('div');
                div.className = 'd-flex gap-2 align-items-center option-row';
                div.dataset.id = 'new_' + optionCount;
                div.innerHTML = `
                    <input type="text" class="form-control form-control-sm rounded-0 var-option-name" placeholder="Option Name (e.g. Shirt + Trousers)">
                    <button type="button" class="btn btn-sm btn-danger rounded-0 remove-row-btn"><i class="fas fa-times"></i></button>
                `;
                optionsContainer.appendChild(div);
                div.querySelector('.remove-row-btn').addEventListener('click', () => div.remove());
            });

            generateVariationsBtn.addEventListener('click', () => {
                const colorInputs = document.querySelectorAll('.var-color-name');
                const optionInputs = document.querySelectorAll('.var-option-name');
                const sizeCbs = document.querySelectorAll('.var-size-cb:checked');
                
                let colors = Array.from(colorInputs).map(inp => inp.value.trim()).filter(v => v !== '');
                let options = Array.from(optionInputs).map(inp => inp.value.trim()).filter(v => v !== '');
                let sizes = Array.from(sizeCbs).map(cb => ({ id: cb.value, name: cb.dataset.name }));
                
                if(colors.length === 0) colors = [''];
                if(options.length === 0) options = [''];
                if(sizes.length === 0) sizes = [{ id: '', name: '' }];
                
                if(colors[0] === '' && options[0] === '' && sizes[0].id === '') {
                    alert('Please add at least one color, option, or size to generate variations.');
                    return;
                }

                // Preserve existing variations
                const existingVars = {};
                document.querySelectorAll('#variationsTableBody tr').forEach(tr => {
                    const c = tr.dataset.color || '';
                    const o = tr.dataset.option || '';
                    const sid = tr.dataset.sizeId || '';
                    const key = `${c}_${o}_${sid}`;
                    existingVars[key] = {
                        id: tr.dataset.id,
                        sku: tr.querySelector('.var-sku').value,
                        price: tr.querySelector('.var-price').value,
                        sale: tr.querySelector('.var-sale').value,
                        stock: tr.querySelector('.var-stock').value,
                        status: tr.querySelector('.var-status').value
                    };
                });

                variationsTableBody.innerHTML = '';
                
                const basePrice = document.querySelector('input[name="price"]').value || '0';
                const baseSalePrice = document.querySelector('input[name="salePrice"]').value || '';

                colors.forEach(c => {
                    options.forEach(o => {
                        sizes.forEach(s => {
                            const key = `${c}_${o}_${s.id}`;
                            const ex = existingVars[key];
                            
                            const tr = document.createElement('tr');
                            tr.dataset.id = ex ? ex.id : 'new';
                            tr.dataset.color = c;
                            tr.dataset.option = o;
                            tr.dataset.sizeId = s.id;
                            tr.dataset.sizeName = s.name;

                            tr.innerHTML = `
                                <td>${c || '-'}</td>
                                <td>${o || '-'}</td>
                                <td>${s.name || '-'}</td>
                                <td><input type="text" class="form-control form-control-sm rounded-0 var-sku" placeholder="SKU" value="${ex ? ex.sku : ''}"></td>
                                <td><input type="number" class="form-control form-control-sm rounded-0 var-price" value="${ex ? ex.price : basePrice}"></td>
                                <td><input type="number" class="form-control form-control-sm rounded-0 var-sale" value="${ex ? ex.sale : baseSalePrice}"></td>
                                <td><input type="number" class="form-control form-control-sm rounded-0 var-stock" value="${ex ? ex.stock : '0'}"></td>
                                <td>
                                    <select class="form-select form-select-sm rounded-0 var-status">
                                        <option value="1" ${ex && ex.status == '1' ? 'selected' : ''}>Active</option>
                                        <option value="0" ${ex && ex.status == '0' ? 'selected' : ''}>Disabled</option>
                                    </select>
                                </td>
                                <td><button type="button" class="btn btn-sm btn-danger rounded-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
                            `;
                            variationsTableBody.appendChild(tr);
                        });
                    });
                });
                
                variationsTableContainer.classList.remove('d-none');
            });


            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                submitBtn.disabled = true;
                submitBtn.textContent = 'SAVING...';
                formMessage.innerHTML = '';

                const formData = new FormData(form);

                // Pack variations data
                const colorsData = [];
                document.querySelectorAll('.color-row').forEach(row => {
                    const id = row.dataset.id;
                    const name = row.querySelector('.var-color-name').value.trim();
                    const fileInput = row.querySelector('.var-color-img');
                    if(name) {
                        colorsData.push({ id: id, name: name });
                        if(fileInput && fileInput.files.length > 0) {
                            formData.append(`color_img_${id}`, fileInput.files[0]);
                        }
                    }
                });
                formData.append('variations_colors', JSON.stringify(colorsData));

                const optionsData = [];
                document.querySelectorAll('.option-row').forEach(row => {
                    const id = row.dataset.id;
                    const name = row.querySelector('.var-option-name').value.trim();
                    if(name) {
                        optionsData.push({ id: id, name: name });
                    }
                });
                formData.append('variations_options', JSON.stringify(optionsData));

                const varsData = [];
                document.querySelectorAll('#variationsTableBody tr').forEach(tr => {
                    varsData.push({
                        id: tr.dataset.id,
                        color: tr.dataset.color,
                        option: tr.dataset.option,
                        size_id: tr.dataset.sizeId,
                        sku: tr.querySelector('.var-sku').value,
                        price: tr.querySelector('.var-price').value,
                        sale_price: tr.querySelector('.var-sale').value,
                        stock: tr.querySelector('.var-stock').value,
                        status: tr.querySelector('.var-status').value
                    });
                });
                formData.append('variations_data', JSON.stringify(varsData));

                try {
                    const res = await fetch('ajax/update-product.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await res.json();
                    
                    if(data.success) {
                        formMessage.innerHTML = '<div class="alert alert-success rounded-0">Product updated successfully! Redirecting...</div>';
                        setTimeout(() => {
                            window.location.href = 'products.php';
                        }, 1500);
                    } else {
                        formMessage.innerHTML = `<div class="alert alert-danger rounded-0">${data.error || 'Something went wrong.'}</div>`;
                    }
                } catch (err) {
                    formMessage.innerHTML = '<div class="alert alert-danger rounded-0">A network error occurred.</div>';
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'UPDATE PRODUCT';
                }
            });
        });
    </script>
</body>
</html>