<?php
require_once('../inc/db.php');
require_once('inc/admin-top.php');

$categories = [];
$catRes = $conn->query("SELECT id, name FROM categories WHERE status = 1 ORDER BY name ASC");
if ($catRes) {
    while ($row = $catRes->fetch_assoc()) {
        $categories[] = $row;
    }
}

$dbSizes = [];
$sizeRes = $conn->query("SELECT * FROM sizes WHERE status = 1 ORDER BY sort_order ASC");
if ($sizeRes) {
    while ($row = $sizeRes->fetch_assoc()) {
        $dbSizes[] = $row;
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
            <h2 class="font-heading mb-4">Add New Product</h2>

            <form id="addProductForm" enctype="multipart/form-data">
                <div class="row font-body">
                    <div class="col-lg-8">
                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold mb-4 rounded-0">
                            <h5 class="mb-4">Basic Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Product Title</label>
                                <input type="text" name="name" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. Velvet Embroidered Suit" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Short Description</label>
                                <textarea name="shortDescription" class="form-control rounded-0 shadow-none border-secondary" rows="2" placeholder="Brief summary for the product cards"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Description</label>
                                <textarea id="summernote" name="description" class="form-control rounded-0 shadow-none border-secondary" rows="5"></textarea>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Regular Price (PKR)</label>
                                    <input type="number" name="price" class="form-control rounded-0 shadow-none border-secondary" placeholder="0.00" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold mt-4 pt-2">
                                        <input type="checkbox" name="sale" id="isSale" class="form-check-input me-1 rounded-0"> On Sale
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Sale Price (PKR)</label>
                                    <input type="number" name="salePrice" id="salePrice" class="form-control rounded-0 shadow-none border-secondary" placeholder="0.00" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold mb-4 rounded-0">
                            <h5 class="mb-4">Attributes</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fabric</label>
                                    <input type="text" name="fabric" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. Pure Silk">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Collection</label>
                                    <input type="text" name="collection" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. Festive Evening">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Sizes <small class="text-muted fw-normal d-block fs-8">(Comma separated - Legacy)</small></label>
                                    <input type="text" name="sizes" class="form-control rounded-0 shadow-none border-secondary" placeholder="S, M, L, XL, Custom">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Colors <small class="text-muted fw-normal d-block fs-8">(Comma separated - Legacy)</small></label>
                                    <input type="text" name="colors" class="form-control rounded-0 shadow-none border-secondary" placeholder="Red, Blue, As Pictured">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Pieces <small class="d-block">&nbsp;</small></label>
                                    <input type="text" name="pieces" class="form-control rounded-0 shadow-none border-secondary" placeholder="e.g. 3 Piece">
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
                                        <!-- Color rows injected here -->
                                    </div>
                                    <button type="button" id="addColorBtn" class="btn btn-sm btn-outline-dark rounded-0">+ Add Color</button>
                                </div>

                                <!-- Options -->
                                <div class="col-12">
                                    <h6 class="fw-bold">Options (e.g. Shirt + Trousers)</h6>
                                    <div id="optionsContainer" class="d-flex flex-column gap-2 mb-2">
                                        <!-- Option rows injected here -->
                                    </div>
                                    <button type="button" id="addOptionBtn" class="btn btn-sm btn-outline-dark rounded-0">+ Add Option</button>
                                </div>

                                <!-- Sizes -->
                                <div class="col-12">
                                    <h6 class="fw-bold">Sizes</h6>
                                    <div class="d-flex flex-wrap gap-3">
                                        <?php foreach ($dbSizes as $sz): ?>
                                            <div class="form-check">
                                                <input class="form-check-input var-size-cb rounded-0" type="checkbox" value="<?= $sz['id'] ?>" id="size_<?= $sz['id'] ?>" data-name="<?= htmlspecialchars($sz['name']) ?>">
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

                            <div id="variationsTableContainer" class="mt-4 table-responsive d-none">
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
                                        <!-- Variations rows injected here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-white p-4 shadow-sm border-top border-3 border-gold rounded-0 mb-4 mb-lg-0">
                            <h5 class="mb-4">Media</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Main Image</label>
                                    <input type="file" name="main_image" class="form-control rounded-0 shadow-none border-secondary" accept="image/*" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Hover Image</label>
                                    <input type="file" name="hover_image" class="form-control rounded-0 shadow-none border-secondary" accept="image/*">
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
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub Category</label>
                                <select name="sub_category_id" id="subCategorySelect" class="form-select rounded-0 shadow-none border-secondary" required>
                                    <option value="">Select Sub Category...</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Stock Quantity</label>
                                <input type="number" name="stock" class="form-control rounded-0 shadow-none border-secondary" value="0" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Availability</label>
                                <select name="availability" class="form-select rounded-0 shadow-none border-secondary">
                                    <option value="In Stock">In Stock</option>
                                    <option value="Out of Stock">Out of Stock</option>
                                    <option value="Low Stock">Low Stock</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tags (Comma separated)</label>
                                <input type="text" name="tags" class="form-control rounded-0 shadow-none border-secondary" placeholder="Bridal, Velvet, Red">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" id="submitBtn" class="btn btn-dark font-body py-3 rounded-0 fw-bold">SAVE PRODUCT</button>
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

            categorySelect.addEventListener('change', async (e) => {
                const categoryId = e.target.value;

                // Clear current options
                subCategorySelect.innerHTML = '<option value="">Select Sub Category...</option>';
                
                if (!categoryId) return;

                try {
                    const res = await fetch(`ajax/get-subcategories.php?category_id=${categoryId}`);
                    const data = await res.json();
                    
                    data.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id; // Use ID for foreign key
                        opt.textContent = sub.name;
                        subCategorySelect.appendChild(opt);
                    });
                } catch(err) {
                    console.error('Error fetching subcategories:', err);
                }
            });

            const form = document.getElementById('addProductForm');
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
            
            addColorBtn.addEventListener('click', () => {
                colorCount++;
                const div = document.createElement('div');
                div.className = 'd-flex gap-2 align-items-center color-row';
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
                div.innerHTML = `
                    <input type="text" class="form-control form-control-sm rounded-0 var-option-name" placeholder="Option Name (e.g. Shirt + Trousers)">
                    <button type="button" class="btn btn-sm btn-danger rounded-0 remove-row-btn"><i class="fas fa-times"></i></button>
                `;
                optionsContainer.appendChild(div);
                div.querySelector('.remove-row-btn').addEventListener('click', () => div.remove());
            });

            let generatedVariations = [];

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

                variationsTableBody.innerHTML = '';
                generatedVariations = [];
                let varIndex = 0;

                const basePrice = document.querySelector('input[name="price"]').value || '0';
                const baseSalePrice = document.querySelector('input[name="salePrice"]').value || '';

                colors.forEach(c => {
                    options.forEach(o => {
                        sizes.forEach(s => {
                            varIndex++;
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${c || '-'}</td>
                                <td>${o || '-'}</td>
                                <td>${s.name || '-'}</td>
                                <td><input type="text" class="form-control form-control-sm rounded-0 var-sku" data-idx="${varIndex}" placeholder="SKU"></td>
                                <td><input type="number" class="form-control form-control-sm rounded-0 var-price" data-idx="${varIndex}" value="${basePrice}"></td>
                                <td><input type="number" class="form-control form-control-sm rounded-0 var-sale" data-idx="${varIndex}" value="${baseSalePrice}"></td>
                                <td><input type="number" class="form-control form-control-sm rounded-0 var-stock" data-idx="${varIndex}" value="0"></td>
                                <td>
                                    <select class="form-select form-select-sm rounded-0 var-status" data-idx="${varIndex}">
                                        <option value="1">Active</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </td>
                                <td><button type="button" class="btn btn-sm btn-danger rounded-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
                            `;
                            // Attach data for parsing later
                            tr.dataset.color = c;
                            tr.dataset.option = o;
                            tr.dataset.sizeId = s.id;
                            tr.dataset.sizeName = s.name;
                            
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
                document.querySelectorAll('.color-row').forEach((row, idx) => {
                    const name = row.querySelector('.var-color-name').value.trim();
                    const fileInput = row.querySelector('.var-color-img');
                    if(name) {
                        colorsData.push({ id: 'new_'+idx, name: name });
                        if(fileInput.files.length > 0) {
                            formData.append(`color_img_new_${idx}`, fileInput.files[0]);
                        }
                    }
                });
                formData.append('variations_colors', JSON.stringify(colorsData));

                const optionsData = [];
                document.querySelectorAll('.option-row').forEach((row, idx) => {
                    const name = row.querySelector('.var-option-name').value.trim();
                    if(name) {
                        optionsData.push({ id: 'new_'+idx, name: name });
                    }
                });
                formData.append('variations_options', JSON.stringify(optionsData));

                const varsData = [];
                document.querySelectorAll('#variationsTableBody tr').forEach(tr => {
                    varsData.push({
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
                    const res = await fetch('ajax/process-product.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await res.json();
                    
                    if(data.success) {
                        formMessage.innerHTML = '<div class="alert alert-success rounded-0">Product added successfully!</div>';
                        form.reset();
                        salePriceInp.disabled = true;
                        variationsTableContainer.classList.add('d-none');
                        colorsContainer.innerHTML = '';
                        optionsContainer.innerHTML = '';
                    } else {
                        formMessage.innerHTML = `<div class="alert alert-danger rounded-0">${data.error || 'Something went wrong.'}</div>`;
                    }
                } catch (err) {
                    formMessage.innerHTML = '<div class="alert alert-danger rounded-0">A network error occurred.</div>';
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'SAVE PRODUCT';
                }
            });
        });
    </script>
</body>

</html>