<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'PollController@getPolls');
Route::get('/polls/open', 'PollController@getOpenPolls');
Route::get('/polls/closed', 'PollController@getClosedPolls');
Route::get('polls/new', array('before' => array('auth', 'permission:create_polls'), 'uses' => 'PollController@getNewPoll'));
Route::post('polls/new', array('before' => array('auth', 'permission:create_polls'), 'uses' => 'PollController@postNewPoll'));
Route::get('poll/{id}', array('as' => 'poll', 'uses' => 'PollController@getPoll'));
Route::post('poll/{id}', array('before' => array('auth'), 'uses' => 'PollController@postPoll'));
Route::get('poll/{id}/results', array('as' => 'results', 'before' => array('auth'), 'uses' => 'PollController@getPollResults'));
Route::get('poll/{id}/statistics', array('as' => 'statistics', 'before' => array('auth'), 'uses' => 'PollController@getPollStatistics'));
Route::get('poll/{id}/close', array('as' => 'close', 'uses' => 'PollController@getClosePoll'));
Route::get('poll/{id}/open', array('as' => 'open', 'uses' => 'PollController@getOpenPoll'));
Route::get('poll/{id}/delete', array('as' => 'delete', 'uses' => 'PollController@getDeletePoll'));
Route::get('events', array('before' => array('auth', 'role:Administrator'), 'uses' => 'EventController@getEvents'));
Route::get('join', array('before' => 'guest', 'uses' => 'UserController@getJoin'));
Route::post('join', 'UserController@postJoin');
Route::get('login', array('before' => 'guest', 'uses' => 'UserController@getLogin'));
Route::post('login', 'UserController@postLogin');
Route::get('logout', 'UserController@getLogout');
