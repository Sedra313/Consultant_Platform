<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Expert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\Category;


class SearchController extends Controller
{
    public function experts_search(Request $request)
       { 
#Remember that is not enough you have to add extra attribute sto search and sort by
        $query = Expert::select(['id','name','rating' , 'profile_image' , 'specialization']) 
       ->where('name','LIKE','%'.$request->name.'%')
       ->get();
            return response()->json([
                                         'status' => 'success',
                                         'data' => $query
                                    ], 200);
       }

   // public function specialization_search(Request $request)
   //     { 
   //      $query = Expert::select(['name'  ,'rating' , 'profile_image']) 
   //      ->where('specialization','LIKE','%'.$request->specialization.'%')
   //      ->get();
   //       return response()->json([
   //                                      'status' => 'success',
   //                                      'data' => $query
   //                                  ], 200);
   

        


             
  




}


























