<div class="d-flex flex-row flex-nowrap gap-2 hover-scroll-x">
    <a href="?shop=<?php echo $shop_ref ?>" class="<?php echo $cat_ref == 0 ? "active" : "" ?> btn btn-outline btn-outline-dashed btn-outline-primary btn-color-primary btn-active-primary rounded-4 d-flex flex-center gap-1">
        <span>ทั้งหมด</span>
    </a>
    <?php foreach ($shop_cat as $icat => $vcat) : ?>
        <a href="?shop=<?php echo $shop_ref ?>&cat=<?php echo $vcat['id'] ?>" class="<?php echo $cat_ref == $vcat['id'] ? "active" : "" ?> btn btn-outline btn-outline-dashed btn-outline-primary btn-color-primary btn-active-primary rounded-4 d-flex flex-center gap-1">
            <span><?php echo $vcat['name'] ?></span>
        </a>
    <?php endforeach; ?>
</div>

<div class="d-flex flex-column flex-nowrap gap-4">
    <?php foreach ($products as $icat => $vcat) : ?>
        <div class="badge badge-secondary badge-lg fs-3"><?php echo $vcat['name'] ?></div>
        <div class="row g-4">
            <?php foreach ($vcat['products'] as $iprod => $vprod) : 
                $img_prod_blank = _WEBROOT_PATH_.'assets/medias/svg/blank-image.svg';
                $img_prod_path = _WEBROOT_PATH_.'files/products/'.$vprod['img_name'].'.'.$vprod['img_ex'];
                $img_prod = file_exists($img_prod_path) ? $img_prod_path : $img_prod_blank;
                ?>
                <div class="col-lx-2 col-lg-3 col-md-4 col-6">
                    <div class="card">
                        <img src="<?php echo $img_prod_path ?>" class="card-img-top object-fit-cover h-150px" alt="...">
                        <div class="card-body d-flex flex-column gap-3">
                            <span class="fs-3 fw-bold"><?php echo $vprod['product_title'] ?></span>
                            <div class="d-flex flex-row flex-nowrap align-items-end lh-1 gap-1">
                                <span class="fw-bold fs-5"><?php echo $vprod['product_price'] ?></span>
                                <span>บาท</span>
                            </div>

                            <a href="?shop=<?php echo $shop_ref ?>&product=<?php echo $vprod['prod_id'] ?>&action=addcart" 
                                class="btn btn-success d-flex flex-row flex-nowrap gap-2 flex-center">
                                <i class="fa-solid fa-cart-plus fs-3"></i> 
                                <span>ใส่ตะกร้า</span>
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>