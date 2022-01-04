<?php


namespace App\Models\CRM;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\CRM\Customer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $economicID
 * @property string|null $nationalID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\Invoice[] $invoice
 * @property-read int|null $invoice_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\PreInvoice[] $preInvoice
 * @property-read int|null $pre_invoice_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Query\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEconomicID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNationalID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Customer withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $email
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRM\PreInvoice[] $preInvoices
 * @property-read int|null $pre_invoices_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 */
class Customer extends Model
{
//    use SoftDeletes;

    protected $table = 'customers';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'economicID',
        'nationalID',
    ];
    public static function getValidationCustomer($idEdit = false, $id = null)
    {

        $rules = [

            'name'=> 'required',
            'address'=> 'required',
            'economicID'=> 'required',
            'phone'=> 'required',
//            'nationalID'=> 'required',
//            'email' => 'required|email|not_regex:/(^([a-zA-z]+)(\d+)?$)/u|unique:users',

        ];

        return $rules;
    }

    public function preInvoices()
    {
        return $this->hasMany(PreInvoice::class,'customer_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class,'customer_id');
    }
}
