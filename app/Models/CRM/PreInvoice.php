<?php


namespace App\Models\CRM;


use App\Casts\Jalali;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\CRM\PreInvoice
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CRM\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\PreInvoiceDetail[] $detail
 * @property-read int|null $detail_count
 * @property-read \App\Models\CRM\Invoice $invoice
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $total_price
 * @property string|null $total_discount
 * @property string $tax
 * @property int $status
 * @property int $customer_id
 * @property int $invoice_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\PreInvoiceDetail[] $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereTotalPrice($value)
 * @property int $type
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereType($value)
 */
class PreInvoice extends Model
{
    CONST STATUS_OPEN=1;
    CONST STATUS_CLOSE=2;
    CONST STATUS_FACTOR_SHODEH=3;

    CONST  TYPE_RASMI=1;
    CONST  TYPE_GHEYRE_RASMI=0;


    protected $table = 'pre_invoices';
    protected $fillable = [
        'type',
        'customer_id',
//        'total_discount',
//        'date',
        'description',
        'title',
        'date',
    ];

    protected $casts = [
//        'updated_at' => Jalali::class . ':time',
//        'created_at' => Jalali::class . ':time',
    ];

    public function details()
    {
        return $this->hasMany(PreInvoiceDetail::class,'pre_invoice_id');
    }

//    public function invoice() {
//        return $this->belongsTo(Invoice::class,'pre_invoice_id') ;
//    }

    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id') ;
    }
    public function totalPriceAll(){
       return $this->details()
            ->selectRaw('SUM(count*unit_price) as total_price')
            ->first()->total_price;
    }
    public function totalPrice(){
       return $this->details()
            ->selectRaw('(count*unit_price) as total_price')->get()
            ;
    }

}
