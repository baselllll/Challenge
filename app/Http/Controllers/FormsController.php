<?php

namespace App\Http\Controllers;

use App\Exports\FormsExport;
use App\Http\Services\FormBuilderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isNull;

class FormsController extends Controller
{
    public function __construct(FormBuilderService $builderService)
    {
        $this->builderService = $builderService;

    }

    public function export_answers(){
        return Excel::download(new FormsExport, 'forms.xlsx');
    }


    public function publish_form($id){
        $data = $this->builderService->publish_form($id);

        if(isset($data)){
            return response()->json([
                'status' => true,
                'message' => "success updated and added expire data and published",
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => $data,
            ], 401);
        }
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'user_id'=>'required|exists:users,id',
            'name'=>'required|string',
            'Details'=>'required|array'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 200);
        }
        $data = $this->builderService->store([
            'user_id'=>$request->user_id,
            'name'=>$request->name,
            'Details'=>$request->Details,
        ]);

        if(isset($data)){
            return response()->json([
                'status' => true,
                'message' => "success created",
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => $data,
            ], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->builderService->show($id);
        // that conditions to check the publish form
        if(!isNull($data->form_code_expire) and  $data->form_code_expire < Carbon::now()){
            return response()->json([
                'status' => true,
                'message' => "the date is expire and not share ",
                'data' => $data,
            ], 200);
        }
        if(isset($data)){
            return response()->json([
                'status' => true,
                'message' => "success created",
                'data' => $data,
            ], 200);
        }else{
            return response()->json([
                'status' => false
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator =  Validator::make($request->all(), [
            'user_id'=>'required|exists:users,id',
            'name'=>'required|string',
            'Details'=>'required|array'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 200);
        }
        $data = $this->builderService->update([
            'user_id'=>$request->user_id,
            'name'=>$request->name,
            'Details'=>$request->Details,
        ],$id);

        if(isset($data)){
            return response()->json([
                'status' => true,
                'message' => "success updated",
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => $data,
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->builderService->delete($id);
        if(isset($data)){
            return response()->json([
                'status' => true,
                'message' => "success deleted",
            ], 200);
        }else{
            return response()->json([
                'status' => false
            ], 401);
        }
    }
}
