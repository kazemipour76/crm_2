<?php


namespace App\Models\CRM;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\CRM\InvoiceDetail
 *
 * @property-read \App\Models\CRM\Invoice $Invoice
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $product_name
 * @property string $unit_price
 * @property int $count
 * @property int $invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CRM\Invoice $invoice
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereUpdatedAt($value)
 */
class InvoiceDetail extends BaseModel
{

    protected $table = 'invoice_details';
    protected $searchable=['product_name'];
    protected $fillable = [
        'product_name',
//        'unit_price',
//        'count',
    ];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
    public  function totalPrice(){
        return $this->unit_price*$this->count;
    }


    public static function getValidationInvoiceDetail($idEdit = false, $id = null)
    {

        $rules = [

            'unit_price' => 'required|nullable|regex:/(^([0-9,۰-۹]+)(\d+)?$)/u',
            'count' => 'required|regex:/(^([1-9۱-۹]+)(\d+)?$)/u',
//            'product_name' => 'required|regex:/(^([a-zA-z0-9,۰-۹آ-ی]+)(\d+)?$)/u'
            'product_name' => 'required|not_regex:/([<>])/'

        ];

        return $rules;
    }

}
