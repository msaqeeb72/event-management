<?php

namespace App\Exceptions;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
class FailedValidationException extends HttpResponseException{



    public function __construct($validator){
        $errors = (new ValidationException($validator))->errors();
        $newData = [];
        foreach ($errors as $key => $value) {
            $newData[$key] = is_array($value) ? $value[0] : $value;
        }
        $response = response()->json([
            'success' => false,
            'message' => $newData[array_key_first($newData)] ?? 'Error 422',
            'errors'  => $errors
        ], 422);
        parent::__construct($response);
    }



}