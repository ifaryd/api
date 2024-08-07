<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest as DataStoreRequest;
use App\Http\Services\UserService as DataService;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMatthieu25v6;
class UserController extends Controller
{
    private $dataService;
    
    function __construct(DataService $dataService){
      $this->dataService = $dataService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
      return $this->dataService->filterDataModel($request);   
    } 

    public function charges_user(){
      return $this->dataService->charges_user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataStoreRequest $request)
    {
      $body = $request->validated();
      return $this->dataService->createDataModel($body);
    }

    public function contacts(Request $request){

      $email = $request->email;
      $name = $request->name;
      $message = $request->message;
      
      Mail::to(env('ADMIN_EMAIL'))
            ->cc('frere.boga@gmail.com')
            ->bcc(env('CC_ADMIN_EMAIL'))
            ->send(new ContactMatthieu25v6($name, $message, $email));

      return response()->json([
        'success' => true,
        'message' => $request->all(),
      ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return $this->dataService->findDataModel($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DataStoreRequest $request, $id)
    {
      $body = $request->validated();
      return $this->dataService->updateDataModel($body, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      return $this->dataService->deleteDataModel($id);
    }
  
}
