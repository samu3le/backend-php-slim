<?php

namespace App\Http\Middleware\Validations\Requests\ProductCategoryValidation;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class State
{
    public function handle(Request $request, Closure $next)
    {
        $check_permission_admin = $request['check_permission_admin'];
        $validator = Validator::make($request['body'], [
            'id' => ['required', 'integer','exists:products_categories,id'],
            'is_active' => ['boolean'],
        ]);

        if (!$check_permission_admin) {
            $body['user_id'] = Auth::user()->id;
        }

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $request->merge([
            'body' => $validator->validated(),
        ]);

        return $next($request);
    }
}
