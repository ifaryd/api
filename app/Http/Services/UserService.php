<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
//use \Throwable;

class UserService{

  public function findUserModel($id)
  {
    $user = $this->find($id);
    return new UserResource($user);
  }

  public function filterUserModel(Request $request){
    
    $users;
    if ($request->per_page){
      $users = User::orderBy('id', 'desc')->paginate((int)$request->per_page);
    }
    else{
      $users = User::lazyById(100);
    }
    return UserResource::collection($users);
  }

  public function createUserModel($user){

    $user = User::create($user);
    return new UserResource($user);
  }

  public function updateUserModel($data, $id){

    $user = $this->find($id);
    return $user->update($data);
  }

  public function deleteUserModel($id){

    $user = $this->find($id);
    return $user->delete();
  }

  public function find($id)
  {
    $user = User::find($id);
    if (!$user) modelNotFound();
    return $user;
  }

}