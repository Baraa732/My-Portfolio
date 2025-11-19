<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log($action, $description, $model = null, $properties = [])
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'properties' => $properties
        ]);
    }

    public static function logLogin($user)
    {
        self::log('login', "User {$user->name} logged in", $user);
    }

    public static function logLogout($user)
    {
        self::log('logout', "User {$user->name} logged out", $user);
    }

    public static function logCreate($model, $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?: "Created {$modelName}: " . ($model->name ?? $model->title ?? $model->id);
        self::log('create', $desc, $model);
    }

    public static function logUpdate($model, $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?: "Updated {$modelName}: " . ($model->name ?? $model->title ?? $model->id);
        self::log('update', $desc, $model);
    }

    public static function logDelete($model, $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?: "Deleted {$modelName}: " . ($model->name ?? $model->title ?? $model->id);
        self::log('delete', $desc, $model);
    }

    public static function logView($model, $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?: "Viewed {$modelName}: " . ($model->name ?? $model->title ?? $model->id);
        self::log('view', $desc, $model);
    }
}