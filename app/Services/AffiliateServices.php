<?php

namespace App\Services;
use App\Repositories\AffiliateRepository;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use Illuminate\Support\Str;

class AffiliateServices {


    protected AffiliateRepository $affiliateRepository;

    public function __construct(AffiliateRepository $affiliateRepository)
    {
        $this->affiliateRepository = $affiliateRepository;
    }

    public function getAffiliateOrders()
    {
        return $this->affiliateRepository->findAll();
    }



    public function createAffiliate(Request $request)
    {
        $validated = $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'noRekening' => 'required|string|max:20',
            'namaBank' => 'required|string|max:100',
            'namaPemilikRekening' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        return $this->affiliateRepository->create($user->id, $validated);
    }

    public function withdraw(Request $request)
{
    $request->validate([
        'amount'          => 'required|numeric|min:10000',
        'bank_name'       => 'required|string',
        'account_number'  => 'required|string',
        'account_name'    => 'required|string',
    ]);

    $user = auth()->user();
    $affiliate = $user->affiliate;

    if (!$affiliate) {
        return response()->json(['message' => 'Affiliate not found'], 404);
    }

    if ($request->amount > $affiliate->commission_rate) {
        return response()->json(['message' => 'Saldo tidak cukup'], 400);
    }

    // Kurangi saldo pending
    $affiliate->commission_rate -= $request->amount;
    $affiliate->save();

    $withdraw = Withdrawal::create([
        'id'             => Str::uuid(),
        'affiliate_id'   => $affiliate->id,
        'amount'         => $request->amount,
        'bank_name'      => $request->bank_name,
        'account_number' => $request->account_number,
        'account_name'   => $request->account_name,
        'status'         => 'pending'
    ]);

    return $withdraw;
}


}