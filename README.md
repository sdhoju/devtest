# Razoyo Developer Test

The goal of this mini-project is to develop some PHP classes that allow Magento product information to be displayed in several different formats (CSV, XML, and JSON). You will be connecting to a Magento store that sells children's golf apparel: <https://www.shopjuniorgolf.com/>


### Requirements
   -	PHP 5.6 
   -    Magento 1.9

### Installation

## PHP 
      PHP, can be installed with XAMPP https://www.apachefriends.org/index.html.  It is a free PHP development environment. Due to [removal of mcrypt]in PHP 7.2.0. (http://php.net/manual/en/intro.mcrypt.php), and Magento 1.9 requiring mcrypt the development is done in PHP 5.6.

## Magento 1.9
      Magento 1.9 can be downloaded from [their official website.](https://magento.com/tech-resources/download). Unzip the files in magento folder and copy it in htdocs folder of XAMPP installation folder. You can install magento by following their guide by opening downloader.php
      ```
      http://localhost/magento/downloader.php
      ```  


    
## Credentials
You will need an API key that should've been provided to you. The script works by pulling the password from an environment variable called **RAZOYO_TEST_KEY**.

## API Documentation
Magento API docs: <http://www.magentocommerce.com/api/soap/introduction.html>
