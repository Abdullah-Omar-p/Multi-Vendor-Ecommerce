<?php

namespace App\Helpers;

class Helper {
    public static function responseData($message = 'success',$status = true,$data = false,$returnCode = 200,$dataWithPagination = false){
        $response = ['message' => $message,'status' => $status];
        if($data !== false){
            $response['data'] = $data;

            if($dataWithPagination){
                $paginationData = [
                    'total' => $data->total(),
                    'count' => $data->count(),
                    'per_page' => $data->perPage(),
                    'current_page' => $data->currentPage(),
                    'total_pages' => $data->lastPage(),
                ];
                $response['pagination'] = $paginationData;
            }
        }
        return response()->json($response,$returnCode);
    }

    public static function cleanArraySeperator($Items,$Seperator){
        $newArray = [];
        if(is_array($Items)){
            foreach($Items as $Item){
                $newArray[] = str_replace($Seperator,'',$Item);
            }
        }
        return $newArray;
    }


}
