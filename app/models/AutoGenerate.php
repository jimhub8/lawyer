<?php

namespace App\models;

class AutoGenerate
{
    public function randomSku()
    {
        $product = Product::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $product = ($product) ? 'PRO_' . str_pad($product->id + 1, 8, "0", STR_PAD_LEFT) : 'MFT_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['sku_no' => $product], ['sku_no' => 'unique:products,sku_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $product;
    }

    public function orderNo()
    {
        $product = Saleorder::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $product = ($product) ? 'ORD_' . str_pad($product->id + 1, 8, "0", STR_PAD_LEFT) : 'ORD_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['order_no' => $product], ['order_no' => 'unique:saleorders,order_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $product;
    }

    public function randomReturnId()
    {
        $returns = ReturnOrder::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $returns = ($returns) ? 'RTN_' . str_pad($returns->id + 1, 8, "0", STR_PAD_LEFT) : 'RTN_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        // dd($returns);
        $validator = \Validator::make(['return_id' => $returns], ['return_id' => 'unique:return_orders,return_id']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $returns;
    }

    public function randomInvoiceNo()
    {
        $invoices = Invoice::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $invoices = ($invoices) ? 'INV_' . str_pad($invoices->id + 1, 8, "0", STR_PAD_LEFT) : 'INV_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['invoice_no' => $invoices], ['invoice_no' => 'unique:invoices,invoice_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $invoices;
    }

    public function packageNo()
    {
        $packages = Package::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $packages = ($packages) ? 'PKG_' . str_pad($packages->id + 1, 8, "0", STR_PAD_LEFT) : 'PKG_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['package_no' => $packages], ['package_no' => 'unique:packages,package_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $packages;
    }

    public function referenceNo()
    {
        $history = History::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $history = ($history) ? 'REF_' . str_pad($history->id + 1, 8, "0", STR_PAD_LEFT) : 'REF_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['reference_no' => $history], ['reference_no' => 'unique:histories,reference_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $history;
    }

    public function randomClientId()
    {
        $client = Client::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $client = ($client) ? 'CL_' . str_pad($client->id + 1, 8, "0", STR_PAD_LEFT) : 'CL_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['client_id' => $client], ['client_id' => 'unique:clients,client_id']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $client;
    }

    public function randomTransferId()
    {
        $transfer = Inventorytransfer::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $transfer = ($transfer) ? 'TRN_' . str_pad($transfer->id + 1, 8, "0", STR_PAD_LEFT) : 'TRN_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['transfer_id' => $transfer], ['transfer_id' => 'unique:inventorytransfers,transfer_id']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $transfer;
    }

    public function randomReceiverId()
    {
        $receiver = Receiver::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $receiver = ($receiver) ? 'RC_' . str_pad($receiver->id + 1, 8, "0", STR_PAD_LEFT) : 'RC_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['receiver_id' => $receiver], ['receiver_id' => 'unique:receivers,receiver_id']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $receiver;
    }

    public function randomId()
    {
        $id = str_random(10);
        $validator = \Validator::make(['sku_no' => $id], ['sku_no' => 'unique:products,sku_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $id;
    }

    public function DeliveryId()
    {
        $id = str_random(10);
        $validator = \Validator::make(['delivery_no' => $id], ['delivery_no' => 'unique:warehouse_receives,delivery_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $id;
    }
}
