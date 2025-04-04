<?php if($contentType == "dashboard"): ?>
<!--MAIN-->
<div class="page-content">
            <div class="container-fluid">
                <!--Statistics-->
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                
                            <div class="col-md-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-md bg-soft-primary rounded">
                                                    <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"
                                                                  class="avatar-title fs-32 text-primary"></iconify-icon>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-6 text-end">
                                                <p class="text-muted mb-0 text-truncate">کاربران</p>
                                                <h3 class="text-dark mt-1 mb-0"><?php echo $usersCount; ?></h3>
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                            <div class="col-md-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-md bg-soft-primary rounded">
                                                    <iconify-icon icon="solar:streets-map-point-bold-duotone"
                                                                  class="avatar-title fs-32 text-primary"></iconify-icon>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-6 text-end">
                                                <p class="text-muted mb-0 text-truncate">پست ها</p>
                                                <h3 class="text-dark mt-1 mb-0"><?php echo $postsCount; ?></h3>
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                            <div class="col-md-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-md bg-soft-primary rounded">
                                                    <i class="bx bxs-user avatar-title fs-24 text-primary"></i>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-6 text-end">
                                                <p class="text-muted mb-0 text-truncate">ادمین ها</p>
                                                <h3 class="text-dark mt-1 mb-0">
                                                    <?php
                                                    $count = 0;
                                                    foreach($users as $user){
                                                        if($user["permission"] == 'admin'){
                                                            $count++;
                                                        }
                                                    }
                                                    echo $count;
                                                    ?>
                                                </h3>
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                    </div> <!-- end card body -->
                                    
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                            <div class="col-md-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-md bg-soft-primary rounded">
                                                    <i class="bx bx-dollar-circle avatar-title text-primary fs-24"></i>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-6 text-end">
                                                <p class="text-muted mb-0 text-truncate">مجموع پست های لایک شده</p>
                                                <h3 class="text-dark mt-1 mb-0"><?php echo $likesCount; ?></h3>
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
                <!--Statistics-->
                
                <!--middle-->
                <div class="row">
                    <div class="col-lg-6 ">
                        <!-- با کنترل‌ها -->
                        <div id="carouselExampleControls" class="carousel slide " data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php 
                                $count = 0;
                                foreach($posts as $post): ?>
                                    <div class="carousel-item <?php echo ($count === 0) ? 'active' : '' ; ?> w-100 ">
                                        <img src="<?php echo Path::base() . $post["image_url"] ; ?>" class="d-block w-100 rounded-4" alt="<?php echo $post['title']; ?>" height="500px">
                                    </div>
                                    <?php $count++; ?>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">قبلی</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">بعدی</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card card-height-100">
                            <div class="card-header d-flex align-items-center justify-content-between gap-2">
                                <h4 class="card-title flex-grow-1">کاربران اخیرا اضافه شده</h4>
                
                                <a href="<?php echo Path::base() . '/admin/users'; ?>" class="btn btn-sm btn-soft-primary">مشاهده همه</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-nowrap table-centered m-0">
                                    <thead class="bg-light bg-opacity-50">
                                    <tr>
                                        <th class="text-muted">#</th>
                                        <th class="text-muted ps-3">نام کاربری</th>
                                        <th class="text-muted">ایمیل</th>
                                        <th class="text-muted">دسترسی</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($users as $user): ?>
                                            <tr>
                                                <td class="ps-3"><img class="img-fluid avatar-sm" src="<?php echo Path::base() . $user['image_pic_url']; ?>" alt="<?php echo $user['username']; ?>"></td>
                                                <td>
                                                    <a href="<?php echo Path::base() . '/profile/' . $user["id"]; ?>">
                                                        <?php echo $user["username"]; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $user["email"]; ?>
                                                </td>
                                                <td>
                                                    <?php if($user['permission'] == 'admin'): ?>
                                                        <span class="badge badge-soft-danger">ادمین</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-soft-success">کاربر</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                       
                </div> <!-- end row -->
                <!--middle-->

                <!--Recent Posts-->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="card-title">
                                        پست های اخیر
                                    </h4>
                
                                    <a href="<?php echo Path::base() . '/create-post/' ?>" class="btn btn-sm btn-soft-primary">
                                        <i class="bx bx-plus me-1"></i>ایجاد پست
                                    </a>
                                </div>
                            </div>
                            <!-- end card body -->
                            <div class="table-responsive table-centered">
                                <table class="table mb-0">
                                    <thead class="bg-light bg-opacity-50">
                                    <tr>
                                        <th class="ps-3">شناسه</th>
                                        <th>عنوان</th>
                                        <th>کپشن</th>
                                        <th>ایجاد شده توسط</th>
                                        <th>تاریخ ثبت</th>
                                        <th>آخرین ویرایش</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <!-- end thead-->
                                    <tbody>
                                    
                                    <?php foreach($posts as $post): ?>
                                        <tr>
                                            <td class="ps-3"><?php echo $post["id"]; ?></td>
                                            <td><?php echo $post["title"]; ?></td>
                                            <td><?php echo $post["caption"]; ?></td>
                                            <td>
                                                <a href="<?php echo Path::base() . '/profile/' . $post["userid"]; ?>">
                                                    <?php echo $post["username"]; ?>
                                                </a>
                                            </td>
                                            <td><?php echo $post["created_at"]; ?></td>
                                            <td><?php echo $post["updated_at"]; ?></td>
                                            <td>
                                                <a href="<?php echo Path::base() . '/posts/' . $post["id"]; ?>" class="btn btn-sm btn-soft-primary">
                                                    مشاهده پست
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <!-- end tbody -->
                                </table>
                                <!-- end table -->
                            </div>
                            <!-- table responsive -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!--Recent Posts-->
            </div>

            <!-- ========== Footer Start ========== -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <script>document.write(new Date().getFullYear())</script> &copy; MJEYTM. ساخته شده توسط
                            <iconify-icon icon="iconamoon:heart-duotone" class="fs-18 align-middle text-danger"></iconify-icon>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- ========== Footer End ========== -->
        </div>
