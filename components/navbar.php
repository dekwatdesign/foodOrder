<style>
    .navbar {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        height: var(--bs-navbar-height);
        background-color: transparent;
        padding: 1rem;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1;
    }


    @media (min-width: 992px) {
        .navbar {
            padding: 1rem 0;
        }
    }

    .navbar-body {
        background-color: var(--bs-body-bg);
        width: 100%;
        height: 100%;
        position: relative;
    }

    .navbar-logo {
        height: 35px;
    }
</style>

<div class="navbar">
    <div class="navbar-body container shadow-sm rounded-4">
        <div class="d-flex flex-row justify-content-between align-items-center w-100">

            <div class="d-flex flex-row flex-wrap align-items-center gap-3">
                <a href="<?php echo _WEBROOT_PATH_ ?>">
                    <img class="navbar-logo"
                        src="<?php echo _WEBROOT_PATH_ ?>assets/medias/logos/android-chrome-192x192.png" alt="" />
                </a>
                <a href="<?php echo _WEBROOT_PATH_ ?>"
                    class="d-lg-block d-none btn btn-sm btn-secondary d-flex flex-center gap-1">
                    <i class="ki-solid ki-home fs-3 text-inverse-secondary"></i>
                    <span class="text-center">หน้าหลัก</span>
                </a>
                <a href="<?php echo _WEBROOT_PATH_ ?>"
                    class="d-lg-none d-block btn btn-sm btn-icon btn-secondary d-flex flex-center gap-1">
                    <i class="ki-solid ki-home fs-3 text-inverse-secondary"></i>
                </a>
            </div>


            <div class="d-flex flex-row align-items-center justify-content-end gap-3">

                <!-- <div>
                    <button type="button" class="btn btn-icon btn-sm btn-secondary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-offset="0px, 15px">
                        <i class="ki-outline ki-element-11 fs-2 text-inverse-secondary"></i>
                    </button>
                </div> -->

                <?php
                if (isset($_SESSION['auth_key'])):
                    $profile = getPublishProfile($_SESSION['auth_key'], $_SESSION['auth_method']);
                    ?>
                    <button type="button" class="btn btn-icon btn-sm btn-light">
                        <i class="fa-solid fa-basket-shopping-simple fs-3"></i>
                    </button>

                    <div>
                        <!--begin::Toggle-->
                        <button type="button" class="btn btn-icon btn-sm btn-light" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end" data-kt-menu-offset="0px, 10px">
                            <div class="symbol symbol-30px">
                                <img src="<?php echo $profile['avatar_img'] ?>" class="object-fit-cover" alt="" />
                            </div>
                        </button>

                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content px-3 py-4">
                                    <div class="d-flex flex-row align-items-start justify-content-start gap-3">
                                        <div>
                                            <div class="symbol symbol-40px">
                                                <img src="<?php echo $profile['avatar_img'] ?>" class="object-fit-cover"
                                                    alt="Avatar" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column align-items-start justify-content-start gap-0">
                                            <div class="text-dark fw-bolder fs-6"><?php echo $profile['display_name'] ?>
                                            </div>
                                            <span class="badge badge-sm badge-"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="separator mb-3 opacity-75"></div>

                            <div class="menu-item px-3">
                                <a href="<?php echo _WEBROOT_PATH_ ?>profile_edit.php" class="menu-link px-3">
                                    <span class="menu-icon h-20px">
                                        <i class="ki-outline ki-user-edit fs-3"></i>
                                    </span>
                                    <span class="menu-title">แก้ไขโปรไฟล์</span>
                                </a>
                            </div>

                            <div class="separator mt-3 opacity-75"></div>

                            <div class="menu-item px-3">
                                <div class="menu-content px-3 py-3 w-100">
                                    <button class="btn btn-danger btn-sm px-4 w-100" onclick="logout()">
                                        <i class="ki-outline ki-exit-right fs-3"></i>
                                        ออกจากระบบ
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                    <?php
                else:
                    ?>
                    <a href="<?php echo _WEBROOT_PATH_ ?>login.php" class="btn btn-icon btn-sm btn-secondary">
                        <i class="fa-solid fa-right-to-bracket fs-2"></i>
                    </a>
                    <?php
                endif;
                ?>

            </div>

        </div>
    </div>
</div>