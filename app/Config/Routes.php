<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//auth user
$routes->group('api', ["filter" => ["cors", "auth"]], function ($routes) {
	//user
	$routes->get('users', 'Api\ApiUser::index');
	$routes->get('users/(:num)', 'Api\ApiUser::show/$1');
	$routes->patch('users/(:num)', 'Api\ApiUser::update/$1');
	$routes->delete('users/(:num)', 'Api\ApiUser::delete/$1');
	$routes->get('users/page', 'Api\ApiUser::page');
	//company
	$routes->get('company', 'Api\ApiCompany::index');
	$routes->post('company', 'Api\ApiCompany::create');
	$routes->get('company/(:num)', 'Api\ApiCompany::show/$1');
	$routes->patch('company/(:num)', 'Api\ApiCompany::update/$1');
	$routes->delete('company/(:num)', 'Api\ApiCompany::delete/$1');
	$routes->get('company/page', 'Api\ApiCompany::page');
	//admin image
	$routes->put("users/updateimageuser/(:num)", "Api\ResourceFile::updateImageUser/$1");

	//job
	$routes->patch('job/(:num)', 'Api\ApiJob::update/$1');
	$routes->delete('job/(:num)', 'Api\ApiJob::delete/$1');
	$routes->post('job', 'Api\ApiJob::create');
	//apply
	$routes->get('apply', 'Api\ApiApplyJob::index');
	$routes->post('apply', 'Api\ApiApplyJob::create');
	$routes->get('apply/(:num)', 'Api\ApiApplyJob::show/$1');
	$routes->patch('apply/(:num)', 'Api\ApiApplyJob::update/$1');
	$routes->delete('apply/(:num)', 'Api\ApiApplyJob::delete/$1');
	$routes->get('apply/page', 'Api\ApiApplyJob::page');
});
//auth admin
$routes->group('api', ["filter" => ["cors", "authadmin"]], function ($routes) {
	//admin
	$routes->get('admin', 'Api\ApiAdmin::index');
	$routes->post('admin', 'Api\ApiAdmin::create');
	$routes->get('admin/(:num)', 'Api\ApiAdmin::show/$1');
	$routes->patch('admin/(:num)', 'Api\ApiAdmin::update/$1');
	$routes->delete('admin/(:num)', 'Api\ApiAdmin::delete/$1');
	$routes->get('admin/page', 'Api\ApiAdmin::page');
	//admin image
	$routes->put("admin/updateimageadmin/(:num)", "Api\ResourceFile::updateImageAdmin/$1");
	//api category
	$routes->get('category', 'Api\ApiCategory::index');
	$routes->post('category', 'Api\ApiCategory::create');
	$routes->get('category/(:num)', 'Api\ApiCategory::show/$1');
	$routes->patch('category/(:num)', 'Api\ApiCategory::update/$1');
	$routes->delete('category/(:num)', 'Api\ApiCategory::delete/$1');
});

// tanpa validasi auth user dan admin
$routes->group('api', ["filter" => ["cors"]], function ($routes) {
	// reg
	$routes->post('users', 'Api\ApiUser::create');
	//login
	$routes->post('users/token', 'Api\AuthController::login');
	$routes->post('admin/token', 'Api\AuthControllerAdmin::login');

	//api job
	$routes->get('job', 'Api\ApiJob::index');
	$routes->get('job/(:num)', 'Api\ApiJob::show/$1');

});