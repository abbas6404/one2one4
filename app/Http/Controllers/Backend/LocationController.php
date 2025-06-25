<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Divisions
    public function divisions()
    {
        $divisions = Division::all();
        return view('backend.locations.divisions.index', compact('divisions'));
    }

    public function createDivision()
    {
        return view('backend.locations.divisions.create');
    }

    public function storeDivision(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:divisions',
            'bn_name' => 'required|string|max:255',
        ]);

        Division::create($request->all());
        return redirect()->route('admin.locations.divisions')
            ->with('success', 'Division created successfully.');
    }

    public function editDivision(Division $division)
    {
        return view('backend.locations.divisions.edit', compact('division'));
    }

    public function updateDivision(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name,' . $division->id,
            'bn_name' => 'required|string|max:255',
        ]);

        $division->update($request->all());
        return redirect()->route('admin.locations.divisions')
            ->with('success', 'Division updated successfully.');
    }

    public function destroyDivision(Division $division)
    {
        $division->delete();
        return redirect()->route('admin.locations.divisions')->with('success', 'Division deleted successfully.');
    }

    // Districts
    public function districts()
    {
        $districts = District::with('division')->get();
        return view('backend.locations.districts.index', compact('districts'));
    }

    public function createDistrict()
    {
        $divisions = Division::all();
        return view('backend.locations.districts.create', compact('divisions'));
    }

    public function storeDistrict(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255|unique:districts',
            'bn_name' => 'required|string|max:255',
        ]);

        District::create($request->all());
        return redirect()->route('admin.locations.districts')
            ->with('success', 'District created successfully.');
    }

    public function editDistrict(District $district)
    {
        $divisions = Division::all();
        return view('backend.locations.districts.edit', compact('district', 'divisions'));
    }

    public function updateDistrict(Request $request, District $district)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255|unique:districts,name,' . $district->id,
            'bn_name' => 'required|string|max:255',
        ]);

        $district->update($request->all());
        return redirect()->route('admin.locations.districts')
            ->with('success', 'District updated successfully.');
    }

    public function destroyDistrict(District $district)
    {
        $district->delete();
        return redirect()->route('admin.locations.districts')
            ->with('success', 'District deleted successfully.');
    }

    // Upazilas
    public function upazilas()
    {
        $upazilas = Upazila::with('district.division')->get();
        return view('backend.locations.upazilas.index', compact('upazilas'));
    }

    public function createUpazila()
    {
        $districts = District::with('division')->get();
        return view('backend.locations.upazilas.create', compact('districts'));
    }

    public function storeUpazila(Request $request)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255|unique:upazilas',
            'bn_name' => 'required|string|max:255',
        ]);

        Upazila::create($request->all());
        return redirect()->route('admin.locations.upazilas')
            ->with('success', 'Upazila created successfully.');
    }

    public function editUpazila(Upazila $upazila)
    {
        $districts = District::with('division')->get();
        return view('backend.locations.upazilas.edit', compact('upazila', 'districts'));
    }

    public function updateUpazila(Request $request, Upazila $upazila)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255|unique:upazilas,name,' . $upazila->id,
            'bn_name' => 'required|string|max:255',
        ]);

        $upazila->update($request->all());
        return redirect()->route('admin.locations.upazilas')
            ->with('success', 'Upazila updated successfully.');
    }

    public function destroyUpazila(Upazila $upazila)
    {
        $upazila->delete();
        return redirect()->route('admin.locations.upazilas')
            ->with('success', 'Upazila deleted successfully.');
    }

    public function hierarchy(Request $request)
    {
        $query = Division::with(['districts.upazilas']);

        // Filtering
        if ($request->filled('division')) {
            $query->where('name', 'like', '%' . $request->division . '%');
        }
        if ($request->filled('district')) {
            $query->whereHas('districts', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->district . '%');
            });
        }
        if ($request->filled('upazila')) {
            $query->whereHas('districts.upazilas', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->upazila . '%');
            });
        }

        // For Export
        if ($request->has('export') && $request->export == 'csv') {
            $divisions = $query->get();
            $filename = 'locations_export_' . date('Y-m-d') . '.csv';
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            $columns = array('Division ID', 'Division Name (EN)', 'Division Name (BN)', 
                            'District ID', 'District Name (EN)', 'District Name (BN)',
                            'Upazila ID', 'Upazila Name (EN)', 'Upazila Name (BN)');

            $callback = function() use ($divisions, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($divisions as $division) {
                    if ($division->districts->count()) {
                        foreach ($division->districts as $district) {
                            if ($district->upazilas->count()) {
                                foreach ($district->upazilas as $upazila) {
                                    $row = [
                                        $division->id, $division->name, $division->bn_name,
                                        $district->id, $district->name, $district->bn_name,
                                        $upazila->id, $upazila->name, $upazila->bn_name
                                    ];
                                    fputcsv($file, $row);
                                }
                            } else {
                                $row = [
                                    $division->id, $division->name, $division->bn_name,
                                    $district->id, $district->name, $district->bn_name,
                                    '', '', ''
                                ];
                                fputcsv($file, $row);
                            }
                        }
                    } else {
                        $row = [
                            $division->id, $division->name, $division->bn_name,
                            '', '', '',
                            '', '', ''
                        ];
                        fputcsv($file, $row);
                    }
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $divisions = $query->paginate(10)->appends($request->except('page'));
        $total_divisions = Division::count();
        $total_districts = District::count();
        $total_upazilas = Upazila::count();
        $allDivisions = Division::all();
        $allDistricts = District::all();
        $allUpazilas = Upazila::all();
        return view('backend.locations.index', compact('divisions', 'total_divisions', 'total_districts', 'total_upazilas', 'allDivisions', 'allDistricts', 'allUpazilas'));
    }
}
