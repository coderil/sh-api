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
    public function indexRegions() {
        return Region::orderBy('order', 'asc')->get();
    }

    public function indexProvinces(Region $region) {
        return $region->provinces()->orderBy('name', 'asc')->get();
    }

    public function indexCities(Province $province) {
        return $province->cities()->orderBy('name', 'asc')->get();
    }

    public function indexBarangays(City $city) {
        return $city->barangays()->orderBy('name', 'asc')->get();;
    }
}
