<?php
use Illuminate\Http\Request;

function modelNotFound(){
  return response()->json(['message' => 'Model not found'], 404);
}
