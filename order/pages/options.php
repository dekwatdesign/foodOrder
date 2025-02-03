<?php

$options = [];
if (isset($_GET['product'])) :
    $productInfo = getProductInfo($_GET['product']);
    $options = getProductOptions($_GET['product']);
endif;

$product_img_path = _WEBROOT_PATH_ . 'files/products/' . $productInfo['img_name'] . '.' . $productInfo['img_ext'];
$product_img = file_exists($product_img_path) ? $product_img_path : $img_blank;
?>
<span class="d-flex flex-row w-100 bg-light rounded-2 p-4 fw-bold">เมนูที่เลือก</span>
<div class="card border border-dashed border-primary bg-light-primary">
    <div class="card-body p-4">
        <div class="d-flex flex-row gap-3">
            <div>
                <div class="symbol symbol-60px">
                    <img src="<?php echo $product_img ?>" alt="Product" />
                </div>
            </div>
            <div class="d-flex flex-column">
                <span class="fs-2 fw-bold"><?php echo $productInfo['product_title'] ?></span>
                <div>
                    <span class="fs-3 fw-bold">
                        <?php echo $productInfo['product_price'] ?>
                    </span>
                    <span class="fs-5 opacity-50">
                        บาท
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

foreach ($options as $cati => $catv) :
    $catinf = $catv['category'];
    // min = 0 / else
    $inp_type = "checkbox";
    $inp_require = "";
    $inp_name = "options[" . $cati . "]";

    if ($catinf['min'] == 1) :
        $inp_require = 'required';
        if ($catinf['max'] == 1) :
            $inp_type = "radio";
        endif;
    endif;
?>
    <span data-category="<?php echo $cati ?>" data-required="<?php echo $inp_require == 'required' ? 'true' : 'false' ?>" class="d-flex flex-row w-100 bg-light rounded-2 p-4 fw-bold"><?php echo $catinf['name'] ?></span>
    <span class="ms-2 text-gray-500"><?php echo $catinf['description'] ?></span>
    <div class="row g-4">

        <?php foreach ($catv['options'] as $oi => $ov) :
            $op_img_blank = _WEBROOT_PATH_ . 'assets/medias/svg/blank-image.svg';
            $op_img_path = _WEBROOT_PATH_ . 'files/options/' . $ov['option_img'];
            $op_img = file_exists($op_img_path) && gettype($ov['option_img']) != 'NULL' ? $op_img_path : $op_img_blank;
        ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-4">
                    <div class="d-flex gap-3 align-items-center me-2">
                        <div class="form-check form-check-custom form-check-solid form-check-primary">
                            <input class="form-check-input" type="<?php echo $inp_type ?>" name="<?php echo $inp_name ?>" value="<?php echo $ov['op_id'] ?>" />
                        </div>
                        <div class="symbol symbol-50px image-input-placeholder border border-secondary">
                            <img src="<?php echo $op_img ?>" alt="Options" />
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                <?php echo $ov['option_title'] ?>
                            </h2>
                            <div>
                                <span class="fs-5 fw-bold">
                                    <?php echo $ov['option_price'] ?>
                                </span>
                                <span class="fs-7 opacity-50">
                                    บาท
                                </span>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

        <?php endforeach; ?>
        <script>
            $(document).ready(function() {
                var limit = '<?php echo $catinf['max']; ?>';
                var catIndex = '<?php echo $cati; ?>';
                if (limit != '-1') {
                    let elm = `input[type="checkbox"][name^="options[${catIndex}]"]`;
                    $(elm).on('change', function(evt) {
                        console.log($(elm + ':checked').length);
                        if ($(elm + ':checked').length > limit) {
                            this.checked = false;
                        }
                    });
                }

            });
        </script>
    </div>

<?php
endforeach;
?>

<span class="d-flex flex-row w-100 bg-light rounded-2 p-4 fw-bold">เพิ่มโน๊ต</span>
<textarea class="form-control" name="" id="" row="2" placeholder="เช่น ไม่เอาผัก, ไม่เอากระเทียม"></textarea>

<button class="btn btn-success" onclick="sendOrder()">เพิ่ม</button>

<script>
    function sendOrder() {
        var requiredOptions = $(`[data-category][data-required="true"]`);
        var requireTitles = [];
        requiredOptions.each(function() {
            var index = $(this).attr('data-category');
            var catText = $(this).html();
            if (!$(`input[name="options[${index}]"]:checked`).length) {
                requireTitles.push(catText);
            }
        });

        if (requireTitles.length > 0) {
            alert('กรุณาเลือก:' + requireTitles.join(','));
        } else {
            let options = {};
            $(`input[name^="options"]:checked`).each(function() {
                let index = this.name.match(/\[([0-9]+)\]/)[1];
                if (!options[index]) {
                    options[index] = [];
                }
                options[index].push(this.value);
            });

            // Proceed with sending the order
            $.ajax({
                url: '<?php echo _WEBROOT_PATH_ . 'actions/order_insert.php' ?>',
                type: 'POST',
                data: {
                    shop_id: '<?php echo $shop_ref ?>',
                    product_id: '<?php echo $_GET['product'] ?>',
                    options: options
                },
                success: function(response) {
                    alert('Order sent successfully!');
                },
                error: function() {
                    alert('Failed to send order.');
                }
            });
        }
    }
</script>