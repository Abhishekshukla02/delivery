<?php

namespace App\Http\Controllers;

use App\InvoiceItem;
use App\Product;
use App\Invoice;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'barcode' => 'required|exists:products,barcode',
            'invoice_id' => 'required|exists:invoices,id'                        
        ]);

        $barcode = $request->get('barcode');
        $invoice_id = $request->get('invoice_id');

        //allow to add only when invoice in not finished
        $invoice = Invoice::where('id','=',$invoice_id)
                            ->where('status','!=','finished' )
                            ->exists();

        if(empty($invoice)) {
            return response()->json("This invoice is already closed", 400);
        } 

        $product = Product::where('barcode',$barcode)->first()->toArray();

        $invoiceItemData['description'] =  "Invoice name is ".$product['name'];
        $invoiceItemData['price'] =  $product['cost']; //need to store cost here, that will need to update
        $invoiceItemData['quantity'] =  1; //default quantity
        $invoiceItemData['product_id'] =  $product['id'];
        $invoiceItemData['invoice_id'] =  $invoice_id;
        $invoiceItem = InvoiceItem::create($invoiceItemData);

        return response()->json($invoiceItem, 201);
    }

    //update amount
    public function update(Request $request) 
    {
        //update the recepit    
    }
}
