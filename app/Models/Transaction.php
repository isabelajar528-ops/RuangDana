<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'savings_goal_id',
        'type',
        'amount',
        'category',
        'description',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function savingsGoal()
    {
        return $this->belongsTo(SavingsGoal::class);
    }
}