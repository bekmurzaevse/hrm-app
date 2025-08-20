<?php

use App\Http\Controllers\v1\CandidateController;
use App\Http\Controllers\v1\ClientController;
use App\Http\Controllers\v1\ProjectController;
use App\Http\Controllers\v1\InteractionController;
use App\Http\Controllers\v1\TypeController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\VacancyController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '\d+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
Route::pattern('base', '[a-zA-Z0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('username', '[a-z0-9_-]{3,16}');


Route::get('/', function () {
    return "API v1";
});

Route::prefix('candidates')->group(function () {
    Route::get('/', [CandidateController::class, 'index']);
    Route::get('/{id}', [CandidateController::class, 'show']);

    Route::post('/{id}/upload', [CandidateController::class, 'upload']);
    Route::get('/{id}/download/{fileId}', [CandidateController::class, 'download']);
    Route::post('/{id}/deleteFile/{fileId}', [CandidateController::class, 'deleteFile']);

    Route::post('/{id}/experience/create', [CandidateController::class, 'experienceCreate']);
    Route::put('/{id}/experience/update/{workId}', [CandidateController::class, 'experienceUpdate']);
    Route::delete('/experience/delete/{id}', [CandidateController::class, 'experienceDelete']);

    Route::post('/{id}/languages/create', [CandidateController::class, 'languageCreate']);
    Route::put('/{id}/languages/update/{langId}', [CandidateController::class, 'languageUpdate']);
    Route::delete('/languages/delete/{id}', [CandidateController::class, 'languageDelete']);

    Route::post('/{id}/skills/create', [CandidateController::class, 'skillCreate']);
    Route::put('/{id}/skills/update/{skillId}', [CandidateController::class, 'skillUpdate']);
    Route::delete('{id}/skills/delete/{skillId}', [CandidateController::class, 'skillDelete']);

    Route::post('/{id}/educations/create', [CandidateController::class, 'educationCreate']);
    Route::put('/{id}/educations/update/{educationId}', [CandidateController::class, 'educationUpdate']);
    Route::delete('/educations/delete/{id}', [CandidateController::class, 'educationDelete']);

    Route::post('/{id}/contacts/create', [CandidateController::class, 'contactCreate']);
    Route::put('/{id}/contacts/update/{contactId}', [CandidateController::class, 'contactUpdate']);
    Route::delete('/{id}/contacts/delete/{contactId}', [CandidateController::class, 'contactUDelete']);

    Route::post('/create', [CandidateController::class, 'create']);
    Route::put('/update/{id}', [CandidateController::class, 'update']);
    Route::delete('/delete/{id}', [CandidateController::class, 'delete']);
});

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::get('/{id}', [ClientController::class, 'show']);

    Route::get('/{id}/files/download/{fileId}', [ClientController::class, 'download']);
    Route::post('/{id}/files/upload', [ClientController::class, 'upload']);
    Route::delete('/{id}/files/deleteFile/{fileId}', [ClientController::class, 'deleteFile']);


    Route::post('/create', [ClientController::class, 'create']);
    Route::put('/update/{id}', [ClientController::class, 'update']);
    Route::delete('/delete/{id}', [ClientController::class, 'delete']);
});

// Vacancies
Route::prefix('vacancies')->group(function () {
    Route::get('/', [VacancyController::class, 'index']);
    Route::get('/{id}', [VacancyController::class, 'show']);
    Route::post('/create', [VacancyController::class, 'create']);
    Route::put('/update/{id}', [VacancyController::class, 'update']);
    Route::delete('/delete/{id}', [VacancyController::class, 'delete']);
    //File
    Route::get('/{id}/download/{fileId}', [VacancyController::class, 'downloadFile']);
    Route::get('/{id}/file/{fileId}', [VacancyController::class, 'showFile']);
    Route::post('/{id}/upload', [VacancyController::class, 'uploadFile']);
    Route::delete('/{id}/delete/{fileId}', [VacancyController::class, 'deleteFile']);
    // Skills
    Route::post('/{id}/skills/create', [VacancyController::class, 'createSkills']);
    Route::put('/{id}/skills/update/{skillId}', [VacancyController::class, 'updateSkill']);
    Route::delete('/{id}/skills/delete/{skillId}', [VacancyController::class, 'deleteSkill']);
});

// Projects
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/{id}', [ProjectController::class, 'show']);
    Route::post('/create', [ProjectController::class, 'create']);
    Route::patch('/{id}/create-contract', [ProjectController::class, 'createContract']);
    Route::put('/{id}/update-performers', [ProjectController::class, 'updatePerformers']);
    Route::put('/update/{id}', [ProjectController::class, 'update']);
    Route::patch('/{id}/close', [ProjectController::class, 'closeProject']);
    // File
    Route::get('/{id}/download/{fileId}', [ProjectController::class, 'downloadFile']);
    Route::get('/{id}/file/{fileId}', [ProjectController::class, 'showFile']);
    Route::post('/{id}/upload', [ProjectController::class, 'uploadFile']);
    Route::delete('/{id}/delete/{fileId}', [ProjectController::class, 'deleteFile']);
    // Stage
    Route::post('/{id}/stage/create', [ProjectController::class, 'createStage']);
    Route::patch('/stage/{stageId}/update', [ProjectController::class, 'updateStage']);
    Route::patch('/stage/{stageId}/require', [ProjectController::class, 'setRequireStage']);
    Route::patch('/stage/{stageId}/complete', [ProjectController::class, 'completeStage']);
    Route::delete('/stage/delete/{stageId}', [ProjectController::class, 'deleteStage']);
    // Stage Task
    Route::post('/stage/task/create', [ProjectController::class, 'createStageTask']);
    Route::put('/stage/task/{taskId}/update', [ProjectController::class, 'updateStageTask']);
    Route::delete('/stage/task/{taskId}/delete', [ProjectController::class, 'deleteStageTask']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);

    Route::put('/{id}/updateStatus', [UserController::class, 'updateStatus']);

    Route::post('/create', [UserController::class, 'create']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
});

Route::prefix('types')->group(function () {
    Route::get('/', [TypeController::class, 'index']);
    Route::get('/{id}', [TypeController::class, 'show']);
    Route::post('/create', [TypeController::class, 'create']);
    Route::put('/update/{id}', [TypeController::class, 'update']);
    Route::delete('/delete/{id}', [TypeController::class, 'delete']);
});

Route::prefix('interactions')->group(function () {
    Route::get('/', [InteractionController::class, 'index']);
    Route::get('/{id}', [InteractionController::class, 'show']);
    Route::post('/create', [InteractionController::class, 'create']);
    Route::put('/update/{id}', [InteractionController::class, 'update']);
    Route::delete('/delete/{id}', [InteractionController::class, 'delete']);
});
