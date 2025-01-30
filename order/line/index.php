<?php

// Params
define('_WEBROOT_PATH_', '../../');
define('_LOG_NAME_', 'access');

if (!isset($_GET['shop'])) {
	header('Location: ' . _WEBROOT_PATH_);
	exit(0);
}

// Setup
require _WEBROOT_PATH_ . 'components/setup.php';
require _WEBROOT_PATH_ . 'components/verify.php';

// Logger
$logger->info('View Index', ["page" => "index"]);
$conn = getDatabaseConnections()['default'];
$shop_ref = $_GET['shop'];
$cat_ref = isset($_GET['cat']) ? $_GET['cat'] : 0;
$shop = getShopInfo($shop_ref);
$shop_cat = getShopCategory($shop_ref);
$products = getShopProducts($shop_ref, $cat_ref);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require _WEBROOT_PATH_ . 'components/head.php'; ?>
	<?php require _WEBROOT_PATH_ . 'components/script.php'; ?>
	<script src="./assets/plugins/custom/datatables/datatables.bundle.js"></script>
</head>

<body>
	<!--begin::Theme mode setup on page load-->
	<script>
		document.documentElement.setAttribute("data-bs-theme", "light");
	</script>

	<?php require _WEBROOT_PATH_ . '/components/navbar.php'; ?>

	<div class="container flex-column-fluid px-md-0 px-4">
		<div class="card shadow-sm">
			<div class="card-header min-h-50px">
				<div class="card-title">
					<?php echo $shop['shop_title'] ?>
				</div>
				<div class="card-toolbar">
					<a href="" class="text-gray-600">
						<i class="fa-light fa-heart fs-2"></i>
					</a>
				</div>
			</div>
			<div class="card-body d-flex flex-column gap-2">

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
						<div class="badge badge-secondary badge-lg fs-1"><?php echo $vcat['name'] ?></div>
						<div class="row g-4">
							<?php foreach ($vcat['products'] as $iprod => $vprod) : ?>
								<div class="col-lg-3 col-md-4 col-6">
									<div class="card">
										<img src="..." class="card-img-top" alt="...">
										<div class="card-body d-flex flex-column gap-3">
											<span class="fs-3 fw-bold"><?php echo $vprod['product_title'] ?></span>
											<div class="d-flex flex-row flex-nowrap align-items-end lh-1 gap-1">
											<span class="fw-bold fs-5"><?php echo $vprod['product_price'] ?></span>
											<span>บาท</span>
											</div>
											
											<a href="" class="btn btn-success">ใส่ตะกร้า</a>
										</div>
										
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>
	</div>

	<?php require _WEBROOT_PATH_ . 'components/footer.php'; ?>

	<script src="./js/custom.js"></script>

	<script>

	</script>

</body>
<!--end::Body-->

</html>