<?php


namespace App\Models\CRM;


use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\CRM\PreInvoiceDetail
 *
 * @property-read \App\Models\CRM\PreInvoice $preInvoice
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $product_name
 * @property string|null $unit_price
 * @property int|null $count
 * @property int|null $per_invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail wherePerInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail whereUpdatedAt($value)
 * @property int $pre_invoice_id
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoiceDetail wherePreInvoiceId($value)
 */
class PreInvoiceDetail extends Model
{
    protected $table = 'pre_invoice_details';
    protected $fillable = [
        'product_name',
//        'unit_price',
        'count',
    ];
     public function preInvoice()
    {
        return $this->belongsTo(PreInvoice::class,'pre_invoice_id');
    }
    public  function totalPrice(){
       return $this->unit_price*$this->count;
    }
}
