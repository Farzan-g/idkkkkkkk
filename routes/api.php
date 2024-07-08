<?php

use App\Http\Controllers\FirstController;
use App\Models\Test;
use App\Models\TestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test/get', [FirstController::class, 'example']);

Route::get('/test', [FirstController::class, 'index']);
Route::get('/test/show/{id}', [FirstController::class, 'show']);
Route::post('/test/create', [FirstController::class, 'create']);
Route::put('/test/update/{id}', [FirstController::class, 'update']);
Route::delete('/test/delete/{id}', [FirstController::class, 'delete']);


Route::get('/test/last', [FirstController::class, 'lastId']);



Route::get('/test-models', function () {
    $testModels = Test::all();
    return response()->json($testModels);
});

// Create a new test model
Route::post('/test-models', function (Request $request) {
    $request->validate([
        'tests' => 'required|string|max:255'
    ]);

    $testModel = Test::create($request->all());
    return response()->json($testModel, 201);
});

// Get a specific test model by ID
Route::get('/test-models/{id}', function ($id) {
    $testModel = Test::findOrFail($id);
    return response()->json($testModel);
});

// Update a test model by ID
Route::put('/test-models/{id}', function (Request $request, $id) {
    $request->validate([
        'tests' => 'required|string|max:255'
    ]);

    $testModel = Test::findOrFail($id);
    $testModel->update($request->all());

    return response()->json($testModel, 200);
});

// Delete a test model by ID
Route::delete('/test-models/{id}', function ($id) {
    Test::findOrFail($id)->delete();
    return response()->json(null, 204);
});