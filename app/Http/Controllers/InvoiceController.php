<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',            
        ]);

        $product = Invoice::create($request->all());

        return response()->json($product, 201);
    }

    //update invoice to finish
    public function update(Request $request, int $invoice_id) 
    {
        $invoice = Invoice::find($invoice_id);
        if(empty($invoice)) {
            return response()->json("Invoice not found", 404);
        }
        
        $invoice->status = 'finished';
        $invoice->save();

        return response()->json("Invoice updated successfully", 200);
    }

}
