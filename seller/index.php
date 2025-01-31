<?php

// Params
define('_WEBROOT_PATH_', '../');
define('_LOG_NAME_', 'access');

// if (!isset($_GET['shop'])) {
// 	header('Location: ' . _WEBROOT_PATH_);
// 	exit(0);
// }

// Setup
require _WEBROOT_PATH_ . 'components/setup.php';
require _WEBROOT_PATH_ . 'components/verify.php';

// Logger
$logger->info('View Seller', ["page" => "seller"]);
$conn = getDatabaseConnections()['default'];
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
				<div class="card-title fw-bold">
					
				</div>
				<div class="card-toolbar">
					
				</div>
			</div>
			<div class="card-body d-flex flex-column gap-2">

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