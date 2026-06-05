<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ModelActivityObserver
{
    public function created(Model $model): void
    {
        $this->logActivity('created', $model);
    }

    public function updated(Model $model): void
    {
        $this->logActivity('updated', $model, [
            'old' => $model->getOriginal(),
            'new' => $model->getChanges(),
        ]);
    }

    public function deleted(Model $model): void
    {
        $this->logActivity('deleted', $model);
    }

    protected function logActivity(string $action, Model $model, array $changes = []): void
    {
        Log::info('Model Activity', [
            'action' => $action,
            'model' => class_basename($model),
            'record_id' => $model->getKey(),
            'user_id' => auth()->id() ?? 'system',
            'changes' => $changes,
        ]);
    }
}