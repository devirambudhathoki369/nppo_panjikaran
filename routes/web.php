<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommonNameController;
use App\Http\Controllers\FormulationController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\BishadiTypeController;
use App\Http\Controllers\DataEntry\ChecklistController;
use App\Http\Controllers\DataEntry\ChecklistPointController;
use App\Http\Controllers\DataEntry\UsageController;
use App\Http\Controllers\DataEntry\ChecklistDetailController;
use App\Http\Controllers\DataEntry\CropController;
use App\Http\Controllers\DataEntry\PestController;
use App\Http\Controllers\DataEntry\PackageDestroyController;

use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\PanjikaranController;
use App\Http\Controllers\BargikaranController;
use App\Http\Controllers\RecommendedCropController;

use App\Http\Controllers\DatabaseBackupController;

use App\Http\Controllers\RecommendedPestController;




use Illuminate\Support\Facades\DB;

// Redirect root to login
Route::redirect('/', '/auth/login');

// Authentication routes with /auth prefix
Route::prefix('auth')->group(function () {
    Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/custom/login', [CustomLoginController::class, 'login'])->name('custom.login');
    Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');

    // Password reset routes (optional)
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('checklist-points', [ChecklistPointController::class, 'index'])->name('checklist-points.index');
    Route::get('checklist-points/create', [ChecklistPointController::class, 'create'])->name('checklist-points.create');
    Route::post('checklist-points', [ChecklistPointController::class, 'store'])->name('checklist-points.store');
    Route::get('checklist-points/{checklist_point}/edit', [ChecklistPointController::class, 'edit'])->name('checklist-points.edit');
    Route::put('checklist-points/{checklist_point}', [ChecklistPointController::class, 'update'])->name('checklist-points.update');
    Route::delete('checklist-points/{checklist_point}', [ChecklistPointController::class, 'destroy'])->name('checklist-points.destroy');

    // country entry
    Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');
        Route::post('/', [CountryController::class, 'store'])->name('store');
        Route::get('/edit/{country}', [CountryController::class, 'edit'])->name('edit');
        Route::put('/edit/{country}', [CountryController::class, 'update'])->name('update');
        Route::delete('/destroy/{country}', [CountryController::class, 'destroy'])->name('destroy');
    });

    // containers entry
    Route::group(['prefix' => 'containers', 'as' => 'containers.'], function () {
        Route::get('/', [ContainerController::class, 'index'])->name('index');
        Route::post('/', [ContainerController::class, 'store'])->name('store');
        Route::get('/edit/{container}', [ContainerController::class, 'edit'])->name('edit');
        Route::put('/edit/{container}', [ContainerController::class, 'update'])->name('update');
        Route::delete('/destroy/{container}', [ContainerController::class, 'destroy'])->name('destroy');
    });

    // units entry
    Route::group(['prefix' => 'units', 'as' => 'units.'], function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::get('/edit/{unit}', [UnitController::class, 'edit'])->name('edit');
        Route::put('/edit/{unit}', [UnitController::class, 'update'])->name('update');
        Route::delete('/destroy/{unit}', [UnitController::class, 'destroy'])->name('destroy');
    });

    // common-names entry
    Route::group(['prefix' => 'common-names', 'as' => 'common-names.'], function () {
        Route::get('/', [CommonNameController::class, 'index'])->name('index');
        Route::post('/', [CommonNameController::class, 'store'])->name('store');
        Route::get('/edit/{unit}', [CommonNameController::class, 'edit'])->name('edit');
        Route::put('/edit/{unit}', [CommonNameController::class, 'update'])->name('update');
        Route::delete('/destroy/{unit}', [CommonNameController::class, 'destroy'])->name('destroy');
    });

    // formulations entry
    Route::group(['prefix' => 'formulations', 'as' => 'formulations.'], function () {
        Route::get('/', [FormulationController::class, 'index'])->name('index');
        Route::post('/', [FormulationController::class, 'store'])->name('store');
        Route::get('/edit/{unit}', [FormulationController::class, 'edit'])->name('edit');
        Route::put('/edit/{unit}', [FormulationController::class, 'update'])->name('update');
        Route::delete('/destroy/{unit}', [FormulationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('dataentry')->group(function () {
        Route::resource('checklists', ChecklistController::class)
            ->names('dataentry.checklists');

        Route::get('checklists/follow-steps/{checklist}', [ChecklistController::class, 'follow_steps'])->name('dataentry.checklists.follow-steps');

        // step 2
        Route::post('checklists/follow-steps/store-checklist-containers/{checklist}', [ChecklistController::class, 'store_checklist_containers'])->name('dataentry.checklists.create-container');
        Route::delete('checklists/follow-steps/delete-checklist-containers/{checklist}/{checklist_container}', [ChecklistController::class, 'destroy_checklist_containers'])->name('dataentry.checklists.destroy-container');

        // Route::get('checklists/follow-steps/edit-checklist-containers/{checklist}/{checklist_container}', [ChecklistController::class, 'edit_checklist_containers'])->name('dataentry.checklists.edit-container');
        // Route::put('checklists/follow-steps/edit-checklist-containers/{checklist}/{checklist_container}', [ChecklistController::class, 'update_checklist_containers'])->name('dataentry.checklists.update-container');

        // step 3
        Route::post('checklists/follow-steps/store-checklist-producer/{checklist}', [ChecklistController::class, 'store_checklist_producer'])->name('dataentry.checklists.update-producer');
        Route::delete('checklists/follow-steps/delete-checklist-producer/{checklist}', [ChecklistController::class, 'destroy_checklist_producer'])->name('dataentry.checklists.remove-producer');

        // step 4
        Route::post('checklists/follow-steps/store-checklist-formulations/{checklist}', [ChecklistController::class, 'store_checklist_formulations'])->name('dataentry.checklists.create-formulation');
        Route::delete('checklists/follow-steps/delete-checklist-formulations/{checklist}/{checklist_formulation}', [ChecklistController::class, 'destroy_checklist_formulations'])->name('dataentry.checklists.destroy-formulation');


        // step 5
        Route::post('checklists/follow-steps/store-checklist-date/{checklist}', [ChecklistController::class, 'store_checklist_date'])->name('dataentry.checklists.update-receipt-date');
        Route::delete('checklists/follow-steps/delete-checklist-date/{checklist}', [ChecklistController::class, 'destroy_checklist_date'])->name('dataentry.checklists.remove-receipt-date');

        // Change these to POST routes
        Route::post('checklists/{checklist}/verify', [ChecklistController::class, 'verify'])
            ->name('dataentry.checklists.verify');

        Route::post('checklists/{checklist}/approve', [ChecklistController::class, 'approve'])
            ->name('dataentry.checklists.approve');

        // Checklist Details Routes
        Route::prefix('checklists/{checklist}')->group(function () {
            Route::resource('details', ChecklistDetailController::class)
                ->names('dataentry.checklists.details');
        });

        Route::get(
            'dataentry/checklists/{checklist}/print',
            [ChecklistController::class, 'print']
        )
            ->name('dataentry.checklists.print');
    });

    Route::resource('users', UserController::class);
    Route::get('users/{user}/change-password', [UserController::class, 'changePasswordForm'])->name('users.change-password');
    Route::post('users/{user}/change-password', [UserController::class, 'changePassword']);

    Route::get('/bishadi-types', [BishadiTypeController::class, 'index'])->name('bishadi-types.index');
    Route::get('/bishadi-types/create', [BishadiTypeController::class, 'create'])->name('bishadi-types.create');
    Route::post('/bishadi-types', [BishadiTypeController::class, 'store'])->name('bishadi-types.store');
    Route::get('/bishadi-types/{bishadiType}', [BishadiTypeController::class, 'show'])->name('bishadi-types.show');
    Route::get('/bishadi-types/{bishadiType}/edit', [BishadiTypeController::class, 'edit'])->name('bishadi-types.edit');
    Route::put('/bishadi-types/{bishadiType}', [BishadiTypeController::class, 'update'])->name('bishadi-types.update');
    Route::delete('/bishadi-types/{bishadiType}', [BishadiTypeController::class, 'destroy'])->name('bishadi-types.destroy');

    Route::post('dataentry/checklists/{checklist}/send-back', [ChecklistController::class, 'sendBack'])
        ->name('dataentry.checklists.send-back');

    Route::post('dataentry/checklists/{checklist}/send-to-verify', [ChecklistController::class, 'sendToVerify'])
        ->name('dataentry.checklists.send-to-verify');

    Route::get('dataentry/notifications', [ChecklistController::class, 'notifications'])
        ->name('dataentry.checklists.notifications');

    Route::get('dataentry/notifications/{id}/mark-read', [ChecklistController::class, 'markNotificationAsRead'])
        ->name('dataentry.checklists.mark-notification-read');

    Route::post('checklists/{checklist}/send-back-verifier', [ChecklistController::class, 'sendBackVerifier'])
        ->name('checklists.send-back-verifier');
    Route::post('checklists/{checklist}/send-back-approver', [ChecklistController::class, 'sendBackApprover'])
        ->name('checklists.send-back-approver');

    Route::get('/checklists/reports', [ChecklistController::class, 'reports'])->name('dataentry.checklists.reports');


    Route::get('get-license-info', [ChecklistController::class, 'getLicenseInfo'])
        ->name('getLicenseInfo');

    Route::get('license-profile/{licenseNo}', [ChecklistController::class, 'showLicenseProfile'])
        ->name('license.profile');
    Route::resource('sources', SourceController::class);

    Route::resource('objectives', ObjectiveController::class);

    Route::get('/database/backup', [DatabaseBackupController::class, 'index'])->name('database.backup');
    Route::post('/database/backup/download', [DatabaseBackupController::class, 'download'])->name('database.backup.download');

    // Route::prefix('checklists/{checklist}')->group(function () {
    //     Route::get('/panjikarans', [PanjikaranController::class, 'index'])->name('panjikarans.index');
    //     Route::get('/panjikarans/create', [PanjikaranController::class, 'create'])->name('panjikarans.create');
    //     Route::post('/panjikarans', [PanjikaranController::class, 'store'])->name('panjikarans.store');
    //     Route::get('/panjikarans/{panjikaran}', [PanjikaranController::class, 'show'])->name('panjikarans.show');
    //     Route::get('/panjikarans/{panjikaran}/edit', [PanjikaranController::class, 'edit'])->name('panjikarans.edit');
    //     Route::put('/panjikarans/{panjikaran}', [PanjikaranController::class, 'update'])->name('panjikarans.update');
    //     Route::delete('/panjikarans/{panjikaran}', [PanjikaranController::class, 'destroy'])->name('panjikarans.destroy');
    // });

    Route::resource('usages', UsageController::class);

    Route::resource('crops', CropController::class);

    Route::resource('pests', PestController::class);

    Route::resource('packagedestroys', PackageDestroyController::class);

    Route::get('panjikaran/checklists', [PanjikaranController::class, 'checklistIndex'])->name('checklists.index');

    // Panjikaran Routes
    Route::resource('panjikarans', PanjikaranController::class);
    Route::get('/panjikaran/{panjikaran}/workflow', [PanjikaranController::class, 'workflow'])->name('panjikaran.workflow');
    Route::get('/panjikaran/{panjikaran}/print', [PanjikaranController::class, 'print'])->name('panjikaran.print');
    Route::get('/panjikaran/reports', [PanjikaranController::class, 'reports'])->name('panjikarans.reports');


    Route::get('/bargikarans', [BargikaranController::class, 'index'])->name('bargikarans.index');
    Route::post('/bargikarans', [BargikaranController::class, 'store'])->name('bargikarans.store');
    Route::get('/bargikarans/{bargikaran}', [BargikaranController::class, 'show'])->name('bargikarans.show');
    Route::get('/bargikarans/{bargikaran}/edit', [BargikaranController::class, 'edit'])->name('bargikarans.edit');
    Route::put('/bargikarans/{bargikaran}', [BargikaranController::class, 'update'])->name('bargikarans.update');
    Route::delete('/bargikarans/{bargikaran}', [BargikaranController::class, 'destroy'])->name('bargikarans.destroy');
});

Route::get('/recommended-crops', [RecommendedCropController::class, 'index'])->name('recommended-crops.index');
Route::post('/recommended-crops', [RecommendedCropController::class, 'store'])->name('recommended-crops.store');
Route::get('/recommended-crops/{recommendedCrop}', [RecommendedCropController::class, 'show'])->name('recommended-crops.show');
Route::get('/recommended-crops/{recommendedCrop}/edit', [RecommendedCropController::class, 'edit'])->name('recommended-crops.edit');
Route::put('/recommended-crops/{recommendedCrop}', [RecommendedCropController::class, 'update'])->name('recommended-crops.update');
Route::delete('/recommended-crops/{recommendedCrop}', [RecommendedCropController::class, 'destroy'])->name('recommended-crops.destroy');


Route::get('/recommended-pests', [RecommendedPestController::class, 'index'])->name('recommended-pests.index');
Route::post('/recommended-pests', [RecommendedPestController::class, 'store'])->name('recommended-pests.store');
Route::get('/recommended-pests/{recommendedPest}', [RecommendedPestController::class, 'show'])->name('recommended-pests.show');
Route::get('/recommended-pests/{recommendedPest}/edit', [RecommendedPestController::class, 'edit'])->name('recommended-pests.edit');
Route::put('/recommended-pests/{recommendedPest}', [RecommendedPestController::class, 'update'])->name('recommended-pests.update');
Route::delete('/recommended-pests/{recommendedPest}', [RecommendedPestController::class, 'destroy'])->name('recommended-pests.destroy');

// HCS Details Routes
Route::post('/hcs-details', [App\Http\Controllers\HcsDetailController::class, 'store'])->name('hcs-details.store');
Route::get('/hcs-details/{hcsDetail}/edit', [App\Http\Controllers\HcsDetailController::class, 'edit'])->name('hcs-details.edit');
Route::put('/hcs-details/{hcsDetail}', [App\Http\Controllers\HcsDetailController::class, 'update'])->name('hcs-details.update');
Route::delete('/hcs-details/{hcsDetail}', [App\Http\Controllers\HcsDetailController::class, 'destroy'])->name('hcs-details.destroy');

// NNSW Details Routes
Route::post('/nnsw-details', [App\Http\Controllers\NnswDetailController::class, 'store'])->name('nnsw-details.store');
Route::get('/nnsw-details/{nnswDetail}/edit', [App\Http\Controllers\NnswDetailController::class, 'edit'])->name('nnsw-details.edit');
Route::put('/nnsw-details/{nnswDetail}', [App\Http\Controllers\NnswDetailController::class, 'update'])->name('nnsw-details.update');
Route::delete('/nnsw-details/{nnswDetail}', [App\Http\Controllers\NnswDetailController::class, 'destroy'])->name('nnsw-details.destroy');

// Renewal Routes
Route::get('/renewals', [App\Http\Controllers\RenewalController::class, 'index'])->name('renewals.index');
Route::get('/renewals/create', [App\Http\Controllers\RenewalController::class, 'create'])->name('renewals.create');
Route::post('/renewals', [App\Http\Controllers\RenewalController::class, 'store'])->name('renewals.store');
Route::get('/renewals/{renewal}', [App\Http\Controllers\RenewalController::class, 'show'])->name('renewals.show');
Route::get('/renewals/{renewal}/edit', [App\Http\Controllers\RenewalController::class, 'edit'])->name('renewals.edit');
Route::put('/renewals/{renewal}', [App\Http\Controllers\RenewalController::class, 'update'])->name('renewals.update');
Route::delete('/renewals/{renewal}', [App\Http\Controllers\RenewalController::class, 'destroy'])->name('renewals.destroy');

require __DIR__ . '/auth.php';
