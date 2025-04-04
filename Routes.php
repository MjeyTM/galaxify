<?php
require_once './models/Router.php';

// Initialize the router
$router = new Router('/galaxify');

// index
$router->addRoute('GET', '/', 'HomeController@index'); 

////// menu routes
// explore
$router->addRoute('GET', '/explore', 'PostController@explore'); 
$router->addRoute('POST', '/explore', 'PostController@explore'); 
// people
$router->addRoute('GET', '/people/{id}', 'ProfileController@people'); 
// saved

//////Authentication routes
//signup routes
$router->addRoute('GET','/signup','AuthController@showSignup');
$router->addRoute('POST','/signup','AuthController@signup');
//login routes
$router->addRoute('GET','/login','AuthController@showLogin');
$router->addRoute('POST','/login','AuthController@login');
// logout
$router->addRoute('POST','/logout','AuthController@logout');

////// post routes
//post details
$router->addRoute('GET', '/posts/{id}', 'PostController@showPostDetails');
//like post
$router->addRoute('POST','/likepost/{id}','PostController@likePost');
//unlike post
$router->addRoute('POST','/unlikepost/{id}','PostController@unlikepost');
//save post
$router->addRoute('POST','/savepost/{id}','PostController@savePost');
//unsave post
$router->addRoute('POST','/unsavepost/{id}','PostController@deleteSavedPost');
// create post
$router->addRoute('GET', '/create-post', 'PostController@createForm'); 
$router->addRoute('POST', '/create-post', 'PostController@createPost'); 
// edit post
$router->addRoute('GET', '/edit-post/{id}', 'PostController@editPostForm');
$router->addRoute('POST', '/edit-post/{id}', 'PostController@editPost');
// delete post
$router->addRoute('POST', '/delete-post/{id}', 'PostController@deletePost');
$router->addRoute('POST', '/admin-delete-post/{id}', 'AdminController@adminDeletePost');
// saved post
$router->addRoute('GET', '/saved', 'PostController@getSavedPosts');
// add story
$router->addRoute('GET', '/add-story/{id}', 'PostController@createStoryForm');
$router->addRoute('POST', '/add-story/{id}', 'PostController@addStory');
////// profile
$router->addRoute('GET', '/profile/{id}', 'ProfileController@index');
$router->addRoute('POST', '/followAction/{id}', 'ProfileController@followAction');
$router->addRoute('GET', '/editprofile/{id}', 'ProfileController@editprofileForm');
$router->addRoute('POST', '/editprofile/{id}', 'ProfileController@editprofile');
//admin routes
$router->addRoute('GET', '/admin', 'AdminController@index');
$router->addRoute('GET', '/admin/users', 'AdminController@manageUsers');
$router->addRoute('POST', '/admin/deleteuser/{id}', 'AdminController@deleteUser');
$router->addRoute('GET', '/admin/create-user', 'AdminController@createUserAdvancedForm');
$router->addRoute('POST', '/admin/create-user', 'AdminController@createUserAdvanced');
$router->addRoute('GET', '/admin/posts', 'AdminController@managePosts');
// Return the router instance
return $router;