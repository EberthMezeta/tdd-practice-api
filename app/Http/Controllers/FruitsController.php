<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use Illuminate\Http\Request;

class FruitsController extends Controller
{
    public function getFruit($id)
    {
        return Fruit::find($id);
    }
}
