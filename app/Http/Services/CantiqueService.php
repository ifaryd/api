<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\CantiqueResource as DataResource;
use App\Models\Cantique as DataModel;
use App\Models\User;

class CantiqueService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      $data->user = $data->user;
      $data->langue = $data->langue;
      return new DataResource($data);
    }

    public function filterDataModel(Request $request){
      
      $data;
      
      if($request->mobile){
        $data = DataModel::all();
        return DataResource::collection($data);
      }
      if($request->user_id){
        $data = DataModel::where('user_id', '=', $request->user_id)->with(['user', 'langue'])->get();
        if($request->per_page){
          $data = paginate($data, (int)$request->per_page);
        }
        
        return DataResource::collection($data);
      }

      $chantres = User::whereHas('charges', function ($query){
        $query->where('libelle', '=', 'Chantre');
      })->get();

      if ($request->per_page){
        $data = $chantres->each->cantiques;
        $data = paginate($data, (int)$request->per_page);
      }
      else{
        $data = $chantres->each->cantiques;
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
