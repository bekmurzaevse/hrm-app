<?php

use App\Http\Controllers\v1\CandidateController;
use App\Http\Controllers\v1\ClientController;
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
    Route::post('/create', [CandidateController::class, 'create']);
    Route::put('/update/{id}', [CandidateController::class, 'update']);
    Route::delete('/delete/{id}', [CandidateController::class, 'delete']);
});

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::get('/{id}', [ClientController::class, 'show']);
    Route::get('/{id}/download/{fileId}', [ClientController::class, 'download']);
    Route::post('/{id}/upload', [ClientController::class, 'upload']);
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
    Route::get('/{id}/download/{fileId}', [VacancyController::class, 'download']);
    Route::post('/{id}/upload', [VacancyController::class, 'upload']);
    Route::delete('/{id}/delete/{fileId}', [VacancyController::class, 'deleteFile']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/create', [UserController::class, 'create']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
});

// Route::prefix('deals')->group(function () {
//     Route::get('/', [DealsController::class, 'index']);
//     Route::get('/{id}', [DealsController::class, 'show']);
//     Route::post('/create', [DealsController::class, 'create']);
//     Route::put('/update/{id}', [DealsController::class, 'update']);
//     Route::delete('/delete/{id}', [DealsController::class, 'delete']);
// });

// Route::prefix('interactions')->group(function () {
//     Route::get('/', [InterActionController::class, 'index']);
//     Route::get('/{id}', [InterActionController::class, 'show']);
//     Route::post('/create', [InterActionController::class, 'create']);
//     Route::put('/update/{id}', [InterActionController::class, 'update']);
//     Route::delete('/delete/{id}', [InterActionController::class, 'delete']);
// });

// Route::prefix('projects')->group(function () {
//     Route::get('/', [ProjectController::class, 'index']);
//     Route::get('/{id}', [ProjectController::class, 'show']);
//     Route::post('/create', [ProjectController::class, 'create']);
//     Route::put('/update/{id}', [ProjectController::class, 'update']);
//     Route::delete('/delete/{id}', [ProjectController::class, 'delete']);
// });

// Route::prefix('vacancies')->group(function () {
//     Route::get('/', [VacancyController::class, 'index']);
//     Route::get('/{id}', [VacancyController::class, 'show']);
//     Route::post('/create', [VacancyController::class, 'create']);
//     Route::put('/update/{id}', [VacancyController::class, 'update']);
//     Route::delete('/delete/{id}', [VacancyController::class, 'delete']);
// });

// Route::prefix('courses')->group(function () {
//     Route::get('/', [CourseController::class, 'index']);
//     Route::get('/{id}', [CourseController::class, 'show']);
//     Route::post('/create', [CourseController::class, 'create']);
//     Route::put('/update/{id}', [CourseController::class, 'update']);
//     Route::delete('/delete/{id}', [CourseController::class, 'delete']);
// });

// Route::prefix('hr-documents')->group(function () {
//     Route::get('/', [HrDocumentController::class, 'index']);
//     Route::get('/{id}', [HrDocumentController::class, 'show']);
//     Route::post('/create', [HrDocumentController::class, 'create']);
//     Route::put('/update/{id}', [HrDocumentController::class, 'update']);
//     Route::delete('/delete/{id}', [HrDocumentController::class, 'delete']);
//     Route::get('download/{id}', [HrDocumentController::class, 'download']);
// });

// Route::prefix('hr-orders')->group(function () {
//     Route::get('/', [HrOrderController::class, 'index']);
//     Route::get('/{id}', [HrOrderController::class, 'show']);
//     Route::post('/create', [HrOrderController::class, 'create']);
//     Route::put('/update/{id}', [HrOrderController::class, 'update']);
//     Route::delete('/delete/{id}', [HrOrderController::class, 'delete']);
//     Route::get('download/{id}', [HrOrderController::class, 'download']);
// });

// Route::prefix('course-assignments')->group(function () {
//     Route::get('/', [CourseAssignmentController::class, 'index']);
//     Route::get('/{id}', [CourseAssignmentController::class, 'show']);
//     Route::post('/create', [CourseAssignmentController::class, 'create']);
//     Route::put('/update/{id}', [CourseAssignmentController::class, 'update']);
//     Route::get('/download/{id}', [CourseAssignmentController::class, 'download']);
//     Route::put('/complete/{id}', [CourseAssignmentController::class, 'complete']);
//     Route::delete('/delete/{id}', [CourseAssignmentController::class, 'delete']);
// });

// Route::prefix('recruitment-funnel-stages')->group(function () {
//     Route::get('/', [RecruitmentFunnelStageController::class, 'index']);
//     Route::get('/{id}', [RecruitmentFunnelStageController::class, 'show']);
//     Route::post('/create', [RecruitmentFunnelStageController::class, 'create']);
//     Route::put('/update/{id}', [RecruitmentFunnelStageController::class, 'update']);
//     Route::delete('/delete/{id}', [RecruitmentFunnelStageController::class, 'delete']);
// });

// Route::prefix('funnel-logs')->group(function () {
//     Route::get('/', [FunnelLogController::class, 'index']);
//     Route::get('/{id}', [FunnelLogController::class, 'show']);
//     Route::post('/create', [FunnelLogController::class, 'create']);
//     Route::put('/update/{id}', [FunnelLogController::class, 'update']);
//     Route::delete('/delete/{id}', [FunnelLogController::class, 'delete']);
// });

