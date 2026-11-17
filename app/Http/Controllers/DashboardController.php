<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = match ($request->query('tab')) {
            'transactions' => 'transactions',
            'goals' => 'goals',
            default => 'overview',
        };
        $pageTitle = match ($activeTab) {
            'transactions' => 'Transaksi',
            'goals' => 'Target tabungan',
            default => 'Ringkasan keuangan',
        };

        $totalIncome = 0;
        $totalExpense = 0;
        $balance = 0;
        $goalCount = 0;
        $goals = collect();
        $transactions = collect();

        if ($activeTab === 'overview') {
            $totalIncome = Transaction::where('type', 'income')->sum('amount');
            $totalExpense = Transaction::where('type', 'expense')->sum('amount');
            $balance = $totalIncome - $totalExpense;
            $goalCount = SavingsGoal::count();
        } elseif ($activeTab === 'transactions') {
            $goals = SavingsGoal::latest()->get();
            $transactions = Transaction::with('savingsGoal')
                ->latest('transaction_date')
                ->latest('id')
                ->take(20)
                ->get();
        } else {
            $goals = SavingsGoal::latest()->get();
        }

        return view('dashboard', compact(
            'activeTab',
            'pageTitle',
            'totalIncome',
            'totalExpense',
            'balance',
            'goalCount',
            'goals',
            'transactions'
        ));
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'savings_goal_id' => 'nullable|exists:savings_goals,id',
        ]);

        $transaction = Transaction::create($validated);

        if ($transaction->savings_goal_id) {
            $goal = SavingsGoal::find($transaction->savings_goal_id);
            if ($goal) {
                if ($transaction->type === 'income') {
                    $goal->increment('current_amount', $transaction->amount);
                } else {
                    $goal->current_amount = max(0, $goal->current_amount - $transaction->amount);
                    $goal->save();
                }
            }
        }

        return redirect()->route('dashboard', ['tab' => 'transactions'])
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    public function destroyTransaction(Transaction $transaction)
    {
        if ($transaction->savings_goal_id) {
            $goal = SavingsGoal::find($transaction->savings_goal_id);
            if ($goal) {
                if ($transaction->type === 'income') {
                    $goal->current_amount = max(0, $goal->current_amount - $transaction->amount);
                } else {
                    $goal->current_amount += $transaction->amount;
                }
                $goal->save();
            }
        }

        $transaction->delete();

        return redirect()->route('dashboard', ['tab' => 'transactions'])
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    public function storeGoal(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'nullable|numeric|min:0',
            'target_date' => 'nullable|date',
        ]);

        $validated['current_amount'] = $validated['current_amount'] ?? 0;
        SavingsGoal::create($validated);

        return redirect()->route('dashboard', ['tab' => 'goals'])
            ->with('success', 'Target tabungan berhasil ditambahkan.');
    }

    public function destroyGoal(SavingsGoal $goal)
    {
        $goal->delete();

        return redirect()->route('dashboard', ['tab' => 'goals'])
            ->with('success', 'Target tabungan berhasil dihapus.');
    }
}
