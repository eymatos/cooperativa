<?php

namespace App\Observers;

use App\Models\Prestamo;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PrestamoObserver
{
    public function created(Prestamo $prestamo): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'crear',
            'model' => 'Prestamo',
            'model_id' => $prestamo->id,
            'after' => $prestamo->toJson(),
            'ip_address' => request()->ip(),
        ]);
    }

    public function updated(Prestamo $prestamo): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'editar',
            'model' => 'Prestamo',
            'model_id' => $prestamo->id,
            'before' => json_encode($prestamo->getOriginal()),
            'after' => $prestamo->toJson(),
            'ip_address' => request()->ip(),
        ]);
    }

    public function deleted(Prestamo $prestamo): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'eliminar',
            'model' => 'Prestamo',
            'model_id' => $prestamo->id,
            'before' => $prestamo->toJson(),
            'ip_address' => request()->ip(),
        ]);
    }
}
