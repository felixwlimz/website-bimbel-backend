<?php
namespace App\Repositories;
use App\Models\Transaction;
use Illuminate\Support\Arr;

class TransactionRepository
{

    public function findAll() {
        return Transaction::with(['user', 'package', 'voucher'])->get();
    }

    public function find($id)
    {
        return Transaction::with(['user', 'package', 'voucher'])->findOrFail($id);
    }
    

    public function findMidtransOrderId($orderId)
    {
        return Transaction::where('invoice_number', $orderId)->first();
    }

    public function create(array $data)
    {
        $transaction = Arr::only($data, [
            'user_id',
            'amount',
            'status',
        ]);

        return Transaction::create($transaction);
    }

    public function update($id, $data)
    {
        $transaction = Transaction::with(['user', 'package', 'voucher'])->findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }

    public function delete($id)
    {
        $transaction = Transaction::with(['user', 'package', 'voucher'])->findOrFail($id);
        $transaction->delete();
        return $transaction;
    }
}
