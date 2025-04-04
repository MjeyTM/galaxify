<div class="px-5 py-4 flex-between">
    <a class="flex items-center gap-3" href="<?php echo Path::base(); ?>/">
        <img src="<?php echo Path::base(); ?>/src/assets/images/logo.png" alt="logo" width="150" height="340">
    </a>
    <div class="flex gap-4">
        <form action="<?php echo Path::base(); ?>/logout" method="post">
            <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 shad-button_ghost">
                <img src="<?php echo Path::base(); ?>/src/assets/icons/logout.svg" alt="logout">
            </button>
        </form>
        <?php if (!empty($userinfo) && isset($userinfo['username'])): ?>
            <a class="gap-3 flex-center" href="<?php echo Path::base(); ?>/profile/<?php echo $userinfo['id']; ?>">
                <img src="<?php echo ($userinfo["image_pic_url"] !== '') ? Path::base() . $userinfo["image_pic_url"] : Path::base() . '/src/assets/images/profiles/placeholder.png'; ?>" alt="profile" class="w-8 h-8 rounded-full">
            </a>
        <?php endif; ?>
    </div>
</div>