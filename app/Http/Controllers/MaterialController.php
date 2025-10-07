<?php

namespace App\Http\Controllers;

use App\Services\SoalMateriServices;
use Illuminate\Http\Request;

class MaterialController extends Controller
{

    protected SoalMateriServices $materialServices;

    public function __construct(SoalMateriServices $materialServices)
    {
        $this->materialServices = $materialServices;
    }

    public function index(){
        $materials = $this->materialServices->getAllMaterials();
        return response()->json([
            'message' => 'Materials retrieved successfully',
            'data' => $materials
        ], 200);
    }

    public function store(Request $request){

        $material = $this->materialServices->addNewMaterial($request);

        return response()->json([
            'message' => 'Material created successfully',
            'data' => $material
        ], 201);

    }
}
