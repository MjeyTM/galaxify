<?php $currentPage = $_SERVER['REQUEST_URI']; ?>
<li>
    <a class="<?php echo $currentPage === Path::base() . '/' ? 'bg-primary-500' : ''; ?> rounded-[10px] flex-center flex-col gap-1 p-2 transition" href="<?php echo Path::base(); ?>/">
        <img src="<?php echo Path::base(); ?>/src/assets/icons/home.svg" alt="Home" class=" <?php echo $currentPage === Path::base() . '/' ? 'invert-white' : 'false'; ?> " width="16" height="16">
        <p class="tiny-medium text-light-2">Home</p>
    </a>
</li>
<li>
    <a class="<?php echo $currentPage === Path::base() . '/explore' ? 'bg-primary-500' : ''; ?> rounded-[10px] false flex-center flex-col gap-1 p-2 transition" href="<?php echo Path::base(); ?>/explore">
        <img src="<?php echo Path::base(); ?>/src/assets/icons/wallpaper.svg" alt="Explore" class=" <?php echo $currentPage === Path::base() . '/explore' ? 'invert-white' : 'false'; ?>" width="16" height="16">
        <p class="tiny-medium text-light-2">Explore</p>
    </a>
</li>
<li>
    <a class="false flex-center flex-col gap-1 p-2 transition rounded-[10px] <?php echo $currentPage === Path::base() . '/saved' ? 'bg-primary-500' : ''; ?>" href="<?php echo Path::base(); ?>/saved">
        <img src="<?php echo Path::base(); ?>/src/assets/icons/bookmark.svg" alt="Saved" class=" <?php echo $currentPage === Path::base() . '/saved' ? 'invert-white' : 'false'; ?>" width="16" height="16">
        <p class="tiny-medium text-light-2">Saved</p>
    </a>
</li>
<li>
    <a class="false flex-center flex-col gap-1 p-2 transition rounded-[10px] <?php echo $currentPage === Path::base() . '/create-post' ? 'bg-primary-500' : ''; ?>" href="<?php echo Path::base(); ?>/create-post">
        <img src="<?php echo Path::base(); ?>/src/assets/icons/gallery-add.svg" alt="Create" class=" <?php echo $currentPage === Path::base() . '/create-post' ? 'invert-white' : 'false'; ?>" width="16" height="16">
        <p class="tiny-medium text-light-2">Create</p>
    </a>
</li>