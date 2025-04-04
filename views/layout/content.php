<!-- home_content.php -->
<?php if (isset($contentType) && $contentType == 'posts'): ?>
<div class="flex flex-1">
    <div class="home-container">
        <div class="home-posts">
            <h2 class="w-full text-left h3-bold md:h2-bold">Home Feed</h2>
            <ul class="flex flex-col flex-1 w-full gap-9">
            <?php if (empty($posts)): ?>
                <p>No posts found.</p>
            <?php else: ?>
                <?php //var_dump($posts,$details); ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="flex-between">
                            <div class="flex items-center gap-3">
                                    <a class="ring-story" 
                                    id="profile-link-<?php echo $post["userid"]+1 ; ?>"
                                    href="<?php echo Path::base() ?>/profile/<?php echo $post["user_id"]; ?>"
                                    data-image="<?php echo ($post['userpic'] !== '') ?  Path::base() . $post['userpic'] : Path::base() . '/src/assets/images/profiles/placeholder.png'; ?>"
                                    data-caption="This is the caption for the story" >
                                        <img src="<?php echo ($post["userpic"] !== '') ? Path::base() . $post["userpic"] : Path::base() . '/src/assets/images/profiles/placeholder.png';  ?>" alt="creator" class="w-12 rounded-full lg:h-12">
                                    </a>
                                <div class="flex flex-col">
                                    <p class="base-medium lg:body-bold text-light-1"><?php echo $post["username"]; ?></p>
                                    <div class="gap-2 flex-center text-light-3">
                                        <p class="subtle-semibold lg:small-regular"><?php echo timeAgo($post["created_at"]); ?></p>
                                        -
                                        <p class="subtle-semibold lg:small-regular"><?php echo $post["location"]; ?></p>
                                    </div>
                                </div>
                            </div>
                            <a class="hidden" href="<?php echo Path::base() ?>/update-post/<?php echo $post["id"]; ?>"><img src="<?php echo Path::base(); ?>/src/assets/icons/edit.svg" alt="edit" width="20" height="20"></a>
                        </div>
                        <a href="<?php echo Path::base() ?>/posts/<?php echo $post["id"]; ?>">
                            <div class="py-5 small-medium lg:base-medium">
                                <p><?php echo $post["title"]; ?></p>
                                <p class="pt-3 small-medium"><?php echo $post["caption"]; ?></p>
                                <ul class="flex gap-1 mt-2">
                                    <?php $tags = explode(',',$post["tags"]); ?>
                                    <?php foreach($tags as $tag): ?>
                                        <li class="text-light-3">#<?php echo $tag; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <img src="<?php echo isset($post["image_url"]) ? Path::base() . $post["image_url"] : Path::base() . '/src/assets/images/profiles/placeholder.png';  ?>" class="post-card_img" alt="post image">
                        </a>
                        <div class="z-20 flex items-center justify-between">
                            <div class="flex gap-2 mr-5">
                                <?php 
                                    $likeDetails = ["userLiked" => 0, "likesCount" => 0]; 
                                    foreach ($details as $detail) {
                                        if ($detail["post_id"] === $post["id"]) {
                                            $likeDetails = $detail;
                                            break;
                                        }
                                    }
                                ?>
                                <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $likeDetails["userLiked"] ? 'liked' : 'like'; ?>.svg" alt="like" 
                                    class="like-btn cursor-pointer" 
                                    data-post-id="<?php echo $post["id"]; ?>" 
                                    data-liked="<?php echo $likeDetails["userLiked"]; ?>" 
                                    width="20" height="20">
                                <p class="small-medium lg:base-medium" id="like-count-<?php echo $post["id"]; ?>">
                                    <?php echo $likeDetails["likesCount"]; ?>
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <?php 
                                    $saveDetails = ["userSaved" => 0, "savesCount" => 0]; 
                                    foreach ($savedPostStats as $savedPostStat) {
                                        if ($savedPostStat["post_id"] === $post["id"]) {
                                            $saveDetails = $savedPostStat;
                                            break;
                                        }
                                    }
                                ?>
                                <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $saveDetails["userSaved"] ? 'saved' : 'save'; ?>.svg" alt="save" 
                                    class="save-btn cursor-pointer" 
                                    data-post-id="<?php echo $post["id"]; ?>" 
                                    data-saved="<?php echo $saveDetails["userSaved"]; ?>" 
                                    width="20" height="20">
                                <p class="small-medium lg:base-medium" id="save-count-<?php echo $post["id"]; ?>">
                                    <?php echo $saveDetails["savesCount"]; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>        
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (isset($contentType) && $contentType == 'create-post'): ?>
<div class="flex flex-1">
    <div class="common-container">
        <div class="w-full max-w-5xl gap-3 flex-start justify-normal">
            <img src="<?php echo Path::base(); ?>/src/assets/icons/add-post.svg" alt="add-post" width="36" height="36" />
            <h2 class="w-full text-left h3-bold md:h2-bold">Create Post</h2>
        </div>
        <form class="flex flex-col w-full max-w-5xl gap-9" action="<?php echo Path::base(); ?>/create-post" method="post" enctype="multipart/form-data">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="title">Title</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="title"
                    id="title"
                    aria-describedby="title-description"
                    value=""
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="caption">Caption</label>
                <textarea
                    class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:bg-slate-950 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 shad-textarea custom-scrollbar"
                    name="caption"
                    id="caption"
                    aria-describedby="caption-description"
                ></textarea>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="postimg">Add Photos</label>
                <div role="presentation" tabindex="0" class="flex flex-col cursor-pointer flex-center rounded-xl bg-dark-3">
                    <!-- Hidden File Input -->
                    <input
                        accept="image/*,.png,.jpeg,.jpg,.svg"
                        multiple
                        type="file"
                        name="postimg"
                        id="file-upload"
                        tabindex="-1"
                        class="file-input"
                        style="display:none"
                        required
                    />
                    <div class="file_uploader-box" onclick="document.getElementById('file-upload').click()">
                        <img src="<?php echo Path::base(); ?>/src/assets/icons/file-upload.svg" width="96" height="77" alt="file-upload" />
                        <h3 class="mt-6 mb-2 base-medium text-light-2">Drag Photo here</h3>
                        <p class="mb-6 text-light-4 small-regular">SVG, PNG, JPG</p>
                        <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4">
                            Select from computer
                        </a>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="location">Add Location</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="location"
                    id="location"
                    value=""
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="tags">Add Tags (separated by comma ',')</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    placeholder="Nature, Sci-Fi, Love"
                    name="tags"
                    id="tags"
                    value=""
                />
            </div>
            <div class="flex items-center justify-end gap-4">
                <button type="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_primary whitespace-nowrap">
                    Create Post
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php if (isset($contentType) && $contentType == 'explore'): ?>
    <?php //echo var_dump($posts); ?>
    <div class="explore-container">
        <div class="explore-inner_container">
            <h2 class="w-full h3-bold md:h2-bold">Search Posts</h2>
            <div class="flex w-full gap-1 px-4 rounded-lg bg-dark-4">
                <img src="<?php echo Path::base(); ?>/src/assets/icons/search.svg" width="24" height="24" alt="search">
                <input type="text" id="search-input" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 explore-search" placeholder="Search" value="">
            </div>
        </div>
        <div class="w-full max-w-5xl mt-16 flex-between mb-7">
            <h3 class="body-bold md:h3-bold">Popluar Today</h3>
            <div class="relative">
                <style>
                    .hidden {
                        display: none;
                    }

                    .flex-center {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .bg-dark-3 {
                        background-color: #333; /* Example dark background */
                    }

                    .hover\:bg-dark-2:hover {
                        background-color: #555; /* Example hover effect */
                    }

                    .rounded-xl {
                        border-radius: 12px;
                    }

                    .shadow-md {
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                    }
                </style>
                <div id="filter-btn" class="gap-3 px-4 py-2 cursor-pointer flex-center bg-dark-3 rounded-xl">
                    <p id="filter-label" class="small-medium md:base-medium text-light-2">All</p>
                    <img src="<?php echo Path::base(); ?>/src/assets/icons/filter.svg" width="20" height="20" alt="filter">
                </div>

                <!-- Dropdown Menu -->
                <ul id="filter-menu" class="hidden absolute left-0 mt-2 w-40 bg-dark-3 rounded-lg shadow-md" style="z-index: 10;">
                    <li class="filter-option px-4 py-2 cursor-pointer hover:bg-dark-2" data-filter="all">All</li>
                    <li class="filter-option px-4 py-2 cursor-pointer hover:bg-dark-2" data-filter="last_day">Last Day</li>
                    <li class="filter-option px-4 py-2 cursor-pointer hover:bg-dark-2" data-filter="last_week">Last Week</li>
                    <li class="filter-option px-4 py-2 cursor-pointer hover:bg-dark-2" data-filter="last_month">Last Month</li>
                </ul>
            </div>
        </div>
        <div class="flex flex-wrap w-full max-w-5xl gap-9">
            <ul class="grid-container" id="grid-container">
                <?php foreach($posts as $post): ?>
                    <li class="relative min-w-80 h-80"> 
                        <a class="grid-post_link" href="<?php echo Path::base(); ?>/posts/<?php echo $post['id']; ?>">
                            <img src="<?php echo isset($post["image_url"]) ? Path::base() . $post["image_url"] : Path::base() . '/src/assets/images/profiles/placeholder.png';  ?>" alt="post" class="object-cover w-full h-full">
                        </a>
                        <div class="grid-post_user">
                            <div class="flex items-center justify-start flex-1 gap-2">
                                <img src="<?php echo ($post["image_pic_url"] !== '') ? Path::base() . $post["image_pic_url"] : Path::base() . '/src/assets/images/profiles/placeholder.png';  ?>" alt="creator" class="w-8 h-8 rounded-full">
                                <p class="line-clamp-1"><?php echo $post['username']; ?></p>
                            </div>
                            <div class="z-20 flex items-center justify-between">
                                <div class="flex gap-2 mr-5">
                                    <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $post["userLiked"] ? 'liked' : 'like'; ?>.svg" alt="like" 
                                        class="like-btn cursor-pointer" 
                                        data-post-id="<?php echo $post["id"]; ?>" 
                                        data-liked="<?php echo $post["userLiked"]; ?>" 
                                        width="20" height="20">
                                    <p class="small-medium lg:base-medium" id="like-count-<?php echo $post["id"]; ?>">
                                        <?php echo $post["likesCount"]; ?>
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $post["userSaved"] ? 'saved' : 'save'; ?>.svg" alt="save" 
                                        class="save-btn cursor-pointer" 
                                        data-post-id="<?php echo $post["id"]; ?>" 
                                        data-saved="<?php echo $post["userSaved"]; ?>" 
                                        width="20" height="20">
                                    <p class="small-medium lg:base-medium" id="save-count-<?php echo $post["id"]; ?>">
                                        <?php echo $post["savesCount"]; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php if(isset($contentType) && $contentType === 'details'): ?>
    <div class="post_details-container">
        <div class="post_details-card">
        <?php //var_dump($post); ?>
            <img
                src="<?php echo isset($post["image_url"]) ? Path::base() . $post["image_url"] : Path::base() . '/src/assets/images/profiles/placeholder.png';  ?>"
                alt="post"
                class="post_details-img"
            />
            <div class="post_details-info">
                <div class="w-full flex-between">
                    <a class="flex items-center gap-3" href="<?php echo Path::base() ?>/profile/<?php echo $post["user_id"]; ?>">
                        <img src="<?php echo ($post["image_pic_url"] !== '') ? Path::base() . $post["image_pic_url"] : Path::base() . '/src/assets/images/profiles/placeholder.png'; ?>" alt="creator" class="w-12 rounded-full lg:h-12" />
                        <div class="flex flex-col">
                            <p class="base-medium lg:body-bold text-light-1"><?php echo $post["username"]; ?></p>
                            <div class="gap-2 flex-center text-light-3">
                                <p class="subtle-semibold lg:small-regular"><?php echo timeAgo($post["created_at"]); ?></p>
                                -
                                <p class="subtle-semibold lg:small-regular"><?php echo $post["location"]; ?></p>
                            </div>
                        </div>
                    </a>
                    <div class="gap-4 flex-center">
                        <?php if($post["isCreated"] === 1): ?>
                            <a class="false" href="<?php echo Path::base(); ?>/edit-post/<?php echo $post["id"]; ?>">
                                <img src="<?php echo Path::base(); ?>/src/assets/icons/edit.svg" alt="edit" width="24" height="24" />
                            </a>
                            <form action="<?php echo Path::base(); ?>/delete-post/<?php echo $post["id"]; ?>" method="post" id="deleteForm">
                                <button type="submit" id="deleteBtn"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 ghost_details-delete_btn false"
                                >
                                    <img src="<?php echo Path::base(); ?>/src/assets/icons/delete.svg" alt="delete" width="24" height="24" />
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <hr class="w-full border border-dark-4/80" />
                <div class="flex flex-col flex-1 w-full small-medium lg:base-regular">
                    <p><?php echo $post['title']; ?></p>
                    <p class="pt-3 small-medium"><?php echo $post["caption"]; ?></p>
                    <ul class="flex gap-1 mt-2">
                        <?php $tags = explode(',',$post["tags"]); ?>
                        <?php foreach($tags as $tag): ?>
                            <li class="text-light-3">#<?php echo $tag; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="w-full">
                    <div class="z-20 flex items-center justify-between">
                        <div class="flex gap-2 mr-5">
                            <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $post["userLiked"] ? 'liked' : 'like'; ?>.svg" alt="like" 
                                class="like-btn cursor-pointer" 
                                data-post-id="<?php echo $post["id"]; ?>" 
                                data-liked="<?php echo $post["userLiked"]; ?>" 
                                width="20" height="20"
                            >
                            <p class="small-medium lg:base-medium" id="like-count-<?php echo $post["id"]; ?>"><?php echo $post["likesCount"]; ?></p>
                        </div>
                        <div class="flex gap-2">
                            <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $post["userSaved"] ? 'saved' : 'save'; ?>.svg" alt="save" 
                                class="save-btn cursor-pointer" 
                                data-post-id="<?php echo $post["id"]; ?>" 
                                data-saved="<?php echo $post["userSaved"]; ?>" 
                                width="20" height="20">
                            <p class="small-medium lg:base-medium" id="save-count-<?php echo $post["id"]; ?>"><?php echo $post["savesCount"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(isset($contentType) && $contentType === 'editPost'): ?>
    <div class="flex flex-1">
    <div class="common-container">
        <div class="w-full max-w-5xl gap-3 flex-start justify-normal">
            <img src="<?php echo Path::base(); ?>/src/assets/icons/add-post.svg" alt="add-post" width="36" height="36" />
            <h2 class="w-full text-left h3-bold md:h2-bold">Edit Post</h2>
        </div>
        <form class="flex flex-col w-full max-w-5xl gap-9" action="<?php echo Path::base(); ?>/edit-post/<?php echo $postdetail['id']; ?>" method="post" enctype="multipart/form-data">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="title">Title</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="title"
                    id="title"
                    aria-describedby="title-description"
                    value="<?php echo $postdetail["title"]; ?>"
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="caption">Caption</label>
                <textarea
                    class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:bg-slate-950 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 shad-textarea custom-scrollbar"
                    name="caption"
                    id="caption"
                    aria-describedby="caption-description"
                ><?php echo $postdetail["caption"]; ?></textarea>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="postimg">Add Photos</label>
                <div role="presentation" tabindex="0" class="flex flex-col cursor-pointer flex-center rounded-xl bg-dark-3">
                    <!-- Hidden File Input -->
                    <input
                        accept="image/*,.png,.jpeg,.jpg,.svg"
                        multiple
                        type="file"
                        name="postimg"
                        id="file-upload"
                        tabindex="-1"
                        class="file-input"
                        style="display:none"
                    />
                    <div class="file_uploader-box" onclick="document.getElementById('file-upload').click()">
                    <img src="<?php echo Path::base() . $postdetail["image_url"]; ?>" 
                    style="width: 100%; max-width: 100%; height: auto; object-fit: contain; overflow: hidden;" 
                    alt="file-upload" />
                        <h3 class="mt-6 mb-2 base-medium text-light-2">IF NOTHING CHANGES, IT STAYS THE SAME</h3>
                        <p class="mb-6 text-light-4 small-regular">SVG, PNG, JPG</p>
                        <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4">
                            Select from computer
                        </a>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="location">Add Location</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="location"
                    id="location"
                    value="<?php echo $postdetail["location"]; ?>"
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="tags">Add Tags (separated by comma ',')</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    placeholder="Nature, Sci-Fi, Love"
                    name="tags"
                    id="tags"
                    value="<?php echo $postdetail["tags"]; ?>"
                />
            </div>
            <div class="flex items-center justify-end gap-4">
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" type="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_primary whitespace-nowrap">
                    Edit Post
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php if(isset($contentType) && $contentType === 'saves'): ?>
<div class="flex flex-1">
    <div class="saved-container">
        <div class="max-w-5xl flex-start gap-3 justify-start w-full mb-7">
            <img src="<?php echo Path::base(); ?>/src/assets/icons/save.svg" alt="add" class="w-8 h-8 md:w-12 md:h-12" />
            <h2 class="body-bold md:h2-bold text-left w-full">Saved Posts</h2>
        </div>
        <ul class="grid-container">
            <?php foreach($savedPosts as $savedPost): ?>
                <li class="relative min-w-80 h-80">
                    <a class="grid-post_link" href="<?php echo Path::base(); ?>/posts/<?php echo $savedPost["id"]; ?>">
                        <img
                            src="<?php echo Path::base() . $savedPost["image_url"]; ?>"
                            alt="post image"
                            class="h-full w-full object-cover"
                        />
                    </a>
                    <div class="grid-post_user">
                        <div class="flex items-center justify-start flex-1 small-medium line-clamp-1">
                            <?php echo $savedPost["title"]; ?>
                        </div>
                        <div class="z-20 flex items-center justify-between small-medium line-clamp-1">
                            Saved <?php echo timeAgo($savedPost["saved_at"]); ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>
<?php if(isset($contentType) && $contentType == 'profile'): ?>
    <div class="profile-container">
    <div class="profile-inner_container">
        <div class="flex xl:flex-row flex-col max-xl:items-center flex-1 gap-7" style="align-items: center;">
            <img src="<?php echo Path::base() . $user["image_pic_url"]; ?>" alt="profile" class="w-28 h-28 lg:h-36 lg:w-36 rounded-full" style="height: 9rem;width: 9rem;">
            <div class="flex flex-col flex-1 justify-between md:mt-2">
                <div class="flex flex-col w-full">
                    <h1 class="text-center xl:text-left h3-bold md:h1-semibold w-full"  style="font-size:36px"><?php echo $user["username"]; ?></h1>
                    <p class="small-regular md:body-medium text-light-3 text-center xl:text-left"  style="font-size:18px">@<?php echo $user["username"]; ?></p>
                </div>
                <div class="flex gap-8 mt-10 items-center justify-center xl:justify-start flex-wrap z-20">
                    <div class="flex-center gap-2">
                        <p class="small-semibold lg:body-bold text-primary-500" style="font-size:20px"><?php echo $postsCount; ?></p>
                        <p class="small-medium lg:base-medium text-light-2">Posts</p>
                    </div>
                    <div class="flex-center gap-2">
                        <p class="small-semibold lg:body-bold text-primary-500" style="font-size:20px" id="followers-count-<?php echo $user['id']; ?>"><?php echo $followStats['followersCount']; ?></p>
                        <p class="small-medium lg:base-medium text-light-2">Followers</p>
                    </div>
                    <div class="flex-center gap-2">
                        <p class="small-semibold lg:body-bold text-primary-500" style="font-size:20px" id="following-count-<?php echo $user['id']; ?>"><?php echo $followStats['followingCount']; ?></p>
                        <p class="small-medium lg:base-medium text-light-2">Following</p>
                    </div>
                </div>
                <p class="small-medium md:base-medium text-center xl:text-left mt-2 max-w-screen-sm">
                    <?php echo $user['bio']; ?>
                </p>
            </div>
            <div class="flex justify-center gap-4">
                <?php if($canEdit === true): ?>
                <a href="<?php echo Path::base() . '/editprofile/' . $user['id']; ?>" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 shad-button_dark_4">
                <img class="" src="<?php echo Path::base(); ?>/src/assets/icons/edit-profile.svg" alt="edit profile" />Edit Profile
                </a>
                <?php endif; ?>
                <?php if($canFollow === true): ?> 
                <div class="">
                    <button id="follow-btn" data-user-id="<?php echo $user["id"]; ?>" class="follow-btn inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 shad-button_dark_4" style="background-color: rgb(135 126 255) !important;!i;!;" type="button"><?php echo ($isFollowing === true) ? 'Unfollow' : 'Follow'; ?></button>
                </div>
                <?php endif; ?>
                <!-- <?php if($canEdit === true): ?>
                <a href="<?php echo Path::base() . '/add-story/' . $user['id']; ?>" class="">
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 shad-button_dark_4" style="background-color: rgb(135 126 255) !important;!i;!;" type="button">Add Story
                    </button>
                </a>
                <?php endif; ?> -->
            </div>
        </div>
    </div>
    
    <ul class="grid-container">
    <?php foreach($posts as $post): ?>
                    <li class="relative min-w-80 h-80">
                        <a class="grid-post_link" href="<?php echo Path::base(); ?>/posts/<?php echo $post["id"]; ?>">
                            <img
                                src="<?php echo Path::base() . $post['image_url']; ?>"
                                alt="image url"
                                class="h-full w-full object-cover"
                            />
                        </a>
                        <div class="grid-post_user">
                            <div class="flex items-center justify-start gap-2 flex-1">
                                <img src="<?php echo Path::base() . $user["image_pic_url"]; ?>" alt="creator" class="h-8 w-8 rounded-full" />
                                <p class="line-clamp-1"><?php echo $user["username"]; ?></p>
                            </div>
                            <div class="flex justify-between items-center z-20">
                                <div class="flex gap-2 mr-5">
                                    <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $post["userLiked"] ? 'liked' : 'like'; ?>.svg" alt="like" 
                                        class="like-btn cursor-pointer" 
                                        data-post-id="<?php echo $post["id"]; ?>" 
                                        data-liked="<?php echo $post["userLiked"]; ?>" 
                                        width="20" height="20"
                                    >
                                    <p class="small-medium lg:base-medium" id="like-count-<?php echo $post["id"]; ?>"><?php echo $post["likesCount"]; ?></p>
                                </div>
                                <div class="flex gap-2">
                                <img src="<?php echo Path::base(); ?>/src/assets/icons/<?php echo $post["userSaved"] ? 'saved' : 'save'; ?>.svg" alt="save" 
                                    class="save-btn cursor-pointer" 
                                    data-post-id="<?php echo $post["id"]; ?>" 
                                    data-saved="<?php echo $post["userSaved"]; ?>" 
                                    width="20" height="20">
                                <p class="small-medium lg:base-medium" id="save-count-<?php echo $post["id"]; ?>"><?php echo $post["savesCount"]; ?></p>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<?php if(isset($contentType) && $contentType == 'editprofile'): ?>
    <div class="flex flex-1">
    <div class="common-container">
        <div class="flex-start gap-3 justify-start w-full max-w-5xl">
            <img src="<?php echo Path::base(); ?>/src/assets/icons/edit.svg" width="36" height="36" alt="edit" class="invert-white" />
            <h2 class="h3-bold md:h2-bold text-left w-full">Edit Profile</h2>
        </div>
        <form class="flex flex-col gap-7 w-full mt-4 max-w-5xl" method="post" enctype="multipart/form-data" action="<?php echo Path::base(); ?>/editprofile/<?php echo $userToBeEdited["id"]; ?>">
            <div class="space-y-2 flex">
                <div role="presentation" tabindex="0">
                    <input accept="image/*,.png,.jpeg,.jpg" id="image_pic" name="postimg" type="file" tabindex="-1" class="cursor-pointer" style="display: none;" />
                    <div class="cursor-pointer flex-center gap-4">
                        <img src="<?php echo Path::base() . $userToBeEdited["image_pic_url"]; ?>" alt="image" class="h-24 w-24 rounded-full object-cover object-top" style="width: 6rem;height: 6rem;" onclick="document.getElementById('image_pic').click()" />
                        <p class="text-primary-500 small-regular md:bbase-semibold" onclick="document.getElementById('image_pic').click()">Change profile photo</p>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for=":r3:-form-item">Name</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="name"
                    id=":r3:-form-item""
                    value="<?php echo $userToBeEdited["name"]; ?>"
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for=":r4:-form-item">Username</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="username"
                    id=":r4:-form-item"
                    value="<?php echo $userToBeEdited["username"]; ?>"
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for=":r5:-form-item">Email</label>
                <input
                    type="text"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="email"
                    disabled=""
                    id=":r5:-form-item"
                    value="<?php echo $userToBeEdited["email"]; ?>"
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for=":r4:-form-item">New Password</label>
                <input
                    type="passowrd"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-input"
                    name="password"
                    id=":r4:-form-item"
                />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for=":r6:-form-item">Bio</label>
                <textarea
                    class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 shad-textarea custom-scrollbar"
                    name="bio"
                    id=":r6:-form-item"
                ><?php echo $userToBeEdited["bio"]; ?></textarea>
            </div>
            <div class="flex gap-4 items-center justify-end">
                <button
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4"
                    type="button"
                >
                    Cancel
                </button>
                <button
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_primary whitespace-nowrap"
                    type="submit"
                >
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<?php endif; ?>
<?php if(isset($contentType) && $contentType == 'people'): ?>
    <div class="common-container">
    <div class="max-w-5xl flex-start gap-3 justify-start w-full">
        <img src="<?php echo Path::base(); ?>/src/assets/icons/people.svg" alt="All users" class="w-8 h-8 md:w-12 md:h-12" />
        <h2 class="h3-bold md:h2-bold text-left w-full">All Users</h2>
    </div>
    <div class="flex flex-wrap gap-9 w-full max-w-5xl">
        <div class="grid-container">
            <?php foreach($users as $user): ?>
                <div class="user-card">
                    <a href="<?php echo Path::base() . '/profile/' . $user['id']; ?>">
                        <img
                            class="w-20 h-20 rounded-full"
                            src="<?php echo  Path::base() . $user['image_pic_url'] ?>"
                            alt="User Profile"
                            style="width: 10rem;height: 10rem;"
                        />
                        <h3 style="text-align: center;font-size:19px;margin-top:12px"><?php echo $user['username']; ?></h3>
                    </a>
                    <div class="flex gap-8 items-center justify-center xl:justify-start flex-wrap z-20">
                    <div class="flex-center gap-2">
                            <p class="small-semibold lg:body-bold text-primary-500" style="font-size:20px" id="followers-count-<?php echo $user['id']; ?>"><?php echo $user['followersCount']; ?></p>
                            <p class="small-medium lg:base-medium text-light-2">Followers</p>
                        </div>
                        <div class="flex-center gap-2">
                            <p class="small-semibold lg:body-bold text-primary-500" style="font-size:20px" id="following-count-<?php echo $user['id']; ?>"><?php echo $user['followingCount']; ?></p>
                            <p class="small-medium lg:base-medium text-light-2">Following</p>
                    </div>
                    </div>
                    <button id="follow-btn" data-user-id="<?php echo $user["id"]; ?>" class="follow-btn inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 shad-button_dark_4" style="background-color: rgb(135 126 255) !important;!i;!;" type="button"><?php echo ($user["isFollowing"] == 1) ? 'Unfollow' : 'Follow'; ?></button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="w-full max-w-5xl">
        <div class="flex justify-center">
            <button
                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4"
            >
                Load More
            </button>
        </div>
    </div>
</div>

<?php endif; ?>
<?php if (isset($contentType) && $contentType == 'add-story'): ?>
<div class="flex flex-1">
    <div class="common-container">
        <div class="w-full max-w-5xl gap-3 flex-start justify-normal">
            <img src="<?php echo Path::base(); ?>/src/assets/icons/add-post.svg" alt="add-story" width="36" height="36" />
            <h2 class="w-full text-left h3-bold md:h2-bold">Add Story</h2>
        </div>
        <form class="flex flex-col w-full max-w-5xl gap-9" action="<?php echo Path::base(); ?>/add-story/<?php echo $userinfo['id']; ?>" method="post" enctype="multipart/form-data">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="caption">Caption</label>
                <textarea
                    class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:bg-slate-950 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 shad-textarea custom-scrollbar"
                    name="caption"
                    id="caption"
                    aria-describedby="caption-description"
                ></textarea>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 shad-form_label" for="postimg">Add Photos</label>
                <div role="presentation" tabindex="0" class="flex flex-col cursor-pointer flex-center rounded-xl bg-dark-3">
                    <!-- Hidden File Input -->
                    <input
                        accept="image/*,.png,.jpeg,.jpg,.svg"
                        multiple
                        type="file"
                        name="postimg"
                        id="file-upload"
                        tabindex="-1"
                        class="file-input"
                        style="display:none"
                        required
                    />
                    <div class="file_uploader-box" onclick="document.getElementById('file-upload').click()">
                        <img src="<?php echo Path::base(); ?>/src/assets/icons/file-upload.svg" width="96" height="77" alt="file-upload" />
                        <h3 class="mt-6 mb-2 base-medium text-light-2">Drag Photo here</h3>
                        <p class="mb-6 text-light-4 small-regular">SVG, PNG, JPG</p>
                        <a class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4">
                            Select from computer
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-4">
                <button type="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_dark_4">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shad-button_primary whitespace-nowrap">
                    Add to Story
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>