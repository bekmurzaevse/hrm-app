<?php

use App\Enums\TokenAbilityEnum;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\Candidate\CandidateController;
use App\Http\Controllers\v1\Candidate\CandidateExperienceController;
use App\Http\Controllers\v1\Candidate\CandidateLanguageController;
use App\Http\Controllers\v1\Candidate\CandidateEducationController;
use App\Http\Controllers\v1\Candidate\CandidateContactController;
use App\Http\Controllers\v1\Candidate\CandidateSkillController;
use App\Http\Controllers\v1\Candidate\CandidateFileController;
use App\Http\Controllers\v1\Client\ClientController;
use App\Http\Controllers\v1\Client\ClientFileController;
use App\Http\Controllers\v1\Dashboard\DashboardController;
use App\Http\Controllers\v1\Finance\FinanceController;
use App\Http\Controllers\v1\InteractionController;
use App\Http\Controllers\v1\Project\ProjectController;
use App\Http\Controllers\v1\Project\ProjectFileController;
use App\Http\Controllers\v1\Project\ProjectStageController;
use App\Http\Controllers\v1\Project\StageTaskController;
use App\Http\Controllers\v1\RegionController;
use App\Http\Controllers\v1\Selection\SelectionItemController;
use App\Http\Controllers\v1\Selection\SelectionStatusController;
use App\Http\Controllers\v1\Selection\SelectionStatusValueController;
use App\Http\Controllers\v1\Task\TaskController;
use App\Http\Controllers\v1\Selection\SelectionController;
use App\Http\Controllers\v1\TypeController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\Vacancy\VacancyController;
use App\Http\Controllers\v1\Vacancy\VacancyFileController;
use App\Http\Controllers\v1\Vacancy\VacancySkillController;
use Illuminate\Support\Facades\Route;

Route::patterns([
    'id' => '\d+',
    'fileId' => '\d+',
    'workId' => '\d+',
    'langId' => '\d+',
    'skillId' => '\d+',
    'educationId' => '\d+',
    'contactId' => '\d+',
    'stageId' => '\d+',
    'taskId' => '\d+',
    'statusId' => '\d+',
    'selectionId' => '\d+',
    'statusValueId' => '\d+',
]);

/**
 * Guest
 */
Route::prefix('auth')->middleware('guest:sanctum')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

/**
 * Auth for Refresh Token
 */
Route::prefix('auth')->middleware(['auth:sanctum', 'ability:' . TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value])->group(function () {
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});

/**
 * Routs for Auth
 */
