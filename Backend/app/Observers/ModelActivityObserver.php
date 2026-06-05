<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ModelActivityObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        $this->logActivity('created', $model);
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        $this->logActivity('updated', $model, [
            'old' => $model->getOriginal(),
            'new' => $model->getChanges(),
        ]);
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->logActivity('deleted', $model);
    }

    protected function logActivity(string $action, Model $model, array $changes = [])
    {
        Log::info("Model Activity", [
            'action' => $action,
            'model' => class_basename($model),
            'record_id' => $model->getKey(),
            'user_id' => auth()->id() ?? 'system',
            'changes' => $changes,
        ]);
    }
}
