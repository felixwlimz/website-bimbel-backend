<?php 

namespace App\Services;

use App\Repositories\PaymentRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;


class PembayaranServices{


    protected TransactionRepository $transactionRepository;
    protected PaymentRepository $paymentRepository;

    public function __construct(TransactionRepository $transactionRepository){
        $this->transactionRepository = $transactionRepository;
    }


    public function getAllTransactions(){
        return $this->transactionRepository->findAll();
    }

    public function createTransaction(array $data){
        return $this->transactionRepository->create($data);
    }

    public function createNewMidtransTransaction(Request $request){
        return $this->paymentRepository->createCharge($request);
    }


    public function getMidtransOrderId($orderId){
        return $this->transactionRepository->findMidtransOrderId($orderId);
    }


    public function updateTransaction($orderId, $status){
        return $this->transactionRepository->update($orderId, $status);
    }
}