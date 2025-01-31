<?php

// Params
define('_WEBROOT_PATH_', '../../');
define('_LOG_NAME_', 'access');

if (isset($_GET['action']) && $_GET['action'] == 'addcart') :
	if (!isset($_SESSION['session_key'])) :
		header('Location: ' . _WEBROOT_PATH_.'login.php');
		exit(0);
	endif;
endif;

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

$img_blank = _WEBROOT_PATH_ . 'assets/medias/svg/blank-image.svg';

$shop_logo_path = _WEBROOT_PATH_ . 'files/shops/logos/' . $shop['shop_image_logo'];
$shop_logo = file_exists($shop_logo_path) ? $shop_logo_path : $img_blank;

$shop_cover_path = _WEBROOT_PATH_ . 'files/shops/covers/' . $shop['shop_image_cover'];
$shop_cover = file_exists($shop_cover_path) ? $shop_cover_path : $img_blank;

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
			<img src="<?php echo $shop_cover ?>" class="card-img-top object-fit-cover h-xl-500px h-lg-400px h-md-300px h-200px" alt="...">
			<div class="card-header min-h-50px">
				<div class="card-title fw-bold">
					<div class="d-flex flex-row align-items-end gap-4">
						<div class="bg-body rounded-3 p-3 mt-n20 shadow-sm">
							<div class="symbol symbol-70px">
								<img src="<?php echo $shop_logo ?>" alt="" />
							</div>
						</div>
						<spa class="fs-2">
							<?php echo $shop['shop_title'] ?>
							</span>
					</div>

				</div>
				<div class="card-toolbar">
					<a href="" class="text-gray-600">
						<i class="fa-light fa-heart fs-2"></i>
					</a>
				</div>
			</div>
			<div class="card-body d-flex flex-column gap-2">

				<?php
				if (isset($_GET['action']) && $_GET['action'] == 'addcart') :
					require './pages/options.php';
				else:
					require './pages/products.php';
				endif;
				?>

			</div>
		</div>
	</div>

	<?php require _WEBROOT_PATH_ . 'components/footer.php'; ?>

	<script src="./js/custom.js"></script>

</body>
<!--end::Body-->

</html>