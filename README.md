###Spider Task 2

**Framework used : PHP on Apache**  
**Database 	 : MySQL**  
**Server	 : Apache2**  

Below are the links for downloading all the necessary software required to run the scripts :

####For Windows
+ Install WampServer. Wamp means Apache, MySQL and PHP on Windows.[Click here](http://www.wampserver.com/en/) to download WampServer. It contains all the links and a step by step guide about the installation and functionalities.

The details about the database and the tables used are as follows :
+ The user is 'root'@'localhost'.
+ There is no Password .
+ The database name is 'spider16task2'.
+ The table name is 'spider'. The CREATE TABLE command is given below.  
   CREATE TABLE `spider` (  
  `NAME` text DEFAULT NULL,  
  `ROLL_NO` int(9) NOT NULL DEFAULT '0',  
  `DEPT` varchar(100) DEFAULT NULL,  
  `MAIL` varchar(100) DEFAULT NULL,  
  `ADDRESS` varchar(100) DEFAULT NULL,  
  `ABOUT ME` text,  
  `PASSCODE` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ROLL_NO`)  
) 

The **mysqli** library has been used for connecting to the database.

####How to run the scripts
+ Clone this repository into the folder you want. 
+ Start your WampServer.
+ Copy all the files from Spider2k16_WebDev to your localhost directory i. e. the 'www' directory in your WampServer.
+ Open up your browser. Type http://localhost/ as the URL.
+ Click on registration.html.
