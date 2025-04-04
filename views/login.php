<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Galaxify</title>
    <link rel="stylesheet" href="<?php echo Path::base(); ?>/src/css/output.css">
    <link rel="icon" type="image/x-icon" href="<?php echo Path::base(); ?>/src/assets/icons/favicon.ico">
    <link rel="stylesheet" href="<?php echo Path::base(); ?>/src/css/sweetalert2.min.css">
</head>
<body>
    <div id="root">
        <main class="flex h-screen">
            <section class="flex flex-col items-center justify-center flex-1 py-10">
                <div class="flex-col sm:w-420 flex-center">
                    <img src="<?php echo Path::base(); ?>/src/assets/images/logo.png" alt="logo" width="220">
                    <h2 class="pt-3 h3-bold md:h2-bold sm:pt-8">Login to your account</h2>
                    <p class="mt-2 text-light-3 small-medium md:base-regular">Welcome back, please enter your details</p>
                    <form class="flex flex-col w-full gap-5 mt-4" action="<?php echo Path::base(); ?>/login" method="post">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for=":r0:-form-item">Email</label>
                            <input type="email" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input" name="email" id=":r0:-form-item" aria-describedby=":r0:-form-item-description" aria-invalid="false" value="" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for=":r1:-form-item">Password</label>
                            <input type="password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input" name="password" id=":r1:-form-item" aria-describedby=":r1:-form-item-description" aria-invalid="false" value="" required>
                        </div>
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_primary" type="submit">Sign in</button>
                        <p class="mt-2 text-center text-small-regular text-light-2">Don't have an account?<a class="text-primary-500 text-small-semibold" href="<?php echo Path::base(); ?>/signup/"> Sign up</a></p>
                    </form>
                </div>
            </section>
            <img src="<?php echo Path::base(); ?>/src/assets/images/side-img.png" alt="logo" class="hidden object-cover w-1/2 h-screen bg-no-repeat xl:block">
            <div role="region" aria-label="Notifications (F8)" tabindex="-1" style="pointer-events: none;">
                <ol tabindex="-1" class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]"></ol>
            </div>
        </main>
    </div>
    <script src="<?php echo Path::base(); ?>/src/js/sweetalert2@11.js"></script>
    <?php if (isset($_SESSION['error'])): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: '<?php echo $_SESSION['error']; ?>',
        width: 400,
        padding: '2em',
        color: '#f44336',
        background: '#222',
        backdrop: 'rgba(0,0,123,0.4)'
    });
</script>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>
</body>
</html>