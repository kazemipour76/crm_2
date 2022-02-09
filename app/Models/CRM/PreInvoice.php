<?php


namespace App\Models\CRM;


use App\Casts\Jalali;
use App\Models\BaseModel;
use App\Traits\FullTextSearch;
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
 * @property string|null $description
 * @property string|null $title
 * @property string|null $date
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreInvoice search($term)
 */
class PreInvoice extends BaseModel
{
    use FullTextSearch;

    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;
    const STATUS_FACTOR_SHODEH = 3;

    const  TYPE_RASMI = 1;
    const  TYPE_GHEYRE_RASMI = 0;


    protected $table = 'pre_invoices';
    protected $searchable = ['description','title'];
    protected $fillable = [
        'type',
        'customer_id',
//        'total_discount',
        'date',
        'description',
        'title',
//        'pre_invoice_id',
//        'date',
    ];

    protected $casts = [
//        'updated_at' => Jalali::class . ':time',
//        'created_at' => Jalali::class . ':time',
    ];

    public function details()
    {
        return $this->hasMany(PreInvoiceDetail::class, 'pre_invoice_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'pre_invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function totalPriceAll()
    {
        return $this->details()
            ->selectRaw('SUM(count*unit_price) as total_price')
            ->first()->total_price;
    }

    public function totalPrice()
    {
        return $this->details()
            ->selectRaw('(count*unit_price) as total_price')->get();
    }

    public static function getValidationPreInvoice($idEdit = false, $id = null)
    {

        $rules = [

            'date' => 'required|date',
            'total_discount' => 'nullable|regex:/(^([0-9,۰-۹]+)(\d+)?$)/u',
            'perInvoiceTitle' => 'numeric|max:255'

        ];

        return $rules;
    }
    public static function getValidationSearchTitle()
    {
        $rules = [
            'title' => 'regex:/(^([a-zA-zآ-ی]+)(\d+)?$)/u',
        ];
        return $rules;
    }
    public static function getValidationSearchNumber()
    {
        $rules = [
            'perInvoiceNumber' => 'numeric',
        ];
        return $rules;
    }
    public static function getValidationeconomicID()
    {
        $rules = [
            'economicID' => 'numeric',
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
            'term' => 'regex:/(^([a-zA-z0-9,۰-۹آ-ی]+)(\d+)?$)/u',
        ];
        return $rules;
    }

}
