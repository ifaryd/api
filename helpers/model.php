<?php
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

function modelNotFound(){
  throw new HttpResponseException(response()->json(['message' => 'Model not found'], 404));
}
