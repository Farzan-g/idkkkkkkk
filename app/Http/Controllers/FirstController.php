<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

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
     *     description="Returns a list of all items.",
     *     tags={"Item"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Item")
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
     *     description="Returns a single item by ID.",
     *     tags={"Item"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
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
     *     summary="Create item",
     *     description="Creates a new item.",
     *     tags={"Item"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="test", type="string", example="Item Name"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="test", type="string", example="Item Name"),
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        // Assuming you have a model named Item
        // $item = Test::create($request->all());
        $item = new Test();
        $item->tests = $request->input('test');
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
     *             @OA\Property(property="test", type="string", example="Updated Name"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="test", type="string", example="Updated Name"),
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
     *     description="Deletes an existing item.",
     *     tags={"Item"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Item deleted"
     *     )
     * )
     */
    public function delete($id)
    {
        Test::destroy($id);

        return response()->json(null, 204);
    }
}
