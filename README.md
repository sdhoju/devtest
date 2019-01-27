# Razoyo Developer Test

The goal of this mini-project is to develop some PHP classes that allow Magento product information to be displayed in several different formats (CSV, XML, and JSON). You will be connecting to a Magento store that sells children's golf apparel: <https://www.shopjuniorgolf.com/>



## Getting Started

### Requirements
   -	PHP 5.6 
   -    Magento 1.9
#### PHP 
PHP, can be installed with XAMPP https://www.apachefriends.org/index.html.  It is a free PHP development environment. Due to [removal of mcrypt](http://php.net/manual/en/intro.mcrypt.php) in PHP 7.2.0. , and Magento 1.9 requiring mcrypt the development is done in PHP 5.6.

#### Magento 1.9
Magento 1.9 can be downloaded from [their official website.](https://magento.com/tech-resources/download) Unzip the files in magento folder and copy it in htdocs folder of XAMPP installation folder. You can install magento by following their guide by opening downloader.php http://localhost/magento/downloader.php
    
#### API Documentation
Magento API docs: <http://www.magentocommerce.com/api/soap/introduction.html>

### Installation
Once the required environment are set download the repository and set it up in a folder. if you are using XAMPP to run it set the folder inside htdocs folder in XAMPP instalation folder. Run the Apache server from XAMPP control pannel. 

#### Credentials
You will need an API key that should've been provided to you. The script works by pulling the password from an environment variable called **RAZOYO_TEST_KEY**.

The output can be seen in browser visiting http://localhost/devtest/export.php. In default the format is 'csv' it can be changed to xml or json file by changing the format key value in export.php 
```
$formatKey = 'csv'; // Change it to csv, xml, or json
```
The Outputs for CSV, XML and JSON format are as follows;
![csv](https://user-images.githubusercontent.com/25574185/51796960-9bee4800-21c1-11e9-8eaa-fb997fbce6a7.JPG)

![xml](https://user-images.githubusercontent.com/25574185/51796965-ac062780-21c1-11e9-9d96-19a4c56316c8.JPG)

![json](https://user-images.githubusercontent.com/25574185/51796963-a7da0a00-21c1-11e9-816f-017f2203d158.JPG)

The Output of records can be downloaded by setting the passing value of true to create function like shown below.
```
// $format = $factory->create($formatKey);
$format = $factory->create($formatKey,true);
```

## Built With

* [PHP 5.6](http://www.php.net/) - The server-side scripting language 
* [XAMPP](https://www.apachefriends.org/index.html) - Free and open-source cross-platform web server solution stack package 
* [Magento 1.9](https://magento.com/) -  An open-source e-commerce platform


## Authors

* **William Byrne** - *Starter Code* - [Razoyo](https://github.com/razoyo)
* **Sameer Dhoju** - *Submission* - [Sdhoju](https://github.com/sdhoju)

## References

 * [Magento API](https://devdocs.magento.com/guides/m1x/api/soap/catalog/catalogProduct/catalog_product.list.html)
 * [Json Encoder](http://php.net/manual/en/function.json-encode.php)
 * [XML Encoder](https://www.devexp.eu/2009/04/11/php-domdocument-convert-array-to-xml/)