Route::middleware(['auth:sanctum', 'ability:' . TokenAbilityEnum::ACCESS_TOKEN->value])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('get-me', [AuthController::class, 'getMe']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    // TODO: Refactor this routes for role:admin|manager|recruiter

    /**
     * Routs for Auth & Admin & Manager
     */
    Route::middleware(['role:admin|manager'])->group(function () {
        // Vacancies
        Route::prefix('vacancies')->group(function () {
            Route::post('/create', [VacancyController::class, 'create']);
            Route::put('/update/{id}', [VacancyController::class, 'update']);
            Route::delete('/delete/{id}', [VacancyController::class, 'delete']);
            //File
            Route::post('/{id}/upload', [VacancyFileController::class, 'upload']);
            Route::delete('/{id}/delete/{fileId}', [VacancyFileController::class, 'delete']);
            // Skills
            Route::prefix('/{id}/skills')->group(function () {
                Route::post('/create', [VacancySkillController::class, 'create']);
                Route::put('/update/{skillId}', [VacancySkillController::class, 'update']);
                Route::delete('/delete/{skillId}', [VacancySkillController::class, 'delete']);
            });
        });
    });

    /**
     * Routs for Auth & Admin & Manager & Recruiter
     */
    Route::prefix('candidates')->group(function () {
        Route::get('/', [CandidateController::class, 'index']);
        Route::get('/{id}', [CandidateController::class, 'show']);
        Route::post('/create', [CandidateController::class, 'create']);
        Route::put('/update/{id}', [CandidateController::class, 'update']);
        Route::delete('/delete/{id}', [CandidateController::class, 'delete']);
        // File
        Route::post('/{id}/upload', [CandidateFileController::class, 'upload']);
        Route::get('/{id}/download/{fileId}', [CandidateFileController::class, 'download']);
        Route::post('/{id}/deleteFile/{fileId}', [CandidateFileController::class, 'deleteFile']);
        //Experience
        Route::post('/{id}/experience/create', [CandidateExperienceController::class, 'experienceCreate']);
        Route::put('/{id}/experience/update/{workId}', [CandidateExperienceController::class, 'experienceUpdate']);
        Route::delete('/experience/delete/{id}', [CandidateExperienceController::class, 'experienceDelete']);
        // Language
        Route::post('/{id}/languages/create', [CandidateLanguageController::class, 'languageCreate']);
        Route::put('/{id}/languages/update/{langId}', [CandidateLanguageController::class, 'languageUpdate']);
        Route::delete('/languages/delete/{id}', [CandidateLanguageController::class, 'languageDelete']);
        // Skill
        Route::post('/{id}/skills/create', [CandidateSkillController::class, 'skillCreate']);
        Route::put('/{id}/skills/update/{skillId}', [CandidateSkillController::class, 'skillUpdate']);
        Route::delete('{id}/skills/delete/{skillId}', [CandidateSkillController::class, 'skillDelete']);
        //Education
        Route::post('/{id}/educations/create', [CandidateEducationController::class, 'educationCreate']);
        Route::put('/{id}/educations/update/{educationId}', [CandidateEducationController::class, 'educationUpdate']);
        Route::delete('/educations/delete/{id}', [CandidateEducationController::class, 'educationDelete']);
        //Contact
        Route::post('/{id}/contacts/create', [CandidateContactController::class, 'contactCreate']);
        Route::put('/{id}/contacts/update/{contactId}', [CandidateContactController::class, 'contactUpdate']);
        Route::delete('/{id}/contacts/delete/{contactId}', [CandidateContactController::class, 'contactUDelete']);
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index']);
        Route::get('/list', [ClientController::class, 'list']);
        Route::get('/{id}', [ClientController::class, 'show']);
        Route::post('/create', [ClientController::class, 'create']);
        Route::put('/update/{id}', [ClientController::class, 'update']);
        Route::delete('/delete/{id}', [ClientController::class, 'delete']);
        // File
        Route::get('/{id}/files/download/{fileId}', [ClientFileController::class, 'download']);
        Route::post('/{id}/files/upload', [ClientFileController::class, 'upload']);
        Route::delete('/{id}/files/deleteFile/{fileId}', [ClientFileController::class, 'deleteFile']);
    });

    // Vacancies
    Route::prefix('vacancies')->group(function () {
        Route::get('/', [VacancyController::class, 'index']);
        Route::get('/{id}', [VacancyController::class, 'show']);
        //File
        Route::get('/{id}/download/{fileId}', [VacancyFileController::class, 'download']);
        Route::get('/{id}/file/{fileId}', [VacancyFileController::class, 'show']);
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
        Route::get('/{id}/download/{fileId}', [ProjectFileController::class, 'downloadFile']);
        Route::get('/{id}/file/{fileId}', [ProjectFileController::class, 'showFile']);
        Route::post('/{id}/upload', [ProjectFileController::class, 'uploadFile']);
        Route::delete('/{id}/delete/{fileId}', [ProjectFileController::class, 'deleteFile']);
        // Stage
        Route::post('/{id}/stage/create', [ProjectStageController::class, 'createStage']);
        Route::patch('/stage/{stageId}/update', [ProjectStageController::class, 'updateStage']);
        Route::patch('/stage/{stageId}/require', [ProjectStageController::class, 'setRequireStage']);
        Route::patch('/stage/{stageId}/complete', [ProjectStageController::class, 'completeStage']);
        Route::delete('/stage/delete/{stageId}', [ProjectStageController::class, 'deleteStage']);
        // Stage Task
        Route::post('/stage/task/create', [StageTaskController::class, 'createStageTask']);
        Route::put('/stage/task/{taskId}/update', [StageTaskController::class, 'updateStageTask']);
        Route::delete('/stage/task/{taskId}/delete', [StageTaskController::class, 'deleteStageTask']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/list', [UserController::class, 'list']);
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

    Route::prefix('finances')->group(function () {
        Route::get('/', [FinanceController::class, 'index']);
        // Route::get('/{id}', [InteractionController::class, 'show']);
        Route::post('/create-income', [FinanceController::class, 'createIncome']);
        Route::post('/create-expense', [FinanceController::class, 'createExpense']);

        Route::put('/update-income/{id}', [FinanceController::class, 'updateIncome']);
        Route::put('/update-expense/{id}', [FinanceController::class, 'updateExpense']);

        // Route::put('/update/{id}', [InteractionController::class, 'update']);
        Route::delete('/delete/{id}', [FinanceController::class, 'delete']);
    });

    Route::prefix('regions')->group(function () {
        Route::get('/', [RegionController::class, 'index']);
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::get('/{id}', [TaskController::class, 'show']);
        Route::post('/create', [TaskController::class, 'create']);
        Route::put('/update/{id}', [TaskController::class, 'update']);
        Route::post('/complete', [TaskController::class, 'complete']);
        Route::post('/{id}/add-executor', [TaskController::class, 'addExecutor']);
        Route::put('/{id}/update-executor', [TaskController::class, 'updateExecutor']);
        Route::delete('/{id}/remove-executor', [TaskController::class, 'removeExecutor']);
        Route::post('/{id}/transfer', [TaskController::class, 'transfer']);
        Route::get('/{id}/history', [TaskController::class, 'history']);
        Route::post('/{id}/reject', [TaskController::class, 'reject']);
        // Route::delete('/delete/{id}', [TaskController::class, 'destroy']);
    });

    // Selection
    Route::prefix('selections')->group(function () {
        Route::get('/', [SelectionController::class, 'index']);
        Route::get('/list', [SelectionController::class, 'list']);
        Route::get('/{id}', [SelectionController::class, 'show']);
        Route::post('/create', [SelectionController::class, 'create']);
        Route::post('/{id}/copy', [SelectionController::class, 'copy']);
        Route::delete('/delete/{id}', [SelectionController::class, 'delete']);
        Route::delete('/delete', [SelectionController::class, 'deleteMany']);
        // SelectionItem
        Route::post('/attach-candidates', [SelectionItemController::class, 'attachCandidates']);
        Route::post('/{id}/detach-candidates', [SelectionItemController::class, 'detachCandidates']);
        Route::post('/{id}/add-external-candidates', [SelectionItemController::class, 'addExternalCandidates']);
        // SelectionStatus
        Route::prefix('/{selectionId}')->group(function () {
            Route::get('/statuses/list', [SelectionStatusController::class, 'list']);
            Route::post('/statuses', [SelectionStatusController::class, 'store']);
            Route::put('/statuses/{statusId}', [SelectionStatusController::class, 'update']);
            Route::delete('/statuses/{statusId}', [SelectionStatusController::class, 'delete']);
        });
        // SelectionStatusValue
        Route::prefix('/{selectionId}')->group(function () {
            Route::post('status-values', [SelectionStatusValueController::class, 'store']);
            Route::put('/status-values/{statusValueId}', [SelectionStatusValueController::class, 'update']);
        });
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        // Route::get('/{id}', [TaskController::class, 'show']);
        // Route::post('/create', [TaskController::class, 'create']);
        // Route::put('/update/{id}', [TaskController::class, 'update']);
        // Route::delete('/delete/{id}', [TaskController::class, 'destroy']);
    });
});
