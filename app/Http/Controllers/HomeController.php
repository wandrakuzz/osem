<?php

namespace App\Http\Controllers;

use App\Models\Batter;
use Illuminate\Http\Request;
use App\Models\Pastry;
use App\Models\Topping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Pastry::first() == null) {
            $parents = Http::get('https://repocodes.s3.amazonaws.com/interview.json');

            $this->storeJsonToDatabase($parents);
        }

        $pastries = Pastry::with(['batters','toppings'])->get();

        return view('home',compact('pastries'));
    }

    public function storeJsonToDatabase($parents)
    {
        DB::transaction(function() use ($parents){
            foreach ($parents->object() as $parent) {
                $pastry = Pastry::create([
                    'pastry_id' => $parent->id,
                    'type'      => $parent->type,
                    'name'      => $parent->name,
                    'ppu'       => $parent->ppu,
                    'image'     => null
                ]);

                if($parent->batters) {
                    foreach ($parent->batters->batter as $batter) {
                        Batter::create([
                            'pastry_id' => $pastry->id,
                            'batter_id' => $batter->id,
                            'type'      => $batter->type
                        ]);
                    }
                }

                if ($parent->topping) {
                    foreach ($parent->topping as $topping) {
                        Topping::create([
                            'pastry_id'     => $pastry->id,
                            'topping_id'    => $topping->id,
                            'type'          => $topping->type
                        ]);
                    }
                }
            }

            $pastries = Pastry::get();

            $i = 1;
            
            foreach ($pastries as $pastry) {

                $pastry->update([
                    'image' => 'image/image'.$i++.'.'.'jpg'
                ]);
            }

        });
    }

   
}
