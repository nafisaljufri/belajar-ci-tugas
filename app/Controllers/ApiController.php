<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel; 
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class ApiController extends ResourceController
{
    protected $apiKey;
    protected $user;
    protected $transaction;
    protected $transaction_detail;

    public function __construct()
    {
        $this->apiKey = env('API_KEY'); // pastikan ini ada di .env
        $this->user = new UserModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        $data = [ 
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $headers = $this->request->headers(); 

        // Ambil semua header dalam bentuk array
        $parsedHeaders = [];
        foreach ($headers as $key => $header) {
            $parsedHeaders[$key] = $header->getValue();
        }

        // Bandingkan header "Key" dengan $this->apiKey
        if (isset($parsedHeaders['Key']) && $parsedHeaders['Key'] == $this->apiKey) {
            $penjualan = $this->transaction->findAll();
            
            foreach ($penjualan as &$pj) {
                $pj['details'] = $this->transaction_detail->where('transaction_id', $pj['id'])->findAll();
            }

            $data['status'] = ["code" => 200, "description" => "OK"];
            $data['results'] = $penjualan;
        } 

        return $this->respond($data);
    }

    public function show($id = null)
    {
        //
    }

    public function new()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        //
    }

    public function delete($id = null)
    {
        //
    }
}
