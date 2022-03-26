<?php

use App\Models\Recommendation;

if (! function_exists('createLog')) {
    function createLog($model, $inputs, $log)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($model)
            ->withProperties($inputs)
            ->log($log);
    }
}

if (! function_exists('storeRecommendation')) {
    function storeRecommendation($product)
    {
        $user = auth()->user();
        $recommendation = Recommendation::where('user_id', $user->id)->where('product_id', $product->id)->get();

        if(count($recommendation) == 0) {
            Recommendation::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'score' => 1
            ]);
        } 
    }
}