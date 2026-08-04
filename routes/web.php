<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/', [PageController::class, 'home'])->name('home');



Route::prefix('category')->group(function () {

    // Mobile & Tablets
    Route::get('/smartphones', [PageController::class, 'smartphones'])->name('smartphones');
    Route::get('/mobile-accessories', [PageController::class, 'mobileAccessories'])->name('mobile.accessories');
    Route::get('/power-charging', [PageController::class, 'powerCharging'])->name('power.charging');
    Route::get('/smart-watches', [PageController::class, 'smartWatches'])->name('smart.watches');
    Route::get('/tablets', [PageController::class, 'tablets'])->name('tablets');

    // Computers Office
    Route::get('/laptops', [PageController::class, 'laptops'])->name('laptops');
    Route::get('/desktop-computers', [PageController::class, 'desktopComputers'])->name('desktop.computers');
    Route::get('/computer-accessories', [PageController::class, 'computerAccessories'])->name('computer.accessories');
    Route::get('/monitors', [PageController::class, 'monitors'])->name('monitors');
    Route::get('/networking-devices', [PageController::class, 'networkingDevices'])->name('networking.devices');
    Route::get('/printers-office-equipment', [PageController::class, 'printersOfficeEquipment'])->name('printers.office.equipment');
    Route::get('/storage-devices', [PageController::class, 'storageDevices'])->name('storage.devices');

    // Gaming & Entertainment
    Route::get('/gaming', [PageController::class, 'gaming'])->name('gaming');
    Route::get('/audio', [PageController::class, 'audio'])->name('audio');
    Route::get('/gaming-controllers', [PageController::class, 'gamingControllers'])->name('gaming.controllers');
    Route::get('/headsets-audio-devices', [PageController::class, 'headsetsAudioDevices'])->name('headsets.audio.devices');
    Route::get('/cameras', [PageController::class, 'cameras'])->name('cameras');
    Route::get('/smart-tvs', [PageController::class, 'smartTvs'])->name('smart.tvs');
    Route::get('/led-tvs', [PageController::class, 'ledTvs'])->name('led.tvs');
    Route::get('/android-tvs', [PageController::class, 'androidTvs'])->name('android.tvs');

    // Home Appliances
    Route::get('/refrigerators', [PageController::class, 'refrigerators'])->name('refrigerators');
    Route::get('/air-conditioners', [PageController::class, 'airConditioners'])->name('air.conditioners');
    Route::get('/air-coolers', [PageController::class, 'airCoolers'])->name('air.coolers');
    Route::get('/fans', [PageController::class, 'fans'])->name('fans');
    Route::get('/microwave-ovens', [PageController::class, 'microwaveOvens'])->name('microwave.ovens');
    Route::get('/electric-kettles', [PageController::class, 'electricKettles'])->name('electric.kettles');
    Route::get('/rice-cookers', [PageController::class, 'riceCookers'])->name('rice.cookers');
    Route::get('/water-heaters', [PageController::class, 'waterHeaters'])->name('water.heaters');
    Route::get('/washing-machines', [PageController::class, 'washingMachines'])->name('washing.machines');
    Route::get('/vacuum-cleaners', [PageController::class, 'vacuumCleaners'])->name('vacuum.cleaners');



    // Smart Home
    Route::get('/smart-speakers', [PageController::class, 'smartSpeakers'])->name('smart.speakers');
    Route::get('/smart-lighting', [PageController::class, 'smartLighting'])->name('smart.lighting');
    Route::get('/smart-security', [PageController::class, 'smartSecurity'])->name('smart.security');
    Route::get('/smart-locks', [PageController::class, 'smartLocks'])->name('smart.locks');
    Route::get('/smart-sensors', [PageController::class, 'smartSensors'])->name('smart.sensors');


    // Electrical
    Route::get('/cables-adapters', [PageController::class, 'cablesAdapters'])->name('cables.adapters');
    Route::get('/chargers', [PageController::class, 'chargers'])->name('chargers');
    Route::get('/extension-boards', [PageController::class, 'extensionBoards'])->name('extension.boards');
    Route::get('/power-banks', [PageController::class, 'powerBanks'])->name('power.banks');
    Route::get('/batteries', [PageController::class, 'batteries'])->name('batteries');
    Route::get('/electrical-accessories', [PageController::class, 'electricalAccessories'])->name('electrical.accessories');

});

Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
