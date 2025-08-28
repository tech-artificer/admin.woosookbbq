<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
// use App\Helpers\AppEnvironment;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Admin\{
    DashboardController,
    // OrderController,
    // MenuController,
    UserController,
    // TableController,
    // Device\DeviceController,
    // TerminalSessionController,
    AccessibilityController,
    RoleController,
    BranchController
};

use App\Http\Controllers\Admin\Reports\{
    SalesController,
};

  
Route::get('/', function () {
    redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
   
    Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');

    // Route to show the permissions management page
    Route::get('/accessibility', [AccessibilityController::class, 'index'])->name('accessibility.index');
    Route::get('/accessibility/{role}/permissions', [AccessibilityController::class, 'updatePermissions'])->name('accessibility.update');
    
    // Route to handle updating a role's permissions
    // Route::post('/roles/{role}/permissions', [AccessibilityController::class, 'updatePermissions'])->name('roles.permissions.update');

    Route::prefix('reports')->group(function () {
        Route::get('/sales', [SalesController::class, 'index'])->name('reports.sales'); 
        // Route::get('{type}', [ReportController::class, 'index'])->name('reports.index'); 
        // Route::get('{type}/export', [ReportController::class, 'export']); // CSV export
    });

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
