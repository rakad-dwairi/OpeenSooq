# To run The application ->


# php yii migrate => to migate the tables to your database 


# php yii serve --docroot="frontend/web" => to run your application locally 

# To Register a New Account  

# http://localhost:8080/auth/create :- With three Parameters (username , email , password) {{ Method (POST) }}

#  To Login

# http://localhost:8080/auth/login :- With two Parameters (username , password ) {{ Method {POST} }}


# To Get the Current Weather for any City 

# http://localhost:8080/open-weather/get-city-weather :- With Two Parameters (One in the Params in Postman (city) , And One in the Headers (Authorization) )

# example :- city => amman , Authorization => Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IlVOSVFVRS1KV1QtSURFTlRJRklFUiJ9.eyJpc3MiOiJodHRwczpcL1wvYXBpLmV4YW1wbGUuY29tIiwiYXVkIjoiaHR0cHM6XC9cL2Zyb250ZW5kLmV4YW1wbGUuY29tIiwianRpIjoiVU5JUVVFLUpXVC1JREVOVElGSUVSIiwiaWF0IjoxNjYzNjIyNDA2LCJleHAiOjE2NjM2MjI3MDYsInVpZCI6M30.QheQGS0cvrOj-q-j4zahQnt3_BUoWPuSNKjUUXPu5JQ 

# In the above the token is generated once you login 
