<div class="flex flex-col gap-11">
    <a class="flex items-center gap-3" href="<?php echo Path::base(); ?>/"><img src="<?php echo Path::base(); ?>/src/assets/images/logo.png" alt="logo" width="220" height="360"></a>
    <?php if (!empty($userinfo) && isset($userinfo['username'])): ?>
        <div class="gap-3">
            <a class="flex items-center" href="#" id="profile-link" style="justify-content: center;">
                <div class="relative">
                    <?php //var_dump($story); ?>
                    <div class="ring-story" id="profile-link-2" data-image="<?php echo Path::base() . $userinfo['image_pic_url']; ?>" data-caption="<?php echo $userinfo['bio']; ?>">
                        <img src="<?php echo Path::base() . $userinfo['image_pic_url']; ?>" alt="profile" class="rounded-full h-14 w-14" style="width: 5.5rem;height: 5.5rem;">
                    </div>
                </div>
            </a>
            <a href="<?php echo Path::base(); ?>/profile/<?php echo $userinfo["id"]; ?>" class="flex mt-6" style="justify-content: center;margin-top:0.75rem;">
                <div class="flex flex-col">
                    <p class="body-bold" style="font-size: 24px;"><?php echo $userinfo['username'] ?></p>
                    <p class="small-regular text-light-3" style="justify-content: center;display: flex;font-size: 16px;">@<?php echo $userinfo['username'] ?></p>
                </div>
            </a>
        </div>
    <?php else: ?>
        <p>User information is not available.</p>
    <?php endif; ?>
    <?php $currentPage = $_SERVER['REQUEST_URI']; ?>
    <ul class="flex flex-col gap-6">
        <li class="leftsidebar-link group <?php echo $currentPage === Path::base() . '/' ? 'bg-primary-500' : ''; ?>">
            <a class="flex items-center gap-4 p-4 <?php echo $currentPage === Path::base() . '/' ? 'active' : ''; ?>" href="<?php echo Path::base(); ?>/">
                <img src="<?php echo Path::base(); ?>/src/assets/icons/home.svg" alt="Home" class="group-hover:invert-white <?php echo $currentPage === Path::base() . '/' ? 'invert-white' : ''; ?>">Home
            </a>
        </li>
        <li class="leftsidebar-link group <?php echo $currentPage === Path::base() . '/explore' ? 'bg-primary-500' : ''; ?>">
            <a class="flex items-center gap-4 p-4 <?php echo $currentPage === Path::base() . '/explore' ? 'active' : ''; ?>" href="<?php echo Path::base(); ?>/explore">
                <img src="<?php echo Path::base(); ?>/src/assets/icons/wallpaper.svg" alt="Explore" class="group-hover:invert-white <?php echo $currentPage === Path::base() . '/explore' ? 'invert-white' : ''; ?>">Explore
            </a>
        </li>
        <li class="leftsidebar-link group <?php echo $currentPage === Path::base() . '/all-users' ? 'bg-primary-500' : ''; ?>">
            <a class="flex items-center gap-4 p-4 <?php echo $currentPage === Path::base() . '/all-users' ? 'active' : ''; ?>" href="<?php echo Path::base(); ?>/people/<?php echo $userinfo['id']; ?>">
                <img src="<?php echo Path::base(); ?>/src/assets/icons/people.svg" alt="People" class="group-hover:invert-white <?php echo $currentPage === Path::base() . '/all-users' ? 'invert-white' : ''; ?>">People
            </a>
        </li>
        <li class="leftsidebar-link group <?php echo $currentPage === Path::base() . '/saved' ? 'bg-primary-500' : ''; ?>">
            <a class="flex items-center gap-4 p-4 <?php echo $currentPage === Path::base() . '/saved' ? 'active' : ''; ?>" href="<?php echo Path::base(); ?>/saved">
                <img src="<?php echo Path::base(); ?>/src/assets/icons/bookmark.svg" alt="Saved" class="group-hover:invert-white <?php echo $currentPage === Path::base() . '/saved' ? 'invert-white' : ''; ?>">Saved
            </a>
        </li>
        <li class="leftsidebar-link group <?php echo $currentPage === Path::base() . '/create-post' ? 'bg-primary-500' : ''; ?>">
            <a class="flex items-center gap-4 p-4 <?php echo $currentPage === Path::base() . '/create-post' ? 'active' : ''; ?>" href="<?php echo Path::base(); ?>/create-post">
                <img src="<?php echo Path::base(); ?>/src/assets/icons/gallery-add.svg" alt="Create Post" class="group-hover:invert-white <?php echo $currentPage === Path::base() . '/create-post' ? 'invert-white' : ''; ?>">Create Post
            </a>
        </li>
    </ul>
</div>
<form action="<?php echo Path::base(); ?>/logout" method="post">
    <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 shad-button_ghost">
        <img src="<?php echo Path::base(); ?>/src/assets/icons/logout.svg" alt="logout">
        <p class="small-medium lg:base-medium">Logout</p>
    </button>
</form>