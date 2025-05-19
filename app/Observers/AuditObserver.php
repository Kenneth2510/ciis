<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditObserver
{
    
    public function created(Model $model)
    {
        $this->logActivity($model, 'CREATED');
    }

    public function updated(Model $model)
    {
        $this->logActivity($model, 'UPDATED', $model->getOriginal());
    }

    public function deleted(Model $model)
    {
        $this->logActivity($model, 'DELETED', $model->getOriginal());
    }

    private function logActivity(Model $model, string $event, array $oldData = [])
    {
        if (Auth::user()) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'event' => $event,
                'model' => get_class($model),
                'old_data' => $event === 'CREATED' ? null : json_encode($oldData),
                'new_data' => $event === 'DELETED' ? null : json_encode($model->getAttributes()),
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);

            // Log::info("{$event} - {get_class($model)}", ['user_id' => Auth::id(), 'old_data' => json_encode($oldData) , 'new_data' => json_encode($model->getAttributes())]);

        }

    }
}
