p4.monkeybusiness.us
====================

Project 4 for CSCI E-15
Emily Keuthen
====================

DESCRIPTION
Fly Me Away is an application used to flexibly search for airplane flights.  
Once a user has signed up or logged in, the user enters one or more trip idea.  
Trip ideas can be specific or open ended.  
Aside from specifing a home airport, a user may specify:
* month / year of travel 
* destination of interest
* maximum price
From the user's specified trip idea(s) the system display specific flight deals.  
These flights are the best deals kayak.com's users have recently found that meet
the user's specifications.  
If a user is interested in a particular deal, the system directs them to the 
appropriate page on kayak.com.  

FEATURES
* Sign up
* Log in
* Log out
* Select trip options
* Delete trip options
* View flight deals

JAVASCRIPT USES
* autocomplete for home airport field
* ajax call to http://airportcode.riobard.com web service (airport database)
* ajax call to submit trip idea
* ajax call to delete trip idea