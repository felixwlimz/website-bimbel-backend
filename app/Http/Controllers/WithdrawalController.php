<?php

namespace App\Http\Controllers;

use App\Services\WithdrawalServices;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function __construct(
        protected WithdrawalServices $withdrawalService
    ) {}

    public function index()
    {
        return response()->json($this->withdrawalService->getAll());
    }

    public function show(string $id)
    {
        return response()->json($this->withdrawalService->getById($id));
    }

    public function store(Request $request)
    {
        return response()->json(
            $this->withdrawalService->request($request->all()),
            201
        );
    }

    public function approve(string $id, Request $request)
    {
        return response()->json(
            $this->withdrawalService->approve($id, $request->user()->id)
        );
    }

    public function reject(string $id, Request $request)
    {
        return response()->json(
            $this->withdrawalService->reject($id, $request->user()->id)
        );
    }
}
