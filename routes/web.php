<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CapVcController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\MatchScheduleController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\TeamsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// landing page routes
Route::get('/', [LandingPageController::class, 'index'])->name('index');
Route::get('create/{id}', [LandingPageController::class, 'createTeam'])->name('create');

// Route::get('home', function () {
//     return redirect('/');
// });
// Auth::routes();
Auth::routes([
    'register' => false, // Register Routes...
    // 'reset' => false, // Reset Password Routes...
    // 'verify' => false, // Email Verification Routes...
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // players routes
    Route::get('players/index', [PlayerController::class, 'playersIndex'])->name('admin.players.index');
    Route::get('players/list', [PlayerController::class, 'getPlayerList'])->name('admin.players.list');
    Route::post('players/edit', [PlayerController::class, 'getPlayerDetails'])->name('admin.players.rowdetails');
    Route::post('players/add', [PlayerController::class, 'addPlayer'])->name('admin.players.add');
    Route::post('players/update', [PlayerController::class, 'updatePlayer'])->name('admin.players.update');
    Route::post('players/delete', [PlayerController::class, 'deletePlayer'])->name('admin.players.delete');
    // match schedule routes
    Route::get('match_schedule/index', [MatchScheduleController::class, 'matchScheduleIndex'])->name('admin.matchschedule.index');
    Route::post('get-team/list', [MatchScheduleController::class, 'getTeamList'])->name('admin.get_team.list');
    Route::post('match_schedule/add', [MatchScheduleController::class, 'addMatchSchedule'])->name('admin.match_schedule.add');
    Route::get('match_schedule/list', [MatchScheduleController::class, 'getMatchScheduleList'])->name('admin.match_schedule.list');
    Route::post('match_schedule/edit', [MatchScheduleController::class, 'getMatchScheduleDetails'])->name('admin.match_schedule.rowdetails');
    Route::post('match_schedule/update', [MatchScheduleController::class, 'updateMatchSchedule'])->name('admin.match_schedule.update');
    Route::post('match_schedule/delete', [MatchScheduleController::class, 'deleteMatchSchedule'])->name('admin.match_schedule.delete');
    // players routes
    Route::get('series/index', [SeriesController::class, 'seriesIndex'])->name('admin.series.index');
    Route::get('series/list', [SeriesController::class, 'getSeriesList'])->name('admin.series.list');
    Route::post('series/edit', [SeriesController::class, 'getSeriesDetails'])->name('admin.series.rowdetails');
    Route::post('series/add', [SeriesController::class, 'addSeries'])->name('admin.series.add');
    Route::post('series/update', [SeriesController::class, 'updateSeries'])->name('admin.series.update');
    Route::post('series/delete', [SeriesController::class, 'deleteSeries'])->name('admin.series.delete');
    // teams routes
    Route::get('teams/index', [TeamsController::class, 'teamsIndex'])->name('admin.teams.index');
    Route::get('teams/list', [TeamsController::class, 'getTeamsList'])->name('admin.teams.list');
    Route::post('teams/edit', [TeamsController::class, 'getTeamsDetails'])->name('admin.teams.rowdetails');
    Route::post('teams/add', [TeamsController::class, 'addTeams'])->name('admin.teams.add');
    Route::post('teams/update', [TeamsController::class, 'updateTeams'])->name('admin.teams.update');
    Route::post('teams/delete', [TeamsController::class, 'deleteTeams'])->name('admin.teams.delete');
});

Route::group(['prefix' => 'user', 'middleware' => ['isUser', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('user.dashboard');
});
// Route::get('cap_vc_team', [CapVcController::class, 'capVcTeam']);
Route::post('cap_vc_team', [CapVcController::class, 'capVcTeam'])->name('create.team');
Route::post('feedback', [CommonController::class, 'feedback'])->name('customer.feedback');
