<!-- master_layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galaxify</title>
    <link rel="stylesheet" href="<?php echo Path::base(); ?>/src/css/output.css">
    <link rel="icon" type="image/x-icon" href="<?php echo Path::base(); ?>/src/assets/icons/favicon.ico">
    <link rel="stylesheet" href="<?php echo Path::base(); ?>/src/css/sweetalert2.min.css">
    <?php
    $firstLogin = isset($_SESSION['firstLogin']) && $_SESSION['firstLogin'] === true;
    $_SESSION['firstLogin'] = false; // Reset after first check
    ?>
    <style>
    .ring-story {
        position: relative;
        padding: 10px; /* Adjust padding for content */
        border-radius: 99999px; /* Rounded corners */
        text-align: center;
        font-size: 12px;
        font-weight: bolder;
    }
    .ring-story::before {
        content: "";
        position: absolute;
        inset: 0;
        padding: 6px; /* Thicker border */
        border-radius: inherit;
        background: linear-gradient(45deg,#f9ce34, #ee2a7b, #6228d7);
        -webkit-mask: 
            linear-gradient(#fff 0 0) content-box, 
            linear-gradient(#fff 0 0);
        mask: 
            linear-gradient(#fff 0 0) content-box, 
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: destination-out;
        mask-composite: exclude;
    }
    /* Global Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body, html {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    /* Modal Styles */
    #story-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.5s ease, visibility 0.5s ease;
        z-index: 9999;
    }

    #story-modal.show {
        opacity: 1;
        visibility: visible;
    }

    /* Content inside the modal */
    .modal-content {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Image Styling */
    #story-image {
        max-width: 100%;
        max-height: 90%;  /* Adjusted for smaller screens */
        object-fit: contain;
    }

    /* Caption Styling */
    .caption {
        position: absolute;
        bottom: 5%;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        font-size: 18px;
        text-align: center;
        padding: 10px 20px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        width: 80%;
        max-width: 90%;
    }

    /* Close Button */
    .close-button {
        position: absolute;
        top: 5%;
        right: 5%;
        background: transparent;
        color: white;
        font-size: 30px;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .close-button:hover {
        transform: scale(1.2);
    }

    /* Hide Modal */
    .hidden {
        display: none;
    }

    /* Responsive Design: For mobile devices */
    @media (max-width: 600px) {
        /* Adjust Image and Caption for Mobile */
        .caption {
            font-size: 16px;
            width: 90%;
            bottom: 10%;
        }

        #story-image {
            max-width: 100%;
            max-height: 80%;
        }

        .close-button {
            font-size: 25px;
        }
    }
    </style>
</head>
<body>
    <div id="root">
        <main class="flex h-screen">
            <div class="w-full md:flex">
                <section class="topbar">
                    <!-- topbar content here -->
                     <?php include './views/layout/topbar.php'; ?>
                </section>
                <nav class="leftsidebar">
                    <!-- sidebar content here -->
                    <?php include './views/layout/leftsidebar.php'; ?>
                </nav>
                <section class="flex flex-1 h-full">
                    <!-- Main content placeholder -->
                    <?php include './views/layout/content.php'; ?>
                </section>
                <section class="bottom-bar">
                    <!-- bottom bar content here -->
                    <?php include './views/layout/bottombar.php'; ?>
                </section>
            </div>
        </main>
    </div>
    <div id="story-modal" class="modal hidden">
        <div class="modal-content">
            <img id="story-image" src="" alt="profile">

            <!-- Caption -->
            <div id="story-caption" class="caption">
            </div>

            <!-- Close Button -->
            <button id="close-modal" class="close-button">&times;</button>
        </div>
    </div>  
    <script src="<?php echo Path::base(); ?>/src/js/sweetalert2@11.js"></script>
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
                    color: '#f44336',
                    background: '#222',
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
                    color: '#fff',
                    background: '#222',
                    backdrop: 'rgba(0,0,123,0.4)'
                });
            </script>
            ";
        ?>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <script>
        window.onload = () => {
            const firstLogin = <?php echo json_encode($firstLogin); ?>;

            if (firstLogin) {
                Swal.fire({
                title: "Welcome Back.",
                width: 600,
                padding: "3em",
                color: "#fff",
                background: "rgb(33 34 40)",
                backdrop: `
                    rgba(0,0,123,0.4)
                    url("src/assets/images/nyan-cat.gif")
                    left bottom
                    no-repeat
                `
                });
            }

            const btnDelete = document.getElementById("deleteBtn");
            if(btnDelete){
                btnDelete.addEventListener("click", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        background: "rgb(33 34 40)",
                        color: "#fff",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("deleteForm").submit();
                        }
                    });
                });
            }
        };
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            const basepath = '<?php echo Path::base(); ?>';

            const likeButtons = document.querySelectorAll(".like-btn");
            const saveButtons = document.querySelectorAll(".save-btn");

            setLikeButton()
            setSaveButton()

            // Get the profile link (story trigger element) and modal elements
            const profileLinks = document.querySelectorAll("[id^=profile-link-]");
            const storyModal = document.getElementById('story-modal');
            const closeModal = document.getElementById('close-modal');
            const storyImage = document.getElementById('story-image');
            const storyCaption = document.getElementById('story-caption');

            // Open Modal and Display Correct Story when profile link is clicked
            profileLinks.forEach((profilelink) => {

                profilelink.addEventListener('click', () => {
                    let index = profilelink.id.split('-')[1];

                    // Get data from the profile link (story data)
                    const image = profilelink.getAttribute('data-image');
                    const caption = profilelink.getAttribute('data-caption');
                    
                    // Update the modal content
                    storyImage.src = image;
                    storyCaption.textContent = caption;
                    
                    // Show the modal
                    storyModal.classList.add('show');
                });

                // Close Modal
                closeModal.addEventListener('click', function () {
                    storyModal.classList.remove('show');
                    storyImage.src = '';
                });

                storyModal.addEventListener('click', function (e) {
                    if (e.target === storyModal) {
                        storyModal.classList.remove('show');
                        storyImage.src = '';
                    }
                });
            })
            
            const followButtons = document.querySelectorAll(".follow-btn");

            if (followButtons.length > 0) {
                followButtons.forEach((btn) => btn.addEventListener("click", followAction));
            }

            function followAction(event) {
                const followBtn = event.currentTarget;
                const userId = followBtn.dataset.userId;
                const actionUrl = `${basepath}/followAction/${userId}`;
                const followerCount = document.getElementById(`followers-count-${userId}`);
                const followingCount = document.getElementById(`following-count-${userId}`);
                const currentStatus = followBtn.innerText;

                if (currentStatus === "Unfollow") {
                    Swal.fire({
                        title: "Are you sure to Unfollow this user?",
                        icon: "warning",
                        showCancelButton: true,
                        width: 600,
                        background: "rgb(33 34 40)",
                        color: "#fff",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, Unfollow!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            executeFollowAction(followBtn, actionUrl, followerCount, followingCount);
                        }
                    });
                } else {
                    executeFollowAction(followBtn, actionUrl, followerCount, followingCount);
                }
            }

            function executeFollowAction(followBtn, actionUrl, followerCount, followingCount) {
                fetch(actionUrl, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            const { followersCount, followingCount: newFollowingCount } = data.stats;
                            followerCount.innerText = followersCount;
                            followingCount.innerText = newFollowingCount;
                            console.log(followBtn)
                            followBtn.innerText = data.message === "Followed" ? "Unfollow" : "Follow";
                            Swal.fire({
                                title: data.message === "Unfollowed" ? "User Unfollowed successfully." : "You Followed this user.",
                                icon: "success",
                                width: 600,
                                background: "rgb(33 34 40)",
                                color: "#fff",
                                backdrop: data.message === "Followed" 
                                    ? `rgba(0,0,123,0.4) url("../src/assets/images/nyan-cat.gif") left bottom no-repeat`
                                    : undefined,
                            });
                        } else {
                            console.error("Error: " + data.message);
                        }
                    });
            }

            function setLikeButton() {
                const likeButtons = document.querySelectorAll(".like-btn");
                likeButtons.forEach(btn => {
                    btn.addEventListener("click", function () {
                        const postId = this.getAttribute("data-post-id");
                        const isLiked = this.getAttribute("data-liked") === "1";
                        const actionUrl = isLiked ? basepath + '/unlikepost/' : basepath + '/likepost/';

                        fetch(`${actionUrl}${postId}`, {
                            method: "POST",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest",
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.setAttribute("data-liked", data.userLiked ? "1" : "0");
                                this.src = data.userLiked ? basepath + '/src/assets/icons/liked.svg' : basepath + '/src/assets/icons/like.svg';
                                document.querySelector(`#like-count-${postId}`).innerText = data.likesCount;
                            } else {
                                console.error("Error: " + data.message);
                            }
                        });
                    });
                });
            }

            function setSaveButton() {
                const saveButtons = document.querySelectorAll(".save-btn");
                saveButtons.forEach(btn => {
                    btn.addEventListener("click", function () {
                        const postId = this.getAttribute("data-post-id");
                        const isSaved = this.getAttribute("data-saved") === "1";
                        const actionUrl = isSaved ? basepath + '/unsavepost/' : basepath + '/savepost/';

                        fetch(`${actionUrl}${postId}`, {
                            method: "POST",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest",
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.setAttribute("data-saved", data.userSaved ? "1" : "0");
                                this.src = data.userSaved ? basepath + '/src/assets/icons/saved.svg' : basepath + '/src/assets/icons/save.svg';
                                document.querySelector(`#save-count-${postId}`).innerText = data.savesCount;
                            } else {
                                console.error("Error: " + data.message);
                            }
                        });
                    });
                });
            }
            
            function fetchPosts(searchTerm = '', filter = '') {
                fetch(basepath + '/explore', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `search=${encodeURIComponent(searchTerm)}&filter=${filter}`
                })
                .then(response => response.json())
                .then(posts => updateGrid(posts))
                .catch(error => console.error('Error fetching posts:', error));
            }

            function updateGrid(posts) {
                const gridContainer = document.getElementById("grid-container");
                gridContainer.innerHTML = ''; // Clear old content

                posts.forEach(post => {
                    const postHTML = `
                        <li class="relative min-w-80 h-80">
                            <a class="grid-post_link" href="${basepath}/posts/${post.id}">
                                <img src="${post.image_url ? basepath + '/' + post.image_url : basepath + '/src/assets/images/profiles/placeholder.png'}" alt="post" class="object-cover w-full h-full">
                            </a>
                            <div class="grid-post_user">
                                <div class="flex items-center justify-start flex-1 gap-2">
                                    <img src="${post.image_pic_url ? basepath + '/' + post.image_pic_url : basepath + '/src/assets/images/profiles/placeholder.png'}" alt="creator" class="w-8 h-8 rounded-full">
                                    <p class="line-clamp-1">${post.username}</p>
                                </div>
                                <div class="z-20 flex items-center justify-between">
                                    <div class="flex gap-2 mr-5">
                                        <img src="${basepath}/src/assets/icons/${post.userLiked ? 'liked' : 'like'}.svg" alt="like" 
                                            class="like-btn cursor-pointer"
                                            data-post-id="${post.id}" 
                                            data-liked="${post.userLiked ? "1" : "0"}" 
                                            width="20" height="20">
                                        <p class="small-medium lg:base-medium" id="like-count-${post.id}">${post.likesCount}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <img src="${basepath}/src/assets/icons/${post.userSaved ? 'saved' : 'save'}.svg" alt="save" 
                                            class="save-btn cursor-pointer" 
                                            data-post-id="${post.id}" 
                                            data-saved="${post.userSaved ? "1" : "0"}" 
                                            width="20" height="20">
                                        <p class="small-medium lg:base-medium" id="save-count-${post.id}">${post.savesCount}</p>
                                    </div>
                                </div>
                            </div>
                        </li>`;
                    gridContainer.insertAdjacentHTML('beforeend', postHTML);
                });

                // Rebind the like and save buttons
                setLikeButton();
                setSaveButton();
            }
            
            const search = document.getElementById("search-input");
            if(search){
                search.addEventListener("input", debounce(() => {
                    const searchTerm = document.getElementById("search-input").value;
                    const filter = document.getElementById("filter-label").value;
                    fetchPosts(searchTerm, filter);
                    setLikeButton()
                    setSaveButton()
                }, 500));
            }
        
            // Debounce Function to Reduce Calls
            function debounce(func, delay) {
                let timer;
                return function (...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            document.getElementById("filter-btn").addEventListener("click", () => {
                const menu = document.getElementById("filter-menu");
                menu.classList.toggle("hidden");
            });

            // Apply filter on selection
            document.querySelectorAll(".filter-option").forEach(option => {
                option.addEventListener("click", () => {
                    const filterValue = option.dataset.filter;
                    const filterLabel = option.textContent;

                    // Update label
                    document.getElementById("filter-label").textContent = filterLabel;

                    // Close dropdown
                    document.getElementById("filter-menu").classList.add("hidden");

                    // Fetch updated posts using AJAX
                    fetchPosts(document.getElementById("search-input").value, filterValue);
                    setLikeButton()
                    setSaveButton()
                });
            });

            // Close dropdown if clicking outside
            document.addEventListener("click", (event) => {
                if (!document.getElementById("filter-btn").contains(event.target) &&
                    !document.getElementById("filter-menu").contains(event.target)) {
                    document.getElementById("filter-menu").classList.add("hidden");
                }
            });

            

        });
    </script>
</body>
</html>
