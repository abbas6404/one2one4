<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;

class DivisionController extends Controller
{
    public function getDistricts($divisionId)
    {
        $division = Division::findOrFail($divisionId);
        return response()->json($division->districts);
    }
} 