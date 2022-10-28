<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\AssembleeResource as DataResource;
use App\Models\Assemblee as DataModel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Ville;
class AssembleeService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      return new DataResource($data);
    }
  
    public function dirigeantAssemblee($assemblee_id){
      $userId = DB::table('charge_user')
        ->where("assemblee_id", $assemblee_id)
        ->where("principal", 1)
        ->first();
        return $user = User::find($userId->user_id);
    }

    public function filterDataModel(Request $request){
      // return $dbuser = DB::table('charge_user')
      // ->where("assemblee_id", 1)
      // ->join('users', 'charge_user.user_id', '=', 'users.id')
      // ->join('charges', 'charge_user.charge_id', '=', 'charges.id')
      // ->get();
      $data;
      if ($request->per_page){
        $data = DataModel::with('ville')->orderBy('id', 'desc')->paginate((int)$request->per_page);
      }
      if ($request->ville){
        $data = DataModel::with('ville')->where("ville_id", $request->ville)->orderBy('id', 'desc')->get();
      }
      else{
        $data = DataModel::with('ville')->get();
      }
      return DataResource::collection($data);
    }
  
    public function createDataModel($body){
  
      $data = DataModel::create($body);
      return new DataResource($data);
    }
  
    public function updateDataModel($body, $id){
  
      $data = $this->find($id);
      return $data->update($body);
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

}