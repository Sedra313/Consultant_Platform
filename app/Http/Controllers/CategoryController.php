<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Expert;

class CategoryController extends Controller
{
 //      public function __construct()
 // {
 //     $this->middleware('client.credentials')->only(['index','show']);
 // }
    public function index()
    {
        $categories = Category::all();
        return response() -> json(['categories' => $categories] , 200);
    }
    
    public function experts($category_id)
    {
        $experts = Expert::where(['category_id'=> $category_id])
            ->get(['id','name'  ,'rating' , 'profile_image' , 'specialization']);
            return response() -> json(['experts' => $experts] , 200);
          

        
    }
}
