<?php

namespace App\Dao;

use App\Models\CollectExhibit;
use App\Models\Exhibit;
use Illuminate\Database\Eloquent\Model;
use App\Models\CollectRecipe;
use Illuminate\Support\Facades\DB;

class ExchibitDao extends Exhibit
{
    /**
     * 从collectrecipe中复制到exhibit
     * @param CollectRecipe $recipe
     */
    public static function CopyRecipe2Exhibit( $recipe_id){
        DB::transaction(function () use ($recipe_id) {
            $recipe = CollectRecipe::find($recipe_id);
            $recipe->status = ConstDao::EXHIBIT_COLLECT_RECIPE_STATUS_SUBMITED;
            $recipe->save();
            if(empty($recipe))return;
            $collect_exhibit = CollectExhibit::where('collect_recipe_id',$recipe_id)->get();
            foreach($collect_exhibit as $recipe){
                $exhibit = new self();
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
                $exhibit->exhibit_level = $recipe->exhibit_level;
                $exhibit->type_order_num = $recipe->type_order_num;
                $exhibit->rubbing_num = $recipe->rubbing_num;
                $exhibit->baseboard_num = $recipe->baseboard_num;
                $exhibit->files = $recipe->files;
                $exhibit->save();
            }
        });
    }
}
