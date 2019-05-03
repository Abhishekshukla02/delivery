<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**

*/
class InvoiceItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'price', 'quantity', 'product_id','invoice_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}