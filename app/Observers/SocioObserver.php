<?php

namespace App\Observers;

use App\Models\Socio;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SocioObserver
{
    public function updated(Socio $socio): void
    {
        // Registramos qué campos cambiaron (nombre, cédula, estado, etc.)
        $changes = $socio->getChanges();
        unset($changes['updated_at']); // No nos interesa rastrear la fecha de actualización

        if (count($changes) > 0) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'editar_socio',
                'model' => 'Socio',
                'model_id' => $socio->id,
                'before' => json_encode(array_intersect_key($socio->getOriginal(), $changes)),
                'after' => json_encode($changes),
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
