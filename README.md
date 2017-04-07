## About Crawler

Crawler is a web based laravel application that goes through brazilian bidding websites to crawl information on trasparency and make them easier to analyze for robotic scripts. The main idea is to fundamentally develop different solutions for different kinds of websites. Ideally it would take any website that contains form actions and be able to crawl data from resquests.  
For the first version, it is only available for crawling CNPq information through their bidding website. It includes:
- The preview template.
- A  list of available bidding websites for data mining.
- A preview for the data collected, alongside all the information that could be gathered via post request.

## Installation
Before using Crawler, be sure to have Laravel v5.4 installed on your local machine.

Also, you need to enable the php_mongodb.dll extension. For more information on usage of [Jenssegers MongoDB package](https://github.com/jenssegers/laravel-mongodb), please refer to their official documentaton.

Clone the project into your repository. Make sure to run composer install and composer update to be able to use all of the packages required for this application. Also, remember to add a .env file with your database host configurations.

Run your MongoDB database instance in order to have a fully functioning application. If your configurations are incorrect, it may not function. In this case, feel free to contact me to help you solve your issue.

## Usage
Open your local connection and be sure to run your MongoDB instance (otherwise it will not work). Activate your apache server and access your directory in any web browser.
The regular link would be http://localhost/crawler/public/
Once you open the application, click the "Minar Dados" button and the results will be shown fully paginated using bootstrap panels. You can also access the information on your MongoDB interface of preference to check which data are coming.
You can change the POST requests options on the CrawlService, changing the amount of documents you want to process. Please note that IT WILL CREATE DUPLICATES on the database every time you run the request since it does not check for duplicates on information for the database.

For processing the whole biddings website, change the "registros" option on the data array to at least 3160.
## How it works

On version 0.1, the application only works on the bidding website for CNPq. It creates a POST request through Eloquent to retrieve the HTML data from the webpage.
When the data is retrieved, it is treated as a string, checking which regular expressions can be used to find the desired information. Since the data is shown as a table, that is a starting point for gathering information.
For more information on how it is processed, please refer to the comments found in the CrawlService.

For future versions, the interface will be enhanced, presenting the information with the correct pagination display, and it will be possible to register new bidding website applications.

Thank you for using Crawler!