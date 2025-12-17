<?php

namespace App\Observers;

use App\Models\SavingsAccount;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SavingsAccountObserver
{
    public function updated(SavingsAccount $account): void
    {
        // Solo guardamos si el cambio lo hizo un usuario autenticado (Admin)
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'editar',
                'model' => 'Ahorro',
                'model_id' => $account->id,
                'before' => json_encode($account->getOriginal()), // Valores viejos
                'after' => $account->toJson(),                   // Valores nuevos
                'ip_address' => request()->ip(),
            ]);
        }
    }

    public function created(SavingsAccount $account): void
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'crear',
                'model' => 'Ahorro',
                'model_id' => $account->id,
                'after' => $account->toJson(),
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
