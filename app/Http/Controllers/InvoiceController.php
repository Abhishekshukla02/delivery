<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    //get invoice
    public function getInvoice(Request $request)
    {
        $id = $request->query('id');
        $invoice = DB::select( DB::raw("SELECT i.id, i.name, p.name,SUM(p.cost) as total_product_cost,SUM(it.price) as invoice_item_sum,SUM(p.vat_class) as vat_class_sum, IFNULL(COUNT(*),0) product_count FROM invoices i LEFT JOIN invoice_items it ON it.invoice_id = i.id LEFT JOIN products p ON p.id = it.product_id WHERE (i.id = '$id') GROUP BY p.name") );

        return response()->json($invoice, 200);
    }

}
