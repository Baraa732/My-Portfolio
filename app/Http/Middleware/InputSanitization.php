<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InputSanitization
{
    public function handle(Request $request, Closure $next)
    {
        // Sanitize all input data
        $input = $request->all();
        
        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                // Remove potential XSS vectors
                $value = strip_tags($value, '<p><br><strong><em><ul><ol><li>');
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                
                // Remove potential SQL injection patterns
                $value = preg_replace('/(\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|EXEC|UNION|SCRIPT)\b)/i', '', $value);
                
                // Trim whitespace
                $value = trim($value);
            }
        });
        
        // Replace the request input with sanitized data
        $request->replace($input);
        
        return $next($request);
    }
}