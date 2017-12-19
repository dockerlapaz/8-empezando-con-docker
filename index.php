<?php

// That's how it starts
require_once __DIR__ . "/vendor/autoload.php";

Flight::set('flight.log_errors', true);

// Initialize MongoDB
$mongo = new MongoDB\Driver\Manager();
$collection = (new MongoDB\Client)->questions->questions;

// Main Application Logic
Flight::route('GET /', function() {
	global $collection;
	// Query the DB for previous questions
	$all_questions = $collection->find(
		[],
		[
			'limit' => 15,
			'sort' => ['votes' => -1]
		]
	);

	$timeAgo = new Westsworld\TimeAgo(NULL, 'es');

	// Set it as view variable
	Flight::view()->set('all_questions', $all_questions);
	
	// What about the date?
	$time_ago = new Westsworld\TimeAgo(NULL, 'es');
	Flight::view()->set('time_ago', $time_ago);

	// And off we go
	Flight::render('home');
});

Flight::route('POST /', function() {
	global $collection;
	// Getting the form variables
	$your_name = Flight::request()->data->tu_nombre;
	$your_question = Flight::request()->data->tu_pregunta;

	// Saving it to DB
	$insertQuestion = $collection->insertOne([
		'name' => $your_name,
		'question' => $your_question,
		'votes' => 0,
		'date' => new MongoDB\BSON\UTCDateTime
	]);

	// And we redirect the user home
	Flight::redirect('/');
});

Flight::route('GET /vote/@way', function($way) {
	global $collection;

	$vote_way = ($way == 'up') ? 1 : -1;

	$q_id = Flight::request()->query->id;
	$updateQuestion = $collection->updateOne(
		['_id' => new MongoDB\BSON\ObjectID($q_id)],
		['$inc' => ['votes' => $vote_way]]
	);
	// go back home, you're drunk
	Flight::redirect('/');
});

Flight::map('notFound', function(){
	Flight::response()->status(404);
	include 'views/404.html';
});

Flight::map('error', function(Exception $ex){
    http_response_code(500);
    include 'views/500.html';
});

// We switch the engine on
Flight::start();