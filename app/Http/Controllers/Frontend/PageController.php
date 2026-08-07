<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;

class PageController extends Controller
{
   public function home()
    {
        $banners = Banner::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get();

        return view('frontend.home', compact('banners', 'brands'));
    }


    // Mobile & Tablets
    public function smartphones() { return view('category.mobile-tablets.smartphones'); }
    public function mobileAccessories() { return view('category.mobile-tablets.mobile-accessories'); }
    public function powerCharging() { return view('category.mobile-tablets.power-charging'); }
    public function smartWatches() { return view('category.mobile-tablets.smart-watches'); }
    public function tablets() { return view('category.mobile-tablets.tablets'); }

    // Computers Office
    public function laptops() { return view('category.computers-office.laptops'); }
    public function desktopComputers() { return view('category.computers-office.desktop-computers'); }
    public function computerAccessories() { return view('category.computers-office.computer-accessories'); }
    public function monitors() { return view('category.computers-office.monitors'); }
    public function networkingDevices() { return view('category.computers-office.networking-devices'); }
    public function printersOfficeEquipment() { return view('category.computers-office.printers-office-equipment'); }
    public function storageDevices() { return view('category.computers-office.storage-devices'); }


    // Gaming & Entertainment
    public function gaming() { return view('category.gaming-entertainment.gaming'); }
    public function audio() { return view('category.gaming-entertainment.audio'); }
    public function gamingControllers() { return view('category.gaming-entertainment.gaming-controllers'); }
    public function headsetsAudioDevices() { return view('category.gaming-entertainment.headsets-audio-devices'); }
    public function cameras() { return view('category.gaming-entertainment.cameras'); }
    public function smartTvs() { return view('category.gaming-entertainment.smart-tvs'); }
    public function ledTvs() { return view('category.gaming-entertainment.led-tvs'); }
    public function androidTvs() { return view('category.gaming-entertainment.android-tvs'); }


    // Home Appliances
    public function refrigerators() { return view('category.home-appliances.refrigerators'); }
    public function airConditioners() { return view('category.home-appliances.air-conditioners'); }
    public function airCoolers() { return view('category.home-appliances.air-coolers'); }
    public function fans() { return view('category.home-appliances.fans'); }
    public function microwaveOvens() { return view('category.home-appliances.microwave-ovens'); }
    public function electricKettles() { return view('category.home-appliances.electric-kettles'); }
    public function riceCookers() { return view('category.home-appliances.rice-cookers'); }
    public function waterHeaters() { return view('category.home-appliances.water-heaters'); }


    // Smart Home
public function smartSpeakers(){return view('category.smart-home.smart-speakers');}
public function smartLighting(){return view('category.smart-home.smart-lighting');}
public function smartSecurity(){return view('category.smart-home.smart-security');}
public function smartLocks(){return view('category.smart-home.smart-door-locks');}
public function smartSensors(){return view('category.smart-home.smart-sensors');}

// Electrical
public function cablesAdapters() { return view('category.electrical.cables-adapters'); }
public function chargers() { return view('category.electrical.chargers'); }
public function extensionBoards() { return view('category.electrical.extension-boards'); }
public function powerBanks() { return view('category.electrical.power-banks'); }
public function batteries() { return view('category.electrical.batteries'); }
public function electricalAccessories() { return view('category.electrical.electrical-accessories'); }


    public function privacypolicy(){ return view('frontend.privacy-policy');}
    public function refundpolicy(){ return view('frontend.refund-policy');}
    public function termsofservice(){ return view('frontend.terms-of-service'); }
    public function contactus(){return view('frontend.contact-us'); }
    public function warrantypolicy(){return view('frontend.warranty-policy'); }
    public function careers(){return view('frontend.careers'); }
}
