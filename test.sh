#! /bin/bash

# script for testing WRCA rest API

# test site
# 1 means on localhost
# 2 means on api.jiangchuan.info
TEST_SITE=1

# scheme & domain
DOMAIN=
SCHEME=http://

# params
email=hejc09@buffalo.edu
password=366213
verificationCode=1234
name=jiangchuan
regId=adfdafdlksajkdllksdjhfkhgd3423fdo

if [ $TEST_SITE -eq 1 ];
then
    DOMAIN=localhost
else
    DOMAIN=api.jiangchuan.info
fi

URL="$SCHEME$DOMAIN/v1/gcm/register?"
POST_DATA="email=$email&regId=$regId&name=$name"
echo
echo $POST_DATA
echo
echo $URL
echo
curl -d $POST_DATA $URL

exit 0;

# test get verification code
echo "test api:get  /account/verificationCode"
URL="$SCHEME$DOMAIN/v1/account/verificationCode?email=$email&password=$password&verificationCode=$verificationCode"
echo "$URL"
curl $URL

echo
echo
# test get /account/register
echo 'test api:post /account/register'
URL="$SCHEME$DOMAIN/v1/account/register?
POST_DATA="email=$email&password=$password&verificationCode=$verificationCode"
echo $POST_DATA
echo $URL
curl -d $POST_DATA $URL

echo
echo

# test post /account/login
URL="$SCHEME$DOMAIN/v1/account/login?
POST_DATA="email=$email&password=$password&verificationCode=$verificationCode"
echo $POST_DATA
echo $URL
curl -d $POST_DATA $URL

# test "login
#curl "http://localhost/v1/account/login?email=hejc09@gmail.com&password=hjc" 

# test "password"
#curl "http://localhost/v1/account/password?email=hejc09@gmail.com" 

# test "events"
#curl "http://localhost/v1/events?authToken=41dea62eb76b6fcf88ba9a4834376001&range=all&offset=1&limit=5"

#Curl -d "email=dfdf&password=dfdfd" "http://api.jiangchuan.info/v1/account/login" 
#curl -d "object=login&email=dfdf&password=dfdfd" "http://jiangchuan.info/php/index.php"

#-----------remote test
#curl -d "email=df@buffalo.edu&password=dfdfd&verificationCode=1233" "http://api.jiangchuan.info/v1/account/register" 
#curl -d "email=hejc09@gmail.com&password=hjc" "http://api.jiangchuan.info/v1/account/login"
#curl "http://api.jiangchuan.info/v1/events?authToken=e4a2cf05fff529d6e1b32cb54c6213aa&range=all&offset=2&limit=5"
