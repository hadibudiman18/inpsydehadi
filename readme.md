# Custom EndPoint

Inpsyde test project

## Installation

* Upload the ‘inpsydehadi’ plugin to the /wp-content/plugins/ directory;
* Run composer install , and ready to activate



## Usage

* Activate the inpsydehadi plugin through the ‘Plugins’ menu in WordPress
* After activated, Click ‘Settings’ below plugin name to setup endpoint address and settings
* By default it sets to ‘https://jsonplaceholder.typicode.com/users’ and 3 fields checked to display on the front end, (id, name, username)
* field name is the field to display on the front end, if empty it will take original name from json response
* and auto create ‘custom end point’ page with shortcode after activated


## Decisions behind implementation
* Endpoint address and column's is editable, simply so it can be used by other endpoint address for example we can change it to ‘https://jsonplaceholder.typicode.com/users . it will change available column's 
* Before save , endpoint address have to validate using ‘Check Address’ button, and will show 'Address 404 Not Found' if address is not found.
* Column name is editable , because sometimes json response column name not familiar for end user, so it can be changed to fit the needs

* "the details of that user must be shown. For that, the plugin will do another API request to the user-details endpoint.". i decide to not do another API request , because first API request response is stored in javascript , so i decide to get the details from javascript variable. it can save loading times and bandwidth :)
