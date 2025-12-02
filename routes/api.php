<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\TravelRouteController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FinancialClosureController;
use App\Http\Controllers\VolunteerHourController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AttachmentController;

Route::prefix('v1')->group(function () {
    Route::get('/', function () { return response()->json(['status' => 'ok']); });

    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::middleware([\App\Http\Middleware\TokenAuth::class, \App\Http\Middleware\RoleAccess::class, \App\Http\Middleware\AuditLogger::class])->group(function () {
        Route::apiResource('donors', DonorController::class);
        Route::apiResource('donations', DonationController::class);
        Route::apiResource('beneficiaries', BeneficiaryController::class);
        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('campaigns', CampaignController::class);
        Route::apiResource('warehouses', WarehouseController::class);
        Route::apiResource('items', ItemController::class);
        Route::apiResource('inventory-transactions', InventoryTransactionController::class);
        Route::apiResource('tasks', TaskController::class);
        Route::apiResource('accounts', AccountController::class);
        Route::apiResource('journal-entries', JournalEntryController::class);
        Route::apiResource('complaints', ComplaintController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('delegates', DelegateController::class);
        Route::apiResource('travel-routes', TravelRouteController::class);
        Route::apiResource('expenses', ExpenseController::class);
        Route::apiResource('volunteer-hours', VolunteerHourController::class);
        Route::apiResource('payrolls', PayrollController::class);
        Route::get('finance/closures', [FinancialClosureController::class, 'index']);
        Route::post('finance/close', [FinancialClosureController::class, 'store']);
        Route::post('finance/closures/{closure}/approve', [FinancialClosureController::class, 'approve']);

        Route::post('users/{user}/roles/{role}', [UserController::class, 'attachRole'])->name('users.attachRole');
        Route::delete('users/{user}/roles/{role}', [UserController::class, 'detachRole'])->name('users.detachRole');

        Route::get('reports/donors', [\App\Http\Controllers\ReportsController::class, 'donors'])->name('reports.donors');
        Route::get('reports/donations', [\App\Http\Controllers\ReportsController::class, 'donations'])->name('reports.donations');
        Route::get('reports/inventory', [\App\Http\Controllers\ReportsController::class, 'inventory'])->name('reports.inventory');
        Route::get('reports/beneficiaries', [\App\Http\Controllers\ReportsController::class, 'beneficiaries'])->name('reports.beneficiaries');
        Route::get('reports/finance', [\App\Http\Controllers\ReportsController::class, 'finance'])->name('reports.finance');
        Route::post('attachments', [AttachmentController::class, 'store']);
        Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy']);
    });
});
