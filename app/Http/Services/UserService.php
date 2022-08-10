<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserService{

  public function findUserModel($id)
  {
    $user = User::find($id);
    if (!$user) return modelNotFound();
    return new UserResource($user);
  }

  public function filterModel(Request $request){
    
    $users;
    if ($request->per_page){
      $users = User::paginate((int)$request->per_page);
    }
    else{
      $users = User::lazyById(100);
    }

    return UserResource::collection($users);
  }

}