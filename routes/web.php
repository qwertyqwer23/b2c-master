<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::get('home', 'HomeController@index')->name('home');
Route::get('test_queries', 'AdminLteController@test_queries')->name('test_queries');
//Route::get('test_queries', 'AdminLteController@test_queries');

/*  */
Route::get('original_q1_form', 'AdminLteController@original_q1_form');
Route::get('original_q3_form', 'AdminLteController@original_q3_form');
Route::get('original_q4_form', 'AdminLteController@original_q4_form');

Route::get('manga_q1_form', 'AdminLteController@manga_q1_form');
Route::get('manga_q3_form', 'AdminLteController@manga_q3_form');
Route::get('manga_q4_form', 'AdminLteController@manga_q4_form');


Route::get('select', 'MasterMongodbController@select');

Route::get('insert_part', 'MasterMongodbController@insert_part');
Route::get('insert_supplier', 'MasterMongodbController@insert_supplier');
Route::get('insert_lineitem', 'MasterMongodbController@insert_lineitem');
Route::get('insert_region', 'MasterMongodbController@insert_region');
Route::get('insert_nation', 'MasterMongodbController@insert_nation');
Route::get('insert_customer', 'MasterMongodbController@insert_customer');
Route::get('insert_orders', 'MasterMongodbController@insert_orders');



Route::get('mongo_generate_tables', 'MasterMongodbController@generate_tables');
Route::get('mongo_generate_big_data', 'MasterMongodbController@generate_big_data');

//Neo4j
Route::get('neo_generate_big_data', 'MasterNeo4jController@generate_big_data');
Route::get('neo_generate_tables', 'MasterNeo4jController@generate_tables');
//Route::get('neo_generate_big_data', 'MasterNeo4jController@generate_tables');



//Cassandra
Route::get('cassandra_generate_tables', 'MasterCassandraController@generate_tables');
Route::get('cassandra_generate_test_data', 'MasterCassandraController@generate_test_data');
//Route::get('cassandra_generate_big_data', 'MasterCassandraController@generate_big_data');
Route::get('cassandra_removde_tables', 'MasterCassandraController@removde_tables');

//Redis
Route::get('select_redis', 'MasterRedisController@test');


//Return query statistic
Route::get('select_cassandra', 'MasterCassandraController@return_query_statistic');
Route::get('select_neo4j', 'MasterNeo4jController@return_query_statistic');
Route::get('select_mongodb', 'MasterMongodbController@return_query_statistic');