// Route::prefix('applications')->group(function () {
//     Route::get('/', [ApplicationController::class, 'index']);
//     Route::get('/{id}', [ApplicationController::class, 'show']);
//     Route::post('/create', [ApplicationController::class, 'create']);
//     Route::put('/update/{id}', [ApplicationController::class, 'update']);
//     Route::delete('/delete/{id}', [ApplicationController::class, 'delete']);
// });

// Route::prefix('course-materials')->group(function () {
//     Route::get('/', [CourseMaterialController::class, 'index']);
//     Route::get('/{id}', [CourseMaterialController::class, 'show']);
//     Route::post('/create', [CourseMaterialController::class, 'create']);
//     Route::put('/update/{id}', [CourseMaterialController::class, 'update']);
//     Route::get('/download/{id}', [CourseMaterialController::class, 'download']);
//     Route::delete('/delete/{id}', [CourseMaterialController::class, 'delete']);
// });

// Route::prefix('tests')->group(function () {
//     Route::get('/', [TestController::class, 'index']);
//     Route::get('/{id}', [TestController::class, 'show']);
//     Route::post('/create', [TestController::class, 'create']);
//     Route::put('/update/{id}', [TestController::class, 'update']);
//     Route::delete('/delete/{id}', [TestController::class, 'delete']);
// });

// Route::prefix('test-results')->group(function () {
//     Route::get('/', [TestResultController::class, 'index']);
//     Route::get('/{id}', [TestResultController::class, 'show']);
//     Route::post('/create', [TestResultController::class, 'create']);
//     Route::put('/update/{id}', [TestResultController::class, 'update']);
//     Route::delete('/delete/{id}', [TestResultController::class, 'delete']);
// });

// Route::prefix('candidates')->group(function () {
//     Route::get('/', [CandidateController::class, 'index']);
//     Route::get('/{id}', [CandidateController::class, 'show']);
//     Route::post('/create', [CandidateController::class, 'create']);
//     Route::put('/update/{id}', [CandidateController::class, 'update']);
//     Route::delete('/delete/{id}', [CandidateController::class, 'delete']);
// });

// Route::prefix('candidate-notes')->group(function () {
//     Route::get('/', [CandidateNoteController::class, 'index']);
//     Route::get('/{id}', [CandidateNoteController::class, 'show']);
//     Route::post('/create', [CandidateNoteController::class, 'create']);
//     Route::put('/update/{id}', [CandidateNoteController::class, 'update']);
//     Route::delete('/delete/{id}', [CandidateNoteController::class, 'delete']);
// });

// Route::prefix('candidate-documents')->group(function () {
//     Route::get('/', [CandidateDocumentController::class, 'index']);
//     Route::get('/{id}', [CandidateDocumentController::class, 'show']);
//     Route::post('/create', [CandidateDocumentController::class, 'create']);
//     Route::put('/update/{id}', [CandidateDocumentController::class, 'update']);
//     Route::delete('/delete/{id}', [CandidateDocumentController::class, 'delete']);
//     Route::get('/download/{id}', [CandidateDocumentController::class, 'download']);
// });

// Route::prefix('reports')->group(function () {
//     Route::get('/', [ReportController::class, 'index']);
//     Route::get('/{id}', [ReportController::class, 'show']);
//     Route::post('/create', [ReportController::class, 'create']);
//     Route::put('/update/{id}', [ReportController::class, 'update']);
//     Route::delete('/delete/{id}', [ReportController::class, 'delete']);
//     Route::get('download/{id}', [ReportController::class, 'download']);
// });

// Route::prefix('tasks')->group(function () {
//     Route::get('/', [TaskController::class, 'index']);
//     Route::get('/{id}', [TaskController::class, 'show']);
//     Route::post('/create', [TaskController::class, 'create']);
//     Route::put('/update/{id}', [TaskController::class, 'update']);
//     Route::delete('/delete/{id}', [TaskController::class, 'delete']);
// });

// Route::prefix('kpi-records')->group(function () {
//     Route::get('/', [KpiRecordController::class, 'index']);
//     Route::get('/{id}', [KpiRecordController::class, 'show']);
//     Route::post('/create', [KpiRecordController::class, 'create']);
//     Route::put('/update/{id}', [KpiRecordController::class, 'update']);
//     Route::delete('/delete/{id}', [KpiRecordController::class, 'delete']);
// });

// Route::prefix('finances')->group(function () {
//     Route::get('/', [FinanceController::class, 'index']);
//     Route::get('/{id}', [FinanceController::class, 'show']);
//     Route::post('/create', [FinanceController::class, 'create']);
//     Route::put('/update/{id}', [FinanceController::class, 'update']);
//     Route::delete('/delete/{id}', [FinanceController::class, 'delete']);
// });

// Route::prefix('tags')->group(function () {
//     Route::get('/', [TagController::class, 'index']);
//     Route::get('/{id}', [TagController::class, 'show']);
//     Route::post('/create', [TagController::class, 'create']);
//     Route::put('/update/{id}', [TagController::class, 'update']);
//     Route::delete('/delete/{id}', [TagController::class, 'delete']);
// });
