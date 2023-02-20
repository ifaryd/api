<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\LangueResource as DataResource;
use App\Models\Langue as DataModel;
use App\Models\Confirme;
use App\Models\Predication;
use App\Models\Cantique;
use App\Models\Actualite;
use App\Models\Temoignage;
use App\Models\Video;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;

class LangueService{

    public function findDataModel($id)
    {
      $data = DataModel::where('id', $id)->orWhere('initial', $id)->orWhere('libelle', $id)->first();
      if (!$data) return $data;
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
      if($request->pays){
        $data = DataModel::with("pays")->lazyById(100);
      }
      else{
        $data = DataModel::lazyById(100);
      }
      return DataResource::collection($data);
    }
  
    public function createDataModel($body){
  
      $data = DataModel::create($body);
      $this->langue_pays($body, $data);
      return new DataResource($data);
    }
  
    public function updateDataModel($body, $id){

      $data = $this->find($id);
      $dataUpdated = $data->update($body);
      return $this->langue_pays($body, $data);

      return $dataUpdated;
    }

    public function deleteDataModel($id){
  
      $confirme = Confirme::where('langue_id', $id)->first();
      $predication = Predication::where('langue_id', $id)->first();
      $cantique = Cantique::where('langue_id', $id)->first();

      $actualite = Actualite::where('langue_id', $id)->first();
      $temoignage = Temoignage::where('langue_id', $id)->first();
      $video = Video::where('langue_id', $id)->first();
      $photo = Photo::where('langue_id', $id)->first();

      if(!isset($confirme) && !isset($predication) && !isset($cantique) &&
      !isset($actualite) && !isset($temoignage) && !isset($video) && !isset($photo)){
        $data = $this->find($id);
        if(isset($data)){
          DB::table('langue_pays')->where('langue_id', $id)->delete();
          return $data->delete();
        }
      }else{
        return 0;
      }

    }
  
    public function find($id)
    {
      $data = DataModel::find($id);
      if (!$data) modelNotFound();
      return $data;
    }

    public function langue_pays($body, $data){

      $principal = false;
      if(isset($body['principal']) && !empty($body['principal'])){
        $principal = $body['principal'];
      }
      if (isset($body['pays_id']) && !empty($body['pays_id'])){
        $data->pays()->attach([$body['pays_id'] => ['principal' => $principal]]);
      }
    }
}