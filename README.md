# City Pantry - Backend/PHP Coding Challenge

City Pantry needs a program to search its database of vendors for menu items available given day, time, location and a headcount. Each vendor has a name, postcode and a maximum headcount it can serve at any time. Menu items each have a name, list of allergies and notice period needed for placing an order.

## Install

To set up project local run `composer install` inside the project directory.

## Test

 To Run all the test `bin/phpunit`  

Usage:

  ```app:search-db <day> <time> <location> <covers> [<filename>]```
  
  Arguments:
    day                   Date of order
    
    time                  Time of order
    
    location              Location of order
    
    covers                Number of people covered
    
    filename              Input file (Optional)


