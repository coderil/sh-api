<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop\Shop;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\ExistingShopException;
use Illuminate\Support\Facades\DB;
use PDOException;

class ShopController extends Controller
{
    use ResponseAPI;

    public function index() {
        
    }

    public function store(StoreShopRequest $request) {
        try {
            DB::beginTransaction();
            $existingShop = Shop::where('owner_id', $request->user()->id)->first();

            if ($existingShop) {
                throw new PDOException();
            }

            $image = $request->file('logo');
            if ($image) {
                $path = $image->storeAs(
                    'logo', 
                    $request->name . '-logo.' . $image->getClientOriginalExtension(), 
                    'public'
                );
                $url = Storage::url($path);
            }

            $shop = Shop::create([
                'owner_id' => $request->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'logo' =>  $url ?? null
            ]);
            DB::commit();
        } catch (PDOException $e) {
            return $this->error('Duplicate shop entry for owner', [], 401);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Something went wrong', $e, 400);
        }

        
        
        return $this->success('Shop created successfully', new ShopResource($shop), 201);
    }
    public function show(Shop $shop) {
        return $this->success('Shop fetched sucessfully', new ShopResource($shop));
    }
    public function update() {
        //
    }
    public function destroy() {
        //
    }
}
