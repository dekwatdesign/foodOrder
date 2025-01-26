<?php
session_start();
define('_WEBROOT_PATH_', './');
require './components/account_info.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require _WEBROOT_PATH_ . 'components/head.html'; ?>
	<?php require _WEBROOT_PATH_ . 'components/script.html'; ?>
	<script src="./assets/plugins/custom/datatables/datatables.bundle.js"></script>
</head>

<body>
	<!--begin::Theme mode setup on page load-->
	<script>
		var defaultThemeMode = "light";
		var themeMode;
		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
			} else {
				if (localStorage.getItem("data-bs-theme") !== null) {
					themeMode = localStorage.getItem("data-bs-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}
			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-bs-theme", themeMode);
		}
	</script>

	<?php require _WEBROOT_PATH_ . '/components/navbar.php'; ?>

	<div class="container px-md-0 px-4">
		<div class="row g-4">

			<div class="col-xl-auto col-lg-auto col-md-12 col-sm-12 col-12">
				<div class="card shadow-sm rounded-4 bg-rainbow p-2 h-100">
					<div class="card shadow-sm rounded-3 h-100">
						<div class="card-body">
							<div class="d-flex flex-column align-items-center justify-center gap-3">

								<div class="symbol symbol-60px symbol-circle">
									<img class="object-fit-cover" src="<?php echo $account_info['act_img'] ?>">
								</div>

								<div class="d-flex flex-column align-items-center gap-0">
									<span class="fw-bold fs-5 text-center"><?php echo $account_info['act_full_name'] ?></span>
									<span class="text-gray-700"><?php echo $account_info['act_position'] ?></span>
									<span class="mt-1 badge badge-lg badge-<?php echo $account_info['act_role_color_class'] ?>"><?php echo $account_info['act_role_title'] ?></span>
								</div>

								<?php
								if (count($account_info['deps_name_of_leader']) > 0) {
								?>

									<div class="separator separator-dashed my-1 w-100"></div>

									<div class="d-flex flex-column align-items-center gap-1">
										<span class="fs-5 fw-bold">หัวหน้า</span>
										<?php
										foreach ($account_info['deps_name_of_leader'] as $depl_index => $depl_val) {
										?>
											<span class="badge badge-rainbow-2"><i class="fa-solid fa-crown-2 me-1"></i> <?php echo $depl_val ?></span>
										<?php
										}
										?>
									</div>
								<?php
								}
								?>

							</div>
						</div>
						<div class="card-footer text-center p-4">
							<a class="" href="./profile_edit.php">แก้ไขโปรไฟล์</a>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-4 col-lg col-md-12 col-sm-12 col-12">


				<div class="card shadow-sm rounded-4 h-100">
					<!--begin::Header-->
					<div class="card-header border-bottom-0 px-7 py-4">

						<div class="card-title fs-2 fw-bold">
							เวลา เข้า-ออก งาน
						</div>
						<div class="card-toolbar">
							<a class="btn btn-sm btn-light btn-color-primary" href="./hip_times.php">ทั้งหมด</a>
						</div>
					</div>

					<div class="card-body pt-0">

						<div class="mb-0">

							<?php
							$rno = 1;
							if ($hip_act_count == 0) {
							?>
								<span class="w-100 h-100px d-flex flex-center fs-6 text-gray-400">ไม่มีข้อมูล หรือยังไม่เชื่อมต่อเครื่องลงเวลางาน</span>
								<?php
							} else {
								foreach ($hip_act_datas as $hip_index => $hip_val) {
								?>

									<div class="d-flex flex-stack">
										<div class="d-flex align-items-center me-5">
											<!--begin::Symbol-->
											<div class="symbol symbol-30px me-5">
												<span class="symbol-label">
													<?php
													if ($hip_val['verifymodestr'] === 'FP') {
													?>
														<i class="ki-duotone ki-fingerprint-scanning text-primary fs-2tx">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
														</i>
													<?php
													} else if ($hip_val['verifymodestr'] === 'FACE') {
													?>
														<i class="ki-duotone ki-faceid text-success fs-2tx">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
															<span class="path6"></span>
														</i>
													<?php
													}
													?>
												</span>
											</div>
											<div class="me-5">
												<div class="d-flex flex-row align-items-center text-gray-800 fw-bold fs-6">
													<span class="w-20px"><i class="ki-outline ki-calendar text-gray-800 fs-3"></i></span>
													<span><?php echo $hip_val['date']; ?></span>
												</div>
												<div class="d-flex flex-row align-items-center text-gray-500 fw-semibold fs-7">
													<span class="w-20px"><i class="ki-outline ki-time fs-6"></i></span>
													<span><?php echo $hip_val['time']; ?></span>
												</div>
											</div>
										</div>
										<div class="d-flex align-items-center gap-1">

											<?php
											if ($hip_val['istoday'] == true) {
											?>
												<span class="badge badge-light-success">วันนี้</span>
											<?php
											}
											?>

											<div class="badge badge-<?php echo $hip_val['dayColor']; ?>">
												<span><?php echo $hip_val['dayTH']; ?></span>
											</div>

										</div>
									</div>
									<?php
									if ($rno != $hip_act_count) {
									?>
										<div class="separator separator-dashed my-3"></div>
							<?php
									}
									$rno++;
								}
							}

							?>

						</div>
						<!--end::Items-->
					</div>
					<!--end::Body-->
				</div>
			</div>

			<div class="col-xl col-lg-6 col-md-6 col-sm-6 col-6">
				<div class="card shadow-sm rounded-4 h-100 bg-primary">
					<div class="card-body">
						<div class="d-flex flex-column flex-center h-100">
							<span class="fw-bold fs-2hx text-inverse-primary">วันลา</span>
							<!--begin::Section-->
							<div class="d-flex flex-column flex-column-fluid flex-center my-7">
								<!--begin::Number-->
								<div class="d-flex flex-row flex-nowrap align-items-end gap-1">
									<span class="fs-7hx text-inverse-primary lh-1 fw-semibold">...</span>
									<span class="fs-4x text-inverse-primary lh-1 pb-3">/</span>
									<span class="fs-4x text-inverse-primary lh-1 pb-2">...</span>
								</div>

								<!--end::Number-->
								<!--begin::Follower-->
								<span class="fw-semibold fs-6 text-white opacity-50">(ลาแล้ว/เหลือ)</span>
								<span class="fw-semibold fs-2 text-white opacity-75">วัน</span>
								<!--end::Follower-->
							</div>
							<!--end::Section-->

							<!--begin::Progress-->
							<!-- <div class="d-flex align-items-center flex-column mt-3 w-100">
								<div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
									<span>ลาแล้ว</span>
									<span>20%</span>
								</div>
								<div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
									<div class="bg-white rounded h-8px" role="progressbar" style="width: 20%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div> -->
							<!--end::Progress-->
						</div>
					</div>
					<div class="card-footer border-top-0 text-center p-4">
						<a class="text-inverse-primary" href="#">ทั้งหมด</a>
					</div>
				</div>
			</div>

			<div class="col-xl col-lg-6 col-md-6 col-sm-6 col-6">
				<div class="card shadow-sm rounded-4 h-100 bg-danger">
					<div class="card-body">
						<div class="d-flex flex-column flex-center h-100">
							<span class="fw-bold fs-2hx text-inverse-primary">งาน</span>
							<!--begin::Section-->
							<div class="d-flex flex-column flex-column-fluid flex-center my-7">
								<!--begin::Number-->
								<span class="fw-semibold fs-7hx text-inverse-primary lh-1 ls-n2">...</span>
								<!--end::Number-->
								<!--begin::Follower-->
								<span class="fw-semibold fs-6 text-white opacity-50">(ยังไม่เสร็จ)</span>
								<span class="fw-semibold fs-2 text-white opacity-75">งาน</span>
								<!--end::Follower-->
							</div>
							<!--end::Section-->
						</div>
					</div>
					<div class="card-footer border-top-0 text-center p-4">
						<a class="text-inverse-danger" href="#">ทั้งหมด</a>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card shadow-sm rounded-4">
					<div class="card-header">
						<div class="card-title fw-bold fs-3">สิ่งที่ต้องทำ</div>
						<div class="card-toolbar">
							<button class="btn btn-sm btn-bg-light btn-color-primary">
								ทั้งหมด
							</button>
						</div>
					</div>
					<div class="card-body">
						<span class="w-100 h-100px d-flex flex-center fs-2x text-gray-400">เร็วๆนี้</span>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card shadow-sm rounded-4">
					<div class="card-header">
						<div class="card-title fw-bold fs-3">บริการ (ภายใน)</div>
						<div class="card-toolbar">
							<button class="btn btn-sm btn-bg-light btn-color-primary">
								ทั้งหมด
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="row g-4">
							<?php
							foreach ($work_prv_apps as $work_prv_app_index => $work_prv_app_val) {
							?>
								<div class="col-xl-2 col-lg-4 col-md-4 col-6">
									<a href="./<?php echo $work_prv_app_val['app_file'] ?>?pkey=<?php echo $work_prv_app_val['app_permission_key_default'] ?>" class="card bg-white shadow-sm rounded-4 h-100">
										<div class="ribbon ribbon-sm ribbon-top ribbon-vertical">
											<div class="ribbon-label bg-danger min-w-10px min-h-40px">
												<i class="fa-solid fa-lock text-inverse-danger fs-6"></i>
											</div>
										</div>
										<div class="card-body pb-2 position-relative">
											<div class="d-flex flex-column flex-center gap-3">
												<div class="d-flex flex-column gap-3">
													<div class="symbol symbol-45px rounded-3 bg-gray-100 p-2">
														<?php
														if ($work_prv_app_val['icon_type'] == 'img') {
														?>
															<img class="object-fit-contain" src="./assets/images/" alt="" />
														<?php
														} else if ($work_prv_app_val['icon_type'] == 'class') {
														?>
															<div class="symbol-label fs-2x fw-semibold">
																<i class="<?php echo $work_prv_app_val['icon_value'] ?> <?php echo $work_prv_app_val['icon_class'] ?>"></i>
															</div>
														<?php
														}
														?>

													</div>
												</div>
												<div class="d-flex flex-column align-items-start gap-1">
													<h5 class="text-center fw-bold"><?php echo $work_prv_app_val['title'] ?></h5>
												</div>
											</div>
										</div>
									</a>
								</div>
							<?php
							}

							foreach ($work_apps as $work_app_index => $work_app_val) {
							?>
								<div class="col-xl-2 col-lg-4 col-md-4 col-6">
									<a href="#" class="card bg-white shadow-sm rounded-4 h-100">
										<div class="card-body pb-2 position-relative">
											<div class="d-flex flex-column flex-center gap-3">
												<div class="d-flex flex-column gap-3">
													<div class="symbol symbol-45px rounded-3 bg-gray-100 p-2">
														<?php
														if ($work_app_val['icon_type'] == 'img') {
														?>
															<img class="object-fit-contain" src="./assets/images/" alt="" />
														<?php
														} else if ($work_app_val['icon_type'] == 'class') {
														?>
															<div class="symbol-label fs-2x fw-semibold <?php echo $work_app_val['icon_class'] ?>">
																<i class="<?php echo $work_app_val['icon_value'] ?>"></i>
															</div>
														<?php
														}
														?>

													</div>
												</div>
												<div class="d-flex flex-column align-items-start gap-1">
													<h5 class="text-center fw-bold"><?php echo $work_app_val['title'] ?></h5>
												</div>
											</div>
										</div>
									</a>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card shadow-sm rounded-4">
					<div class="card-header">
						<div class="card-title fw-bold fs-3">บริการ (ภายนอก)</div>
						<div class="card-toolbar">
							<button class="btn btn-sm btn-bg-light btn-color-primary">
								ทั้งหมด
							</button>
						</div>
					</div>
					<div class="card-body">
						<span class="w-100 h-100px d-flex flex-center fs-2x text-gray-400">เร็วๆนี้</span>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php require _WEBROOT_PATH_ . 'components/footer.php'; ?>
	
	<script src="./js/custom.js"></script>
	
</body>
<!--end::Body-->

</html>