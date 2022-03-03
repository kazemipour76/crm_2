<?php

namespace App\Http\Controllers\Backend\CRM\Admin;

use App\Charts\UserChart;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Scopes\UserScope;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index($id)
    {
        if (Auth::id() == $id) {
            MessageBag::push('امکان این کار برای شما وجود ندارد');
            return redirect()->back();
        }
        $modelUser = User::findOrFail($id);
        $blockedTime = $this->createTimeJalali($modelUser->last_blocked_at);
        $loginTime = $this->createTimeJalali($modelUser->last_login_at);
        $createdTime = $this->createTimeJalali($modelUser->created_at);
//        $model = Customer::withoutGlobalScope(UserScope::class)->OrderBy('id');
        $invoiceCount = Invoice::withoutGlobalScope(UserScope::class)->where('_user_id', $id)->count();
        $preInvoiceCount = PreInvoice::withoutGlobalScope(UserScope::class)->where('_user_id', $id)->count();
        $customerCount = Customer::withoutGlobalScope(UserScope::class)->where('_user_id', $id)->count();

        $totalSumPriceInvoice = $this->resultSumPriceInvoice(Invoice::withoutGlobalScope(UserScope::class)->where('_user_id', $id)->get()->pluck('id'));
        $totalSumPricePreInvoice = $this->resultSumPricePreInvoice(PreInvoice::withoutGlobalScope(UserScope::class)->where('_user_id', $id)->get()->pluck('id'));
        if ($totalSumPricePreInvoice !== 0) {
            $nerkhTabdil = ($totalSumPriceInvoice / $totalSumPricePreInvoice) * 100;
        } else {
            $nerkhTabdil = 0;
        }

        $data = [
            'modelUser' => $modelUser,
            'invoiceCount' => $invoiceCount,
            'preInvoiceCount' => $preInvoiceCount,
            'customerCount' => $customerCount,
            'nerkhTabdil' => $nerkhTabdil,
            'totalSumPriceInvoice' => $totalSumPriceInvoice,
            'totalSumPricePreInvoice' => $totalSumPricePreInvoice,
            'blockedTime' => $blockedTime,
            'loginTime' => $loginTime,
            'createdTime' => $createdTime,
        ];

        session(['id' => $id]);

        return view('backend.user.showDetail', $data);
    }

    public function createTimeJalali($dateTime)
    {
        if ($dateTime !== null) {

            $date = explode(' ', $dateTime);
            $time = explode(':', $date[1]);
            $t = mktime($time[0], $time[1], $time[2]);
            $t = Jdf::jdate("H:i", $t);
            $dayNumber = date('w', strtotime($date[0]));
            $dayName = Jdf::jdate_words(array('rh' => $dayNumber), '|');
            $data1 = explode('-', $date[0]);
            $gdate = Jdf::gregorian_to_jalali($data1[0], $data1[1], $data1[2], '-');
            return $t . ' ' . $gdate . ' ' . $dayName;

        } else {
            return 'این رویداد وجود ندارد';
        }
    }

    public function resultSumPriceInvoice($invoiceId)
    {
        if ($invoiceId !== null) {
            $totalSum = InvoiceDetail::whereIn('invoice_id', $invoiceId)
                ->selectRaw('SUM(count*unit_price) as total_price')
                ->pluck('total_price')->toArray();
            $totalSum = implode($totalSum);
            if ($totalSum) {
                return $totalSum;
            }
            return 0;

        }
        return 0;
    }

    public function resultSumPricePreInvoice($invoiceId)
    {
        if ($invoiceId !== null) {
            $totalSum = PreInvoiceDetail::whereIn('pre_invoice_id', $invoiceId)
                ->selectRaw('SUM(count*unit_price) as total_price')
                ->pluck('total_price')->toArray();
            $totalSum = implode($totalSum);
            if ($totalSum) {
                return $totalSum;
            }
            return 0;

        }
        return 0;
    }


}
