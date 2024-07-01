<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\kasbon;
use Illuminate\Http\Request;

class kasbonController extends Controller
{
    public function index()
    {
        $kasbons = kasbon::all();
        foreach ($kasbons as $kasbon) {
        }
        return view('kasbon.index', compact('kasbons'));
    }
}
