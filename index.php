<?php
// Params
define('_WEBROOT_PATH_', './');
define('_LOG_NAME_', 'access');

// Setup
require _WEBROOT_PATH_ . 'components/setup.php';
require _WEBROOT_PATH_ . 'components/verify.php';

// Logger
$logger->info('View Index', ["page" => "index"]);

$shops = getShops();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require _WEBROOT_PATH_ . 'components/head.php'; ?>
	<?php require _WEBROOT_PATH_ . 'components/script.php'; ?>
	<script src="<?php echo _WEBROOT_PATH_ ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
</head>

<body>
	<!--begin::Theme mode setup on page load-->
	<script>
		document.documentElement.setAttribute("data-bs-theme", "light");
	</script>

	<?php require _WEBROOT_PATH_ . '/components/navbar.php'; ?>

	<div class="flex-column-fluid container px-md-0 px-4  d-flex flex-column">
		<div class="flex-column-fluid card shadow-sm rounded-4">
			<div class="card-body">
				<div class="row g-4">

					<?php foreach ($shops as $si => $sv) : 
						$img_shop_blank = _WEBROOT_PATH_.'assets/medias/svg/blank-image.svg';
						$img_shop_path = _WEBROOT_PATH_.'files/shops/logos/'.$sv['shop_image_logo'];
						$img_shop = file_exists($img_shop_path) ? $img_shop_path : $img_shop_blank;
						?>
						<div class="col-lg-3 col-md-6 col-12">
							<a href="<?php echo _WEBROOT_PATH_ ?>order/line/?shop=<?php echo $sv['id'] ?>" class="card">
								<div class="card-body p-4">
									<div class="d-flex flex-md-column flex-row align-items-md-center align-items-start gap-3">
										<div>
											<div class="symbol symbol-70px image-input-placeholder border border-secondary">
												<img src="<?php echo $img_shop ?>" alt="Shop" />
											</div>
										</div>
										<div class="d-flex flex-column gap-1">
											<span class="fs-3 fw-bold"><?php echo $sv['shop_title'] ?></span>
											<span></span>
											<div class="d-flex flex-row gap-2">
												<div class="d-flex flex-row flex-nowrap gap-1">
													<div class="rating">
														<div class="rating-label checked">
															<i class="ki-duotone ki-star"></i>
														</div>
													</div>
													<span>4.8</span>
												</div>
												<span class="text-gray-400">|</span>
												<span>3km</span>
												<span class="text-gray-400">|</span>
												<span>29min</span>
												<span class="text-gray-400">|</span>
												<span class="text-success"><i class="fa-solid fa-moped"></i> ฟรี</span>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>

	<?php require _WEBROOT_PATH_ . 'components/footer.php'; ?>

	<script src="./js/custom.js"></script>

</body>
<!--end::Body-->

</html>