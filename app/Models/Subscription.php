<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    // Właściwości dla tabeli subskrypcji
    protected $fillable = [
        'user_id',
        'price',
        'status',
        'start_date',
        'end_date',
    ];

    // Relacja z modelem User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Przykładowa metoda do sprawdzania, czy subskrypcja jest aktywna
    public function isActive(): bool
    {
        $today = now();
        return $this->status === 'active' && $today->between($this->start_date, $this->end_date);
    }

    // Przykładowa metoda do przedłużania subskrypcji
    public function extendSubscription($additionalDays): void
    {
        if ($this->isActive()) {
            $this->end_date = $this->end_date->addDays($additionalDays);
            $this->save();
        }
    }

    // Przykładowa metoda do anulowania subskrypcji
    public function cancelSubscription(): void
    {
        $this->status = 'cancelled';
        $this->save();
    }
}
