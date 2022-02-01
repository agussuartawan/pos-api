<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $response = [
            'title' => 'List Kategori Produk',
            'data' => $categories
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages =['name.required' => 'Kolom nama tidak boleh kosong'];
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $category = Category::create($request->all());
            $response = [
                'title' => 'Data Kategori berhasil ditambahkan',
                'data' => $category
            ];

            return response()->json($response, 201);
        } catch(QueryException $e) {
            return response()->json([
                'message' => 'Gagal ' . $e->errorInfo
            ]);
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
        $categories = Category::findOrFail($id)->get();
        $response = [
            'title' => 'List Kategori Produk',
            'data' => $categories
        ];

        return response()->json($response, 200);
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
        $messages =['name.required' => 'Kolom nama tidak boleh kosong'];
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $category = findOrFail($id)->get();
            $category->update($request->all());
            $response = [
                'title' => 'Data Kategori berhasil diubah',
                'data' => $category
            ];

            return response()->json($response, 200);
        } catch(QueryException $e) {
            return response()->json([
                'message' => 'Gagal ' . $e->errorInfo
            ]);
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
        $category = Category::findOrFail($id)->get();
        try {
            $category->delete();
            $response = [
                'title' => 'Data Kategori berhasil diubah'
            ];

            return response()->json($response, 200);
        } catch(QueryException $e) {
            return response()->json([
                'message' => 'Gagal ' . $e->errorInfo
            ]);
        }
    }
}
