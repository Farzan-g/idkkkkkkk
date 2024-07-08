<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 *     title="My Awesome API",
 *     version="1.0.0",
 *     description="This is a description of your API.",
 * )
 */
class FirstController extends Controller
{

    // -----------simple get example-----------

    /**
     * @OA\Get(
     *     path="/api/test/get",
     *     summary="Example endpoint",
     *     description="Example endpoint description",
     *     tags={"Example"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="string", example="This is an example endpoint")
     *         )
     *     )
     * )
     */
    public function example()
    {
        return response()->json(['data' => 'This is an example endpoint']);
    }

    // -----------index for get all-----------

    /**
     * @OA\Get(
     *     path="/api/test",
     *     summary="Get all items",
     *     tags={"Item"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="tests", type="string", example="Test content"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01T00:00:00Z")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $items = Test::all();
        return response()->json($items);
    }

    // -----------get one by id-----------

    /**
     * @OA\Get(
     *     path="/api/test/show/{id}",
     *     summary="Get item by ID",
     *     tags={"Item"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="tests", type="string", example="Test content"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Item not found")
     * )
     */
    public function show($id)
    {
        $item = Test::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }

    // -----------post to db-----------

    /**
     * @OA\Post(
     *     path="/api/test/create",
     *     summary="Create new item",
     *     tags={"Item"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tests", type="string", example="Test content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="tests", type="string", example="Test content"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01T00:00:00Z")
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        // Assuming you have a model named Item
        // $item = Test::create($request->all());
        $item = new Test();
        $item->tests = $request->input('tests');
        $item->save();

        return response()->json($item, 201);
    }

    // -----------put to edit-----------

    /**
     * @OA\Put(
     *     path="/api/test/update/{id}",
     *     summary="Update item",
     *     description="Updates an existing item.",
     *     tags={"Item"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tests", type="string", example="Updated Name"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="tests", type="string", example="Updated Name"),
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $item = Test::findOrFail($id);
        $item->update($request->all());

        return response()->json($item);
    }

    // -----------delete item from db-----------

    /**
     * @OA\Delete(
     *     path="/api/test/delete/{id}",
     *     summary="Delete item",
     *     tags={"Item"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function delete($id)
    {
        Test::destroy($id);

        return response()->json(null, 204);
    }

    // -----------show last id-----------

    /**
     * @OA\Get(
     *     path="/api/test/last",
     *     summary="Get last item",
     *     tags={"Item"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="tests", type="string", example="Test content"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01T00:00:00Z")
     *         )
     *     )
     * )
     */
    public function lastId()
    {
        $items = DB::table('tests')->latest('id')->first();
        return response()->json($items);
    }

}
