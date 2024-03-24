<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\LanguageController;
use App\Http\Controllers\API\V1\SettingsController;
use App\Http\Controllers\API\V1\Rbac\RoleController;

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\GetCountryController;
use App\Http\Controllers\API\V1\Auth\LogOutController;
use App\Http\Controllers\API\V1\GetPermissionController;
use App\Http\Controllers\API\V1\Profile\ProfileController;
use App\Http\Controllers\API\V1\Rbac\PermissionController;
use App\Http\Controllers\API\V1\Rbac\UserAccessController;
use App\Http\Controllers\API\V1\UpzilaWiseUnionController;
use App\Http\Controllers\API\V1\Auth\RegistrationController;
use App\Http\Controllers\API\V1\DistrictWiseUpzilaController;
use App\Http\Controllers\API\V1\CountryWiseDivisionController;
use App\Http\Controllers\API\V1\Rbac\RolePermissionController;
use App\Http\Controllers\API\V1\DivisionWiseDistrictController;
use App\Http\Controllers\API\V1\Rbac\AssignRolePermissionController;
use App\Http\Controllers\API\V1\SaleController;

Route::middleware(['throttle:200,1'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::post('register', RegistrationController::class)->name('register');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        Route::post('forgot-password', [LoginController::class, 'forgotPassword'])->name('forgotPassword');
        Route::post('reset-password', [LoginController::class, 'resetPassword'])->name('resetPassword');
        Route::get('setting/general-info', [SettingsController::class, 'generalinfo']);
        Route::middleware('auth:sanctum')->group(function () {

            Route::post('logout', LogOutController::class)
                ->middleware('auth:sanctum')
                ->name('logout');
            Route::patch('/profile/update', [ProfileController::class, 'updateInfo'])->name('profile.update');
            Route::patch('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::get('/activity-logs', [ProfileController::class, 'loginfo'])->name('user.logs');

            Route::get('get-permissions', GetPermissionController::class)->name('get_permissions');

            // RBAC
            // Permission
            Route::get('permission/trash', [PermissionController::class, 'trash'])->name('permission_trash');
            Route::get('permission/restore/{id}', [PermissionController::class, 'restore'])->name('permission_restore');
            Route::delete('permission/forceDelete/{id}', [PermissionController::class, 'forceDelete'])->name('permission_forceDelete');

            Route::group(['prefix' => 'rbac'], function () {
                Route::resource('roles', RoleController::class);
                Route::get('roles/{role}/permissions', RolePermissionController::class);
                Route::post('assign-role-permission', [AssignRolePermissionController::class, 'singlePermission']);
                Route::post('assign-role-permissions', [AssignRolePermissionController::class, 'assignMultipleRolePermissions']);
                Route::resource('permissions', PermissionController::class);
                Route::resource('user-access', UserAccessController::class);
                Route::get('/get-roles', [RoleController::class, 'get_roles'])->name('role.list');
            });
            Route::resource('user', UserController::class);
            Route::get('country', GetCountryController::class)->name('country');
            Route::get('country-wise-division/{countries}', CountryWiseDivisionController::class)->name('country-wise-division');
            Route::get('division-wise-district/{division}', DivisionWiseDistrictController::class)->name('division-wise-district');
            Route::get('district-wise-upzila/{district}', DistrictWiseUpzilaController::class)->name('district-wise-upzila');
            Route::get('upzila-wise-union/{upzila}', UpzilaWiseUnionController::class)->name('upzila-wise-union');
            Route::apiResource('product',ProductController::class);
            Route::apiResource('sale',SaleController::class);
            Route::group(['prefix' => 'setting'], function () {
                //utility setup
                Route::get('language/all-codes', [LanguageController::class, 'allCodes']);
                Route::put('language/update-status', [LanguageController::class, 'updateStatus']);
                Route::get('language/translate/{code}', [LanguageController::class, 'getTranslate']);
                Route::put('language/translate-submit/{code}', [LanguageController::class, 'translateSubmit']);
                Route::resource('language', LanguageController::class);

                //mail setup
                Route::get('smtp', [SettingsController::class, 'smtp']);
                Route::put('smtp', [SettingsController::class, 'smtpUpdate']);
                Route::put('general-info', [SettingsController::class, 'generalinfoUpdate']);
                Route::get('sms', [SettingsController::class, 'smsinfo']);
                Route::put('sms', [SettingsController::class, 'smsinfoUpdate']);
            });

        });
    });
});
