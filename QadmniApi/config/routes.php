<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    //$routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    $routes->connect('itemlist', ['controller' => 'ItemMaster', 'action' => 'getList']);
    $routes->connect('categorylist', ['controller' => 'ItemCategory', 'action' => 'getList']);
    $routes->connect('vendorsignup', ['controller' => 'Producer', 'action' => 'signUp']);
    $routes->connect('vendorlogin', ['controller' => 'Producer', 'action' => 'login']);
    $routes->connect('vendoritems', ['controller' => 'ItemMaster', 'action' => 'getVendorItemList']);
    $routes->connect('registercustomer', ['controller' => 'Customer', 'action' => 'register']);
    $routes->connect('customerlogin', ['controller' => 'Customer', 'action' => 'login']);
    $routes->connect('addproduct', ['controller' => 'ItemMaster', 'action' => 'addProduct']);
    $routes->connect('addproductimage', ['controller' => 'ItemMaster', 'action' => 'addUpdateProductImage']);
    $routes->connect('initiateorder', ['controller' => 'Order', 'action' => 'initiateOrder']);
    $routes->connect('processorder', ['controller' => 'Order', 'action' => 'processOrder']);
    $routes->connect('confirmorder', ['controller' => 'Order', 'action' => 'confirmOrder']);
    $routes->connect('liveorderlist', ['controller' => 'OrderHeader', 'action' => 'getLiveOrderList']);
    $routes->connect('pastorderlist', ['controller' => 'OrderHeader', 'action' => 'getPastOrderList']);
    $routes->connect('vendororders', ['controller' => 'OrderHeader', 'action' => 'getVendorOrders']);
    $routes->connect('customerforgotpassword', ['controller' => 'Customer', 'action' => 'forgotPassword']);
    $routes->connect('vendorforgotpassword', ['controller' => 'Producer', 'action' => 'forgotPassword']);
    $routes->connect('isduplicateemail', ['controller' => 'Producer', 'action' => 'checkEmailExists']);
    $routes->connect('updatedeliverystatus', ['controller' => 'OrderHeader', 'action' => 'updateDeliveryStatus']);
    $routes->connect('updateproduct', ['controller' => 'ItemMaster', 'action' => 'updateProduct']);
    $routes->connect('addremovefavorite', ['controller' => 'CustomerFavorites', 'action' => 'addRemoveFavorites']);
    $routes->connect('myfavorites', ['controller' => 'ItemMaster', 'action' => 'customerFavorites']);
    $routes->connect('itemdetails', ['controller' => 'ItemMaster', 'action' => 'getItemDetails']);
    $routes->connect('reviewitems', ['controller' => 'OrderDtl', 'action' => 'getOrderItemDetails']);
    $routes->connect('submitfeedback', ['controller' => 'CustomerFeedbacks', 'action' => 'submitFeedback']);
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