<?php endif; ?>

<?php if($contentType == "customers"): ?>
    <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">لیست همه کاربران</h4>
                            
                                <a href="<?php echo Path::base() . '/admin/create-user';?>" class="btn btn-sm btn-primary">
                                    افزودن کاربر
                                </a>
                            </div>
                            
                            <div>
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle">
                                        <tr>
                                            <th class="text-muted">#</th>
                                            <th class="text-muted ps-3">نام کاربری</th>
                                            <th class="text-muted">ایمیل</th>
                                            <th class="text-muted">تاریخ ایجاد</th>
                                            <th class="text-muted">آخرین ویرایش</th>
                                            <th class="text-muted">دسترسی</th>
                                        </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php 
                                            $count = 1;
                                            foreach($users as $user): ?>
                                                <tr>
                                                    <td><?php echo $count;$count++; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo Path::base() . $user['image_pic_url']; ?>" alt="<?php echo $count; ?>" class="avatar-md">
                                                            </div>
                                                            <div>
                                                                <a href="<?php echo Path::base() . '/profile/' . $user["id"]; ?>" class="text-dark fw-medium fs-15"><?php echo $user["username"]; ?></a>
                                                                <p class="text-muted mb-0 mt-1 fs-13"><span>اسم : </span><?php echo $user["name"]; ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $user["email"]; ?></td>
                                                    <td><?php echo $user["created_at"]; ?></td>
                                                    <td><?php echo $user["updated_at"]; ?></td>
                                                    <td>
                                                        <?php if($user['permission'] == 'admin'): ?>
                                                            <span class="badge badge-soft-danger">ادمین</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-soft-success">کاربر</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="<?php echo Path::base() . '/profile/' . $user["id"]; ?>" class="btn btn-light btn-sm">
                                                                <iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon>
                                                            </a>
                                                            <a href="<?php echo Path::base() . '/editprofile/' . $user["id"]; ?>" class="btn btn-soft-primary btn-sm">
                                                                <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                            </a>
                                                            <form action="<?php echo Path::base() . '/admin/deleteuser/' . $user["id"]; ?>" id="deleteForm" method="post">
                                                                <button type="submit" id="deleteBtn" class="btn btn-soft-danger btn-sm">
                                                                    <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                                </button>
                                                                
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== Footer Start ========== -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <script>document.write(new Date().getFullYear())</script> &copy; MJEYTM. ساخته شده توسط
                            <iconify-icon icon="iconamoon:heart-duotone" class="fs-18 align-middle text-danger"></iconify-icon>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- ========== Footer End ========== -->
    </div>
