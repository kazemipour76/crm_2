<?php


namespace App\Models\CRM;


use App\Models\BaseModel;
use \App\Scopes\UserScope;
use App\Traits\FullTextSearch;

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
 * @property int $_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer user()
 */
class Customer extends BaseModel
{
    CONST LEGAL=1;
    CONST NATURAL =2;
//    use SoftDeletes;
//    use UserScope;
    use FullTextSearch;

    protected $table = 'customers';
    protected $idGenerator = true;
    protected $searchable = ['economicID','nationalID','email','phone','name','address'];
    protected $fillable = [
        'name',
        'address',
        'phone',
        'economicID',
        'nationalID',
        'entity',
    ];

    public static function getValidationCustomer($idEdit = false, $id = null)
    {

        $rules = [

            'name' => 'required',
            'address' => 'required',
            'economicID' => 'numeric',
            'phone' => 'required|numeric',
            'nationalID'=> 'required|numeric',
//            'email' => 'required|email|not_regex:/(^([a-zA-z]+)(\d+)?$)/u|unique:users',

        ];

        return $rules;
    }

    public function preInvoices()
    {
        return $this->hasMany(PreInvoice::class, 'customer_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    protected static function booted()
    {


            static::addGlobalScope(new UserScope());

    }
}
