# local test

# test "get verification code"
#curl "http://localhost/v1/account/verificationCode?email=hejc09@gmail.com"

# test "register"
#curl "http://localhost/v1/account/register?email=hejc09@gmail.com&password=hjc&verificationCode=123" 

# test "login
#curl "http://localhost/v1/account/login?email=hejc09@gmail.com&password=hjc" 

# test "password"
#curl "http://localhost/v1/account/password?email=hejc09@gmail.com" 

# test "events"
#curl "http://localhost/v1/events?authToken=&range=all&offset=1&limit=5"
#curl "http://api.jiangchuan.info/v1/events?authToken=75e3dad6cb5b2996f9b17dd6e70ad1bd&range=month&offset=2&limit=5"

#curl -d "email=dfdf&password=dfdfd" "http://api.jiangchuan.info/v1/account/login" 
curl -d "object=login&email=dfdf&password=dfdfd" "http://jiangchuan.info/php/index.php"
