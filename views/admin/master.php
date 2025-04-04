<!DOCTYPE html>
<html lang="fa" dir="rtl" data-menu-size="sm-hover">
<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>داشبورد</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://larkon.cfarhad.ir/assets/images/favicon.ico">
    <link rel="stylesheet" href="<?php echo Path::base() . '/views/admin/'; ?>assets/css/app.css">
    <link rel="stylesheet" href="<?php echo Path::base() . '/views/admin/'; ?>assets/css/icons.css">
    <link rel="stylesheet" href="<?php echo Path::base() . '/views/admin/'; ?>assets/css/fontiran.min.css">
    <link rel="stylesheet" href="<?php echo Path::base(); ?>/src/css/sweetalert2.min.css">
    <script src="<?php echo Path::base() . '/views/admin/'; ?>assets/js/config.js"></script>
</head>
<body>
    <div class="wrapper">

        <?php include './views/admin/header.php'; ?>

        <?php include './views/admin/content.php'; ?>

    </div>
<script src="<?php echo Path::base(); ?>/src/js/sweetalert2@11.js"></script>
<script src="<?php echo Path::base() . '/views/admin/'; ?>assets/js/app.js"></script>
<script src="<?php echo Path::base() . '/views/admin/'; ?>assets/js/layout.js"></script>
<script src="<?php echo Path::base() . '/views/admin/'; ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo Path::base() . '/views/admin/'; ?>assets/libs/jsvectormap/jsvectormap.min.js"></script>
<script src="<?php echo Path::base() . '/views/admin/'; ?>assets/libs/jsvectormap/maps/world.js"></script>
<script src='<?php echo Path::base() . '/views/admin/'; ?>assets/js/pages/dashboard.js'></script>
<?php if (isset($_SESSION['error'])): ?>
        <?php 
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '". $_SESSION["error_details"]. "',
                    text: '". $_SESSION["error"]. "',
                    width: 600,
                    padding: '2em',
                    color: '#000',
                    background: '#fff',
                    backdrop: 'rgba(0,0,123,0.4)'
                });
            </script>";
        ?>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <?php 
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '" . $_SESSION["success_details"] . "',
                    text: '" . $_SESSION["success"] . "',
                    width: 600,
                    padding: '2em',
                    color: '#000',
                    background: '#fff',
                    backdrop: 'rgba(0,0,123,0.4)'
                });
            </script>
            ";
        ?>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <script>
        const btnDelete = document.getElementById("deleteBtn");
            if(btnDelete){
                btnDelete.addEventListener("click", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "آیا از حذف این مورد اطمینان دارید؟",
                        text: "این کار غیر قابل بازگشت است",
                        icon: "warning",
                        showCancelButton: true,
                        background: "#fff", // Light background
                        color: "#000", // Dark text color
                        confirmButtonColor: "#d33", // Red for the confirm button
                        cancelButtonColor: "#3085d6", // Blue for the cancel button
                        confirmButtonText: "بله حذفش کن"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("deleteForm").submit();
                        }
                    });
                });
            }
    </script>
</body>
</html>