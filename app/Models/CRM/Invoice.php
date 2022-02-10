<?php


namespace App\Models\CRM;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;


///**
// * App\Models\CRM\Invoice
// *
// * @property int $id
// * @property string $total_price
// * @property string|null $total_discount
// * @property string $tax
// * @property int $customer_id
// * @property string $status
// * @property int $type
// * @property \Illuminate\Support\Carbon|null $created_at
// * @property \Illuminate\Support\Carbon|null $updated_at
// * @property-read \App\Models\CRM\Customer $customer
// * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\InvoiceDetail[] $detail
// * @property-read int|null $detail_count
// * @property-read \App\Models\CRM\PreInvoice|null $preInvoice
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereStatus($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTax($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalDiscount($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalPrice($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereType($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
// * @mixin \Eloquent
// * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\InvoiceDetail[] $details
// * @property-read int|null $details_count
// */
/**
 * App\Models\CRM\Invoice
 *
 * @property int $id
 * @property int|null $total_price
 * @property int|null $total_discount
 * @property string|null $description
 * @property string|null $title
 * @property string|null $date
 * @property int|null $tax
 * @property int $status
 * @property int $type
 * @property int $customer_id
 * @property int|null $pre_invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CRM\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\InvoiceDetail[] $details
 * @property-read int|null $details_count
 * @property-read \App\Models\CRM\PreInvoice|null $preInvoice
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePreInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends BaseModel
{
    CONST STATUS_OPEN=1;
    CONST STATUS_CLOSE=2;
    CONST STATUS_FACTOR_SHODEH=3;

    CONST  TYPE_RASMI=1;
    CONST  TYPE_GHEYRE_RASMI=0;

    protected $table = 'invoices';
    protected $fillable = [
        'type',
        'customer_id',
//        'total_discount',
//        'date',
        'description',
        'title',
//        'pre_invoice_id',
        'date',
    ];
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class,'invoice_id' );
    }

    public function preInvoice() {
        return $this->belongsTo(PreInvoice::class,'pre_invoice_id') ;
    }

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
    public static function getValidationInvoice($idEdit = false, $id = null)
    {

        $rules = [

            'date' => 'required|date',
            'title' => 'nullable|not_regex:/([<>])/',
            'description' => 'nullable|not_regex:/([<>])/',
            'total_discount' => 'nullable|regex:/(^([0-9,۰-۹]+)(\d+)?$)/u',
//            'perInvoiceTitle' => 'numeric|max:255',
        ];

        return $rules;
    }

    public static function getValidationSearchTitle()
    {
        $rules = [
//            'title' => 'regex:/(^([a-zA-z0-9آ-ی,۰-۹]+)(\d+)?$)/u',
            'title' => 'required|not_regex:/([<>])/'

        ];
        return $rules;
    }
    public static function getValidationSearchNumber()
    {
        $rules = [
            'perInvoiceNumber' => 'regex:/(^([0-9۰-۹]+)(\d+)?$)/u',
        ];
        return $rules;
    }
    public static function getValidationeconomicID()
    {
        $rules = [
            'economicID' => 'regex:/(^([0-9۰-۹]+)(\d+)?$)/u',
        ];
        return $rules;
    }
    public static function getValidationSearchDateFrom()
    {
        $rules = [
            'date_from' => 'date',
        ];
        return $rules;
    }
    public static function getValidationSearchDateTo()
    {
        $rules = [
            'date_to' => 'date',
        ];
        return $rules;
    }
    public static function getValidationFullTextSearch()
    {
        $rules = [
            'term' => 'required|not_regex:/([<>])/',
        ];
        return $rules;
    }

}
