<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DepositStoreRequest;
use App\Http\Requests\WithdrawalStoreRequest;

class TransactionController extends Controller
{
    public function transactions ()
    {
        $data['transactions'] = Transaction::where('user_id', auth()->id())->get();
        return view('show-transactions', $data);
    }

    public function deposits ()
    {
        $data['transactions'] = Transaction::where('user_id', auth()->id())
            ->where('transaction_type',DEPOSIT)
            ->get();
        return view('show-deposits', $data);
    }

    public function depositsStore (DepositStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $updateBalance = auth()->user()->update([
                'balance' => auth()->user()->balance + $request->get('amount')
            ]);
            if (!$updateBalance) {
                throw new Exception('Package is not active.');
            }

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->get('amount'),
                'transaction_type' => DEPOSIT,
                'date' => now(),
            ]);
            if (!$transaction) {
                throw new Exception('Package is not active.');
            }
            DB::commit();
        } catch (Exception $ex) {
            logs()->error($ex);
            return redirect()->back()->with(RESPONSE_TYPE_WARNING, __('Failed to deposit'));
        }

        return redirect()->route('deposits')->with(RESPONSE_TYPE_SUCCESS, __('Deposit Successfully.'));
    }

    public function withdrawals ()
    {
        $data['transactions'] = Transaction::where('user_id', auth()->id())
            ->where('transaction_type', WITHDRAWAL)
            ->get();
        return view('show-withdrawals', $data);
    }

    public function withdrawalStore(WithdrawalStoreRequest $request)
    {

        $withdrawalFee = 0;
        $amount = $request->get('amount');
        if ($amount > auth()->user()->balance) {
            return redirect()->back()->with(RESPONSE_TYPE_WARNING, __('Unsuppensed Balance'));
        }

        try {
            DB::beginTransaction();

            if (auth()->user()->account_type == INDIVIDUAL_ACCOUNT && !Carbon::now()->isFriday()) {
                $withdrawalFee = $this->calculateFeeForIndividual($amount);
            }

            if (auth()->user()->account_type == BUSINESS_ACCOUNT){
                $withdrawalFee = $this->calculateFeeForBusiness($amount);
            }

            $withdrawnAmountWithFee = $request->get('amount') + $withdrawalFee;
            $updateBalance = auth()->user()->update([
                'balance' => auth()->user()->balance - $withdrawnAmountWithFee
            ]);
            if (!$updateBalance) {
                throw new Exception('Package is not active.');
            }

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->get('amount'),
                'fee' => $withdrawalFee,
                'transaction_type' => WITHDRAWAL,
                'date' => now(),
            ]);
            if (!$transaction) {
                throw new Exception('Package is not active.');
            }
            DB::commit();
        } catch (Exception $ex) {
            logs()->error($ex);
            return redirect()->back()->with(RESPONSE_TYPE_WARNING, __('Failed to withdrawal'));
        }

        return redirect()->route('withdrawals')->with(RESPONSE_TYPE_SUCCESS, __('Withdrawal Successfully.'));

    }


    private function calculateFeeForIndividual($amount)
    {
        if ($amount <= 1000) {
            return 0;
        }

        $currentMonthWithdrawals = Transaction::where('user_id', auth()->id())
            ->where('transaction_type', WITHDRAWAL)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');

        if ($currentMonthWithdrawals <= 5000) {
            return 0;
        }

        return $amount * WITHDRAWAL_INDIVIDUAL_FEE;
    }

    private function calculateFeeForBusiness($amount)
    {
        $totalWithdrawals = Transaction::where('user_id', auth()->id())
            ->where('transaction_type', WITHDRAWAL)
            ->sum('amount');

        $withdrawalFee = WITHDRAWAL_BUSINESS_FEE;
        if ($totalWithdrawals > 50000) {
            $withdrawalFee = 0.015;
        }

        return $amount * $withdrawalFee;
    }

}