<?php endif; ?>

<?php if($contentType == "posts"): ?>
    <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">لیست پست ها</h4>
                            
                                <a href="<?php echo Path::base() . '/create-post'; ?>" class="btn btn-sm btn-primary">
                                    افزودن پست
                                </a>
                            
                            </div>
                            
                            <div>
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="ps-3">شناسه</th>
                                                <th></th>
                                                <th>عنوان</th>
                                                <th>کپشن</th>
                                                <th>ایجاد شده توسط</th>
                                                <th>تاریخ ثبت</th>
                                                <th>آخرین ویرایش</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php foreach($posts as $post): ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check ms-1">
                                                    <?php echo $post["id"]; ?>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                            <img src="<?php echo Path::base() . $post["image_url"]; ?>" alt="" class="avatar-md">
                                                        </div>
                                                        <div>
                                                            <a href="<?php echo Path::base() . '/posts/' . $post["id"]; ?>" class="text-dark fw-medium fs-15"><?php echo $post["title"]; ?></a>
                                                            <!-- <p class="text-muted mb-0 mt-1 fs-13"><span>اندازه : </span>S , M , L , Xl </p> -->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo $post["caption"]; ?></td>
                                                <td>
                                                    <a href="<?php echo Path::base() . '/profile/' . $post["userid"]; ?>">
                                                        <?php echo $post["username"]; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $post["created_at"]; ?></td>
                                                <td><?php echo $post["updated_at"]; ?></td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="<?php echo Path::base() . '/posts/' . $post["id"]; ?>" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a>
                                                        <a href="<?php echo Path::base() . '/edit-post/' . $post["id"]; ?>" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                        <form action="<?php echo Path::base() . '/admin-delete-post/' . $post["id"]; ?>" method="post">
                                                            <button type="submit" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></button>
                                                        </form> 
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>

            <!-- ========== Footer Start ========== -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <script>document.write(new Date().getFullYear())</script> &copy; MJEYTM. ساخته شده توسط
                            <iconify-icon icon="iconamoon:heart-duotone" class="fs-18 align-middle text-danger"></iconify-icon>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- ========== Footer End ========== -->
    </div>
<?php endif; ?>

<?php if($contentType == 'create-user'): ?>
    <div class="page-content">
            <div class="container-fluid">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">افزودن کاربر</h4>
                        </div>
                        <form action="<?php echo Path::base() . '/admin/create-user' ?>" method="post">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label text-dark">نام کاربری</label>
                                            <input type="text" id="username" name="username" class="form-control" placeholder="نام کاربری">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label text-dark">ایمیل</label>
                                            <input type="email" name="email" class="form-control" placeholder="test@gmail.com" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="">
                                            <label for="password" class="form-label text-dark">پسورد</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="">
                                            <label for="option" class="form-label">نوع کاربر</label>
                                            <select class="form-control" name="usertype" id="option">                                           
                                                <option value="user" selected>کاربر عادی</option>
                                                <option value="admin">ادمین</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer border-top">
                                <button type="submit" class="btn btn-primary">ثبت</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>