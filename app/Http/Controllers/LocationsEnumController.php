<?php

namespace App\Http\Controllers;

use App\Models\{
    Region,
    Province,
    City,
    Barangay
};
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LocationsEnumController extends Controller
{
    /**
     *  Index Regions
     */
    public function indexRegions() {
        return Region::orderBy('order', 'asc')->get();
    }

    /**
     *  Index Provinces
     */
    public function indexProvinces(Region $region) {
        return $region->provinces()->orderBy('name', 'asc')->get();
    }

    /**
     *  Index Cities
     */
    public function indexCities(Province $province) {
        return $province->cities()->orderBy('name', 'asc')->get();
    }

    /**
     *  Index Barangays
     */
    public function indexBarangays(City $city) {
        return $city->barangays()->orderBy('name', 'asc')->get();;
    }
}
