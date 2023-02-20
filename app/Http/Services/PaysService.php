<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\PaysResource as DataResource;
use App\Models\Pays as DataModel;
use Illuminate\Support\Facades\DB;
use App\Models\Ville;
use App\Models\Confirme;

class PaysService
{

  public function findDataModel($id)
  {
    $data = DataModel::where('id', $id)->orWhere('nom', $id)->orWhere('sigle', $id)->first();
    if (!$data) return $data;
    return new DataResource($data);
  }

  public function filterDataModel(Request $request)
  {
    $data;
    if($request->mobile){
      $data = DataModel::all();
      return DataResource::collection($data);
    }
    if ($request->per_page) {
      $data = DataModel::with('langues')->orderBy('id', 'desc')->paginate((int)$request->per_page);
    }
    if($request->has("villes")){
      $data = DataModel::with(['langues', "villes"])->get();
    }
    else {
      $data = DataModel::with('langues')->get();
    }
    return DataResource::collection($data);
  }

  public function createDataModel($body)
  {

    $data = DataModel::create($body);
    $this->langue_pays($body, $data);
    return new DataResource($data);
  }

  public function updateDataModel($body, $id)
  {

    $data = $this->find($id);
    $dataUpdated = $data->update($body);
    $this->langue_pays($body, $data);

    return $dataUpdated;
  }

  //confirmes charge_user villes langue_pays
  public function deleteDataModel($id)
  {

    $confirme = Confirme::where('pays_id', $id)->first();
    $ville = Ville::where('pays_id', $id)->first();
    $charge_user = DB::table('charge_user')->where('pays_id', $id)->first();

    if(!isset($confirme) && !isset($langue_pays) && !isset($charge_user)){
      $data = $this->find($id);
      if(isset($data)){
        DB::table('langue_pays')->where('pays_id', $id)->delete();
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

    $principal = true;
    if(isset($body['principal']) && !empty($body['principal'])){
      $principal = $body['principal'];
    }
    if(isset($body['langue_id'])){
      $data->langues()->sync([$body['langue_id'] => ['principal' => $principal]]);
    }

  }
}
