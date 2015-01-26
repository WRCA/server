# local test

#----------test local
#curl -d "email=dfdf&password=dfdfd&verificationCode=1233" "localhost/v1/account/register" 

# test "get verification code"
#curl "http://localhost/v1/account/verificationCode?email=hejc09@gmail.com"

# test "register"
#curl "http://localhost/v1/account/register?email=hejc09@gmail.com&password=hjc&verificationCode=123" 

# test "login
#curl "http://localhost/v1/account/login?email=hejc09@gmail.com&password=hjc" 

# test "password"
#curl "http://localhost/v1/account/password?email=hejc09@gmail.com" 

# test "events"
curl "http://localhost/v1/events?authToken=41dea62eb76b6fcf88ba9a4834376001&range=all&offset=1&limit=5"

#Curl -d "email=dfdf&password=dfdfd" "http://api.jiangchuan.info/v1/account/login" 
#curl -d "object=login&email=dfdf&password=dfdfd" "http://jiangchuan.info/php/index.php"

#-----------remote test
#curl -d "email=dfdf&password=dfdfd&verificationCode=1233" "http://api.jiangchuan.info/v1/account/register" 
#curl -d "email=hejc09@gmail.com&password=hjc" "http://api.jiangchuan.info/v1/account/login"
#curl "http://api.jiangchuan.info/v1/events?authToken=41dea62eb76b6fcf88ba9a4834376001&range=month&offset=2&limit=5"
