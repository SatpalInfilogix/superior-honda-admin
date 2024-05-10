<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleBrandController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VehicleModelVariantController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::resources([
        'dashboard'             => DashboardController::class,
        'profile'               => ProfileController::class,
        'vehicle-categories'    => VehicleCategoryController::class,
        'vehicle-types'         => VehicleTypeController::class,
        'vehicle-brands'        => VehicleBrandController::class,
        'vehicle-models'        => VehicleModelController::class,
        'vehicle-model-variants'=> VehicleModelVariantController::class,
        'branches'              => BranchController::class,
        'users'                 => UserController::class,
        'customers'             => CustomerController::class,
        'roles'                 => RoleController::class,
        'roles-and-permissions' => RoleAndPermissionController::class,
        'products'              => ProductController::class
    ]);
});

Route::get('/', function (){
    return redirect()->route('dashboard.index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/* Routes for Ajax calls */
Route::post('get-vehicle-brand', [ VehicleModelController::class, 'getVehicleBrand']);  // get vechicle brands according to category
Route::post('get-vehicle-model', [ VehicleModelVariantController::class, 'getVehicleModel']); // get vechicle models according to category

Route::post('users/import', [UserController::class, 'import'])->name('users.import');  // import users csv file
Route::post('products/import', [ProductController::class, 'import'])->name('products.import');  // import products csv file