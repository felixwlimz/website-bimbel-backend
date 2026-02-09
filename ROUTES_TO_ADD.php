<?php

/**
 * Add these routes to routes/api.php
 * 
 * These routes handle:
 * 1. Package question sets management
 * 2. Result retrieval with per-subtopic breakdown
 */

// ============================================
// PACKAGE QUESTION SETS
// ============================================

Route::prefix('packages')->group(function () {
    // Get all question sets in a package
    Route::get('{packageId}/sets', [PackageSetController::class, 'index']);
    
    // Get package summary (total sets, total questions)
    Route::get('{packageId}/summary', [PackageSetController::class, 'summary']);
    
    // Create new question set (admin only)
    Route::post('{packageId}/sets', [PackageSetController::class, 'store'])
        ->middleware('auth:sanctum');
});

// ============================================
// QUESTION SETS
// ============================================

Route::prefix('sets')->group(function () {
    // Add questions to a specific set (admin only)
    Route::post('{setId}/questions', [PackageSetController::class, 'addQuestions'])
        ->middleware('auth:sanctum');
});

// ============================================
// RESULTS
// ============================================

Route::prefix('results')->group(function () {
    // Get detailed result with per-subtopic breakdown (auth required)
    Route::get('{sheetId}', [ResultController::class, 'show'])
        ->middleware('auth:sanctum');
});

/**
 * USAGE EXAMPLES:
 * 
 * 1. Get all question sets in a package
 *    GET /api/packages/{packageId}/sets
 * 
 * 2. Get package summary
 *    GET /api/packages/{packageId}/summary
 * 
 * 3. Create new question set
 *    POST /api/packages/{packageId}/sets
 *    Body: { "name": "Trigonometri" }
 * 
 * 4. Add questions to a set
 *    POST /api/sets/{setId}/questions
 *    Body: { "questions": [...] }
 * 
 * 5. Get detailed result with breakdown
 *    GET /api/results/{sheetId}
 */
