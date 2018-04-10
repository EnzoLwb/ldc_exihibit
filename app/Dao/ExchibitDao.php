<?php

namespace App\Dao;

use App\Models\CollectExhibit;
use App\Models\Exhibit;
use Illuminate\Database\Eloquent\Model;
use App\Models\CollectRecipe;
use Illuminate\Support\Facades\DB;
use App\Models\FakeExhibit;

class ExchibitDao extends Exhibit
{
    /**
     * 从collectrecipe中复制到fake_exhibit
     * @param CollectRecipe $recipe
     */
    public static function CopyRecipe2Exhibit( $recipe_id){

        DB::transaction(function () use ($recipe_id) {
            $recipe_model = CollectRecipe::find($recipe_id);
            $recipe_model->status = ConstDao::EXHIBIT_COLLECT_RECIPE_STATUS_SUBMITED;
            $recipe_model->save();
            if(empty($recipe_model))return;
            $collect_exhibit = CollectExhibit::where('collect_recipe_id',$recipe_id)->get();
            foreach($collect_exhibit as $recipe){
                $exhibit = new FakeExhibit();
                $exhibit->collect_recipe_id = $recipe_id;
                $exhibit->exhibit_sum_register_num = $recipe->exhibit_sum_register_num;
                $exhibit->type_num = $recipe->type_num;
                $exhibit->name = $recipe->name;
                $exhibit->type = $recipe->type;
                $exhibit->age = $recipe->age;
                $exhibit->num = $recipe->num;
                $exhibit->num_uint = $recipe->num_uint;
                $exhibit->lwh = $recipe->lwh;
                $exhibit->quality = $recipe->quality;
                $exhibit->complete_degree = $recipe->complete_degree;
                $exhibit->collect_recipe_num = $recipe_model->collect_recipe_num;
                $exhibit->in_museum_time = $recipe_model->collect_date;
                $exhibit->exhibit_level = $recipe->exhibit_level;
                $exhibit->type_order_num = $recipe->type_order_num;
                $exhibit->rubbing_num = $recipe->rubbing_num;
                $exhibit->recipe_num = $recipe_model->recipe_num;
                $exhibit->baseboard_num = $recipe->baseboard_num;
                $exhibit->files = $recipe->files;
                $exhibit->audit_status = ConstDao::FAKE_EXHIBIT_STATUS_DRAFT;
                //等待审核
                $exhibit->status = ConstDao::FAKE_EXHIBIT_STATUS_DRAFT;
                $exhibit->save();
            }
        });
    }


    public static function copyFakeExhibit2Exhibit($fake_exhibit_sum_register_id){
        $fake_exhibit_sum_registe = FakeExhibit::find($fake_exhibit_sum_register_id);
        if(empty($fake_exhibit_sum_registe)){
            return;
        }
        $exhibit = new Exhibit();
        $properties = $fake_exhibit_sum_registe->toArray();
        $except = array('audit_status','fake_exhibit_sum_register_id');
        foreach($properties as $key=>$v){
            if(!in_array($key, $except)){
                $exhibit->$key = $v;
            }
        }
        $exhibit->save();
        return;
    }
}