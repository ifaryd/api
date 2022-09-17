<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use App\Models\Langue;
use App\Models\Ville;
use App\Models\Assemblee;
use App\Models\User;
use App\Models\Charge;
use App\Models\Chantre;
use App\Models\Ministre;
use App\Models\Dirigeant;
use App\Models\Cantique;
use App\Models\Predication;
use App\Models\Verset;
use App\Models\Concordance;
use App\Models\Temoignage;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Type;
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

    // $pays = $this->mergePays();
    // $villes = $this->mergeVilles();
    // $chantres = $this->mergeCharges('Chantre');
    // $ministres = $this->mergeCharges('Ministre');
    // $assemblees = $this->mergeAssemblees();
    // $cantiques = $this->mergeCantiques();
   // $predications = $this->mergePredication("Français", "fr-fr", "France", "fr", true);
    $temoignages =  $this->mergeTemoignages("fr-fr");
    $photos = $this->mergePhotos("fr-fr");
    $videos = $this->mergeVideos("fr-fr");
    return $videos;
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

private function mergePredication($libelle_langue, $initial_langue, $nom_pays, $sigle_pays, $principal){

    $pays = Pays::firstOrCreate(
        ['sigle' =>  strtoupper($sigle_pays)],
        ['nom' =>  $nom_pays, 'sigle' =>  strtoupper($sigle_pays)]
    );

    $langue = Langue::firstOrCreate(
        ['libelle' =>  $libelle_langue],
        ['libelle' =>  $libelle_langue, 'initial' =>  $initial_langue]
    );

    $pays->langues()->sync([$langue->id => ['principal' => $principal]]);

    $dataModel = new Predication;
    $predications = $dataModel::on('sqlite')->withTrashed()->get();

    foreach ($predications as $key => $predication){
        $duree = str_replace("mn ", ",", $predication->duree);
        $duree = str_replace("s", ",", $duree);
        $duree = str_replace("h ", ",", $duree);

        $duree = explode(",", $duree);
        
        if(isset($duree) && isset($duree[2]) && (int)$duree[2] > 1){
            $duree = ((int)$duree[0] * 3600) + ((int)$duree[1] * 60) + (int)$duree[2];
        }
        if(isset($duree) && isset($duree[2]) &&  (int)$duree[2] == 0){
            $duree = (int)$duree[0] * 60 + (int)$duree[1];
        }

        $predication = Predication::updateOrCreate(
            ['titre' =>  $predication->titre],
            [
            'sous_titre' => $predication->sous_titre,
            'numero' => $predication->numero, 
            'lien_audio'=>$predication->lien_audio,
            "nom_audio"=>$predication->nom_audio,
            "lien_video"=>$predication->lien_video,
            "duree"=> $duree,
            "chapitre"=>$predication->chapitre,
            "couverture"=>"",
            "sermon_similaire"=>$predication->similar_sermon,
            "langue_id"=>$langue->id,
            ]
        );
        $versets = Verset::on('sqlite')->where("num_pred", $predication->numero)->withTrashed()->get();

        if(isset($versets) && !empty($versets) && !empty($predication->id)){

            foreach ($versets as $verset){

                if(isset($verset) && !empty($verset->numero) && !empty($verset->contenu)){
                    
                    $verset = Verset::updateOrCreate(
                        [
                            'contenu' =>  $verset->contenu,
                            'predication_id' =>  $predication->id
                        ],
                        [
                        'info' => $verset->info,
                        'numero' => $verset->numero,
                        ]
                    );
        
                    $concordances = Concordance::on('sqlite')
                        ->where("num_pred", $predication->numero)
                        ->where("num_verset", $verset->numero)
                        ->withTrashed()->get();
        
                    foreach($concordances as $concordance){
        
                        $concordance_verset = str_replace("[Kc.", "", $concordance->concordance);
                        $concordance_verset = str_replace("] [Kc.", "", $concordance_verset);
                        $concordance_verset = str_replace("]", "", $concordance_verset);
        
                        $concordance_verset = explode(" ", $concordance_verset);
                        foreach($concordance_verset as $verset_to){
                            $predication_num = explode("v", $verset_to)[0];

                            $predication_new = Predication::where("numero", (int)$predication_num)
                                            ->where("langue_id", $langue->id)
                                            ->first();
        
                            if(isset($predication_new) && isset($predication_new->id)){
                                $verset_to = Verset::where("predication_id", $predication_new->id)
                                                    ->withTrashed()->first();
                                if(isset($verset_to)){
                                    Concordance::updateOrCreate(
                                        ['verset_from_id' => $verset->id, 'verset_to_id' =>  $verset_to->id]
                                    );
                                }
                            }
                        }
                        
                    }
                }
    
            }
        }
        //   
    }

    return [Predication::count(), Verset::count(), Concordance::count()];
}

private function mergeTemoignages($initial_langue){

    $langue = Langue::where('initial', $initial_langue)->first();
    $temoignages = Temoignage::on('sqlite')->withTrashed()->get();

    foreach ($temoignages as $temoignage){
        Temoignage::updateOrCreate(
            ['titre' =>  $temoignage->titre],
            [
            'contenu' => $temoignage->texte,
            "langue_id"=>$langue->id,
            'lien_video' => $temoignage->lien_video,
            "photo"=>$temoignage->photo,
            ]
        );
    }

    return Temoignage::count();
}

private function mergePhotos($initial_langue){

    $langue = Langue::where('initial', $initial_langue)->first();
    $photos = Photo::on('sqlite')->withTrashed()->get();

    foreach ($photos as $photo){
        Photo::updateOrCreate(
            ['url' =>  $photo->lien],
            [
            'description' => $photo->description,
            "langue_id"=>$langue->id,
            'lieu' => $photo->lieu,
            ]
        );
    }

    return Photo::count();
}


private function mergeVideos($initial_langue){

    $langue = Langue::where('initial', $initial_langue)->first();
    $videos = Video::on('sqlite')->withTrashed()->get();

    foreach ($videos as $video){
        $type = Type::updateOrCreate(
            ['libelle' =>  $video->type],
            [
            'description' => ""
            ]
        );

        Video::updateOrCreate(
            ['url' =>  $video->lien],
            [
            'description' => $video->description,
            'titre' => $video->titre,
            "langue_id"=>$langue->id,
            'lieu' => $video->lieu,
            'type_id' => $type->id,
            ]
        );
    }

    return Video::all();
}

}
