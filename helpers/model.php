<?php
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User;

function modelNotFound(){
  throw new HttpResponseException(response()->json(['message' => 'Model not found'], 404));
}

function paginate(Collection $results, $pageSize){
  $page = Paginator::resolveCurrentPage('page');
        
    $total = $results->count();

    return paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
      'path' => Paginator::resolveCurrentPath(),
      'pageName' => 'page',
    ]);
}

function paginator($items, $total, $perPage, $currentPage, $options){
    return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
        'items', 'total', 'perPage', 'currentPage', 'options'
    ));
}

function dirigeantAssemblee($assemblee_id){
  $userId = DB::table('charge_user')
    ->where("assemblee_id", $assemblee_id)
    ->where("principal", 1)
    ->first();
    return $user = User::find($userId->user_id);
}