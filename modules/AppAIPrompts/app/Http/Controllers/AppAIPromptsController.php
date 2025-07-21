<?php

namespace Modules\AppAIPrompts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\Paginator;
use DB;

class AppAIPromptsController extends Controller
{

    public function __construct()
    {
        $this->table = "ai_prompts";
    }

    public function list(Request $request){
        $wheres = ["team_id" => $request->team_id ];

        $query = DB::table( $this->table )->where($wheres);

        $result = $query->orderByDesc('id')->paginate(3000);

        ms([
            "status" => 1,
            "data" => view('appaiprompts::list',[
                "result" => $result
            ])->render()
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $result = DB::table( $this->table )->where("id_secure", $id)->first();

        ms([
            "status" => 1,
            "data" => view( 'appaiprompts::update', [
                "result" => $result
            ])->render()
        ]);
    }

    public function save(Request $request)
    {
        $item = DB::table( $this->table )->where('id_secure', $request->id)->first();

        $validator_arr = [
            'prompt' => 'required'
        ];

        if($item){
            $validator_arr['prompt'] = [
                "required",
                Rule::unique($this->table)->ignore($item->id),
            ];
        }

        $validator = Validator::make($request->all(), $validator_arr);

        if ($validator->passes()) {
            $values = [
                'prompt' => $request->input('prompt')
            ];

            if($item){
                DB::table( $this->table )->where("id", $item->id)->update($values);
            }else{
                $values['team_id'] = $request->team_id;
                $values['id_secure'] = rand_string();
                DB::table( $this->table )->insert($values);
            }
            
            ms(["status" => 1, "message" => "Succeed"]);
        }

        return ms([ 
            "status" => 0, 
            "message" => $validator->errors()->all()[0], 
        ]);
    }

    public function destroy(Request $request)
    {
        $id_arr = id_arr( $request->input('id') );
        if(empty($id_arr))
              ms(["status" => 0, "message" => __("Please select at least one item")]);

        DB::table( $this->table )->whereIn('id_secure', $id_arr)->delete();
        ms(["status" => 1, "message" => __("Succeed")]);
    }

}
