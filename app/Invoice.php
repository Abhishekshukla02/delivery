<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**

*/
class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $appends = [
        'total'
    ];

    public function invoiceItems() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function getTotalAttribute() {

        $total = 0;

        foreach ($this->invoiceItems as $product) {
            $total += $product->price;
        }

        return $total;

    }

}