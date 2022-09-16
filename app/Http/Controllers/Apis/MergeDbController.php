<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use App\Models\Ville;
use App\Models\Assemblee;
use App\Models\User;
use App\Models\Charge;
use App\Models\Chantre;
use App\Models\Ministre;
use App\Models\Dirigeant;
use App\Models\Cantique;
use Illuminate\Support\Facades\DB;

class MergeDbController extends Controller
{

/**
 * merge existing data from sqlite db into mysqldb.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function merges()
{

    $pays = $this->mergePays();
    $villes = $this->mergeVilles();
    $chantres = $this->mergeCharges('Chantre');
    $ministres = $this->mergeCharges('Ministre');
    $assemblees = $this->mergeAssemblees();
    $cantiques = $this->mergeCantiques();
    return $cantiques;
}

private function mergePays(){

    $dataModel = new Pays;
    $dataFromLites = $dataModel::on('sqlite')->withTrashed()->get();

    foreach ($dataFromLites as $key => $value){
        $dataModel::firstOrCreate(
            ['nom' =>  $value->nom, 'sigle' =>  $value->sigle],
            ['nom' =>  $value->nom, 'sigle' =>  $value->sigle]
        );
    }

    return $dataModel->all();
    
}

private function mergeVilles(){

    $dataModel = new Ville;
    $dataFromLites = $dataModel::on('sqlite')->withTrashed()->get();

    foreach ($dataFromLites as $key => $value){
        $pays = Pays::where("sigle", $value->sigle_pays)->first();
        if($pays && $pays->id){
            $dataModel::firstOrCreate(
                ['libelle' =>  $value->nom, 'pays_id' =>  $pays->id],
                ['libelle' =>  $value->nom, 'pays_id' =>  $pays->id]
            );
        }  
    }

    return $dataModel->all();
    
}

private function mergeCharges($charge_value){

    $dataModel = new Charge;
    $chantreModel = new Chantre;
    $ministreModel = new Ministre;
    $country_name = '';
    $country_id; 

    $charge = $dataModel::firstOrCreate(
        ['libelle' =>  $charge_value],
        ['libelle' =>  $charge_value]
    );

    if ($charge_value === "Chantre"){

        $chantres = $chantreModel::on('sqlite')->get();
        foreach($chantres as $chantre){
            $explode_nom = explode(" (", $chantre->nom);
            $first_name = $explode_nom[0];
            $user = User::firstOrCreate(
                ['first_name' =>  $first_name],
                ['first_name' =>  $first_name, 'last_name' =>  '']
            );

            if($explode_nom && isset($explode_nom[1])){
                $country_name = explode(")", $explode_nom[1])[0];
                $pays = Pays::where('nom',$country_name)->first();
                $country_id = $pays && $pays->id;
            }
            
            $charge_user = DB::table('charge_users')
                ->where('charge_id', $charge->id)
                ->where('user_id', $user->id)
                ->first();
            
            if(!isset($charge_user)){
                $data = [
                'charge_id' => $charge->id, 
                'user_id' => $user->id,
                "principal" => false
                ];
                if(isset($country_id) && !empty($country_id)){
                    $data["pays_id"] = $country_id;
                }
                DB::table('charge_users')->insert($data);
            }
        }

        
    }

    if($charge_value === "Ministre"){

        $ministres = $ministreModel::on('sqlite')->get();

        foreach($ministres as $ministre){
            $user = User::updateOrCreate(
                ['first_name' =>  $ministre->nom],
            
                ['last_name' => '', 
                'telephone'=> $ministre->tel1 .'/'. $ministre->tel2,
                'email'=>$ministre->email,
                "facebook"=>$ministre->page_facebook,
                "youtube"=>$ministre->page_youtube,
                ]
            );

            $apotre = $dataModel::firstOrCreate(
                ['libelle' =>  "Apotre"],
                ['libelle' =>  "Apotre"]
            );

            $pays = Pays::where('sigle',$ministre->sigle_pays)->first();

            $charge_user = DB::table('charge_users')
                ->where('charge_id', $charge->id)
                ->where('user_id', $user->id)
                ->where('pays_id', $pays->id)
                ->first();
            
            if(!isset($charge_user)){
                $data = [
                'charge_id' => $charge->id, 
                'user_id' => $user->id,
                "principal" => false
                ];
                if(isset($pays->id) && !empty($pays->id)){
                    $data["pays_id"] = $pays->id;
                }
                DB::table('charge_users')->insert($data);

                $data = [
                'charge_id' => $apotre->id, 
                'user_id' => $user->id,
                "principal" => false
                ];
                if(isset($pays->id) && !empty($pays->id)){
                    $data["pays_id"] = $pays->id;
                }
                DB::table('charge_users')->insert($data);
            }
        }
        
    }

    return [count(User::all()), Charge::all(), count(DB::table('charge_users')->get())];
    
}

private function mergeAssemblees(){

    $dataModel = new Assemblee;
    $paysModel = new Pays;
    $assemblees = $dataModel::on('sqlite')->withTrashed()->get();

    foreach ($assemblees as $key => $assemblee){
        $dirigeantLite = Dirigeant::on('sqlite')->where('numero', $assemblee->num_dirigeant)->first();
        $villeLite = Ville::on('sqlite')->where('numero', $assemblee->num_ville)->withTrashed()->first();
        $ville = Ville::where("libelle", $villeLite->nom)->first();
        $pays_id = $ville->pays_id;

        $user = User::updateOrCreate(
            ['first_name' =>  $dirigeantLite->nom],
            ['last_name' => '', 
            'telephone'=> $dirigeantLite->tel1 .'/'. $dirigeantLite->tel2,
            'email'=>$dirigeantLite->email,
            "facebook"=>$dirigeantLite->page_facebook,
            "youtube"=>$dirigeantLite->page_youtube,
            ]
        );

        $dirigeant = Charge::firstOrCreate(
            ['libelle' =>  "Dirigeant"],
            ['libelle' =>  "Dirigeant"]
        );

        if(isset($pays_id) && !empty($pays_id)){
            $assemble = $dataModel::firstOrCreate(
                ['nom' =>  $assemblee->nom, 'ville_id' =>  $ville->id],
                [
                'nom' =>  $assemblee->nom, 
                'ville_id' =>  $ville->id,
                'localisation' =>  $assemblee->gps,
                'addresse' =>  $assemblee->situation,
                'photo' =>  ""
                ]
            );

            $data = [
                'charge_id' => $dirigeant->id, 
                'user_id' => $user->id,
                "principal" => true,
                "pays_id" => $pays_id,
                "assemblee_id" => $assemble->id
            ];
            DB::table('charge_users')->insert($data);
        }  
    }

    // return [$dataModel->first(), Ville::find(56),
    // DB::table('charge_users')->where("assemblee_id", 1)->first(), User::find(71), Pays::find(18)];
    
}

private function mergeCantiques(){

    $dataModel = new Cantique;
    $cantiques = $dataModel::on('sqlite')->withTrashed()->get();

    foreach ($cantiques as $key => $cantique){

        $chantre = Chantre::on('sqlite')->where("numero", $cantique->num_chantre)->first();
        $explode_nom = explode(" (", $chantre->nom);
        $first_name = $explode_nom[0];
        $user = User::where("first_name", $first_name)->first();
        $dataModel::firstOrCreate(
            ['titre' =>  $cantique->titre, 'lien_audio' =>  $cantique->lien_audio],
            [
            'titre' =>  $cantique->titre,
            'lien_audio' =>  $cantique->lien_audio,
            "nom_fichier" =>  $cantique->file_name,
            "duree" =>  $cantique->duration,
            "contenu" =>  $cantique->paroles,
            "user_id" =>  $user->id
            ]
        ); 
    }

    return $dataModel->all();
    
}

}
