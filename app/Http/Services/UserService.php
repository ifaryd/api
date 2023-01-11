<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource as DataResource;
use App\Http\Resources\ChargeResource;
use App\Models\User as DataModel;
use Illuminate\Support\Facades\DB;
class UserService{

  public function findDataModel($id)
  {
    $data = $this->find($id);
    $data->charges = $data->charges;
    return new DataResource($data);
  }

  public function filterDataModel(Request $request){
    
    $data;
    if($request->mobile){
      $data = DataModel::all();
      return DataResource::collection($data);
    }
    if ($request->per_page){
      $data = DataModel::orderBy('id', 'desc')->paginate((int)$request->per_page);
    }
    if($request->charge && $request->charge == "chantre"){
      $data = DataModel::orderBy('id', "DESC")->whereHas('charges', function ($query){
        $query->where('libelle', '=', 'Chantre');
      })->get();
    }
    else{
      $data = DataModel::lazyById(100);
    }
    return DataResource::collection($data);
  }

  public function charges_user(){
    $data;
    $data = DB::table('charge_user')->get();
    return $data;
  }

  public function createDataModel($body){

    $user = DataModel::create($body);
    $this->charge_user($body, $user);
    return new DataResource($user);
  }

  public function updateDataModel($body, $id){

    $user = $this->find($id);
    $data = $user->update($body);
    $this->charge_user($body, $user);
    return $data;
  }

  public function deleteDataModel($id){

    $data = $this->find($id);
    return $data->delete();
  }

  public function find($id)
  {
    $data = DataModel::find($id);
    if (!$data) modelNotFound();
    return $data;
  }

  public function charge_user($data, $user){

    $position_chantre;
    $principal = false;

    if(isset($data['charge_id'])  && isset($data['pays_id']) 
        && isset($data['assemblee_id']) 
        && !empty($data['charge_id']) && !empty($data['pays_id'])
        && !empty($data['assemblee_id'])){
          if(isset($data['position_chantre']) && !empty($data['position_chantre'])){
            $position_chantre = $data['position_chantre'];
          }
          if(isset($data['principal']) && !empty($data['principal'])){
            $principal = $data['principal'];
          }
          $user->charges()->sync([
            $data['charge_id'] => [
              'assemblee_id' =>$data['assemblee_id'],
              'pays_id' =>$data['pays_id'],
              'position_chantre' =>$data['position_chantre'],
              'principal' => $principal,
            ] 
          ]);
    }
  }

}