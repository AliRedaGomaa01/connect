<?php
    // // testing
    // return response()->json('test');
    // // validation process
    // $rules = [
    //     'category' => ['required','string','max:255'],
    //     'title' => ['required','string','max:255'],
    //     'description' => ['required','string','max:2047'],
    //     'url' => ['required','string', 'url:http,https' ,'max:255'],
    // ];
    // $validator = Validator::make($request->all(), $rules);
    // if ($validator->fails()) {
    //     $errors =  $validator->errors();
    //     $data= [
    //         'status' => false,
    //         'errors' => $errors
    //     ];
    //     return response()->json($data) ;
    // }
    // $validated = $validator->safe()->all();

    // // return response
    // $data= [
    //     'status' => true,
    //     'data' => compact('') 
    // ];
    // return response()->json($data);