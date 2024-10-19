<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$url = 'https://rickandmortyapi.com/api/location';


$data = file_get_contents($url);

$locations = json_decode($data, true);
/*
$pretty = json_encode($locations, JSON_PRETTY_PRINT); 
echo "<pre>" . $pretty . "<pre/>"; 




$dimensions = array_map(function ($location) {
	return $location['dimension'];
}, $locations['results']);


echo "<pre>" . json_encode($dimensions, JSON_PRETTY_PRINT) . "<pre/>"; 

*/
echo "<pre>" . json_encode($locations, JSON_PRETTY_PRINT) . "<pre/>"; 


$residents = array_filter($locations['results'], function ($location) {
	// return $location['dimension'] === 'Post-Apocalyptic Dimension'; // Only one time used
	return $location['dimension'] === 'Replacement Dimension';
	
});

echo "<pre>" . json_encode($residents, JSON_PRETTY_PRINT) . "<pre/>"; 

$characters = [];
foreach($residents as $resident){
    array_push($characters, ...$resident['residents']);
}


echo "<pre>" . json_encode($characters, JSON_PRETTY_PRINT) . "<pre/>"; 



/*
Docker
Symfony

Controller
	- show random character
	- list all character in [episode | dimension | location ]
	- info
	
Twig	
	- Display as Table / grid (switchable)
	
	
Services
	- API client
	
	
	
Docker Symfony https://medium.com/@oumaymaneffati/the-easy-way-to-install-symfony-with-docker-b6fca3997d2c
	
	
	
	
https://symfony.com/doc/current/setup/docker.html	
https://netgen.io/blog/consuming-external-apis-basic-tips-tricks



graphQl Unique values: https://stackoverflow.com/questions/46552167/how-to-use-distinct-in-graphql-query



*/