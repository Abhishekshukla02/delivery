<?php

namespace App\Http\Controllers;

use App\InvoiceItem;
use App\Product;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    //update amount of the product
    public function updateProductAmount(Request $request) 
    {
        $this->validate($request, [
            'invoice_id' => 'required|exists:invoices,id',
            'amount' =>  'required|numeric'
        ]);

        $invoice_id = $request->get('invoice_id');
        $amount = $request->get('amount');;

        //check first if invoice is open
        $invoice = Invoice::where('id','=',$invoice_id)
                    ->where('status','!=','finished' )
                    ->first()->toArray();

        if(empty($invoice)) {
            return response()->json("This invoice is already closed", 400);
        }

        //update amount for last product in invoice item
        $invoice_item = InvoiceItem::where('invoice_id', $invoice_id)->orderBy('id', 'desc')->first();

        try {
            $invoice_item->price = $amount;
            $invoice_item->save();
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

        return response()->json($invoice_item, 201);
    }

    //delete product from invoice
    public function deleteInvoiceItem(Request $request, int $item_id)
    {

        $invoiceItem = InvoiceItem::where('invoice_items.id','=',$item_id)
            ->leftJoin('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->where('invoices.status','!=', 'finished')
            ->delete();

        if($invoiceItem) {
            return response()->json("Deleted successfully", 200);
        } else {
            return response()->json("Can not delete this product", 400);
        }
    }
}
