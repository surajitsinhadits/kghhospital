<?php
if (!function_exists('hospital')) {
	function hospital($tag){
		$val = App\Models\Setting::where('tag',$tag)->first()->value;
		return $val;
	}
}

if (!function_exists('dateFor')) {
    function dateFor($date,$status = false){
        if($date == null){
            return null;
        }
        if($status){
            return date('d-m-Y h:i A',strtotime($date));
        }else{
            return date('d-m-Y',strtotime($date));
        }
    }
}

if (!function_exists('timeFor')) {
    function timeFor($date){
        if($date == null){
            return null;
        }
        return date('h:i A',strtotime($date));
    }
}

if (!function_exists('ed')) {
    function ed($data, $operation) {
        if ($operation) { // Encrypt
            return base64_encode($data);
        } else { // Decrypt
            return base64_decode($data);
        }
    }
}

if (!function_exists('role')) {
    function roleName($id) {
        $val = App\Models\Role::where('id',$id)->first()->role;
        return $val;
    }
}
