// Open Bank Project

// Copyright 2011,2014 TESOBE / Music Pictures Ltd.

// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

// http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

// Open Bank Project (http://www.openbankproject.com)
// Copyright 2011,2014 TESOBE / Music Pictures Ltd

// This product includes software developed at
// TESOBE (http://www.tesobe.com/)
// by
// TESOBE: contact AT tesobe DOT com
// Nina Gänsdorfer: nina AT tesobe DOT com

var express = require('express');
var util = require('util');
var oauth = require('oauth');
 
var app = express();
 

// To get the values for the following fields, please register your client here: 
// https://apisandbox.openbankproject.com/consumer-registration

//API 
/*
var _openbankConsumerKey = "jzmeleqiqmdkr1vazgmdisulfgyzgjpjpja5hkia";
var _openbankConsumerSecret = "fem20s1wbtaqhnmbqrrli3ssbta0gn2bgecydkct";
 */


// SANDBOX 

var _openbankConsumerKey =  "r5wqxt4yiptnrbe00dhuiukhmjlytyhyw5uogp0i";
var _openbankConsumerSecret = "bufzktpzdn5oadhyigo3olq0nikhgwdwhzwfgpob";

var consumer = new oauth.OAuth(
  'https://apisandbox.openbankproject.com/oauth/initiate',
  'https://apisandbox.openbankproject.com/oauth/token',
  _openbankConsumerKey,
  _openbankConsumerSecret,
  '1.0', 
  'http://127.0.0.1:8080/callback', 
  'HMAC-SHA1');


app.configure(function(){
    app.use(express.cookieParser());
    app.use(express.session({ secret: "very secret" }));
});

app.get('/connect', function(req, res)
{
   consumer.getOAuthRequestToken(function(error, oauthToken, oauthTokenSecret, results){
       if (error) {
           res.send("Error getting OAuth request token : " + util.inspect(error), 500);
       } else {
           req.session.oauthRequestToken = oauthToken;
           req.session.oauthRequestTokenSecret = oauthTokenSecret;
           res.redirect("https://apisandbox.openbankproject.com/oauth/authorize?oauth_token=" + req.session.oauthRequestToken);

           //res.redirect("http://lionsrace.altervista.org/st/login.html?oauth_token="+req.session.oauthRequestToken);
           //document.getElementsByClassName("username").value = "filip.ter@gmail.com";
           //document.getElementsByClassName("password").value = "12341234";
       }
   });
});


app.get('/callback', function(req, res){
    console.log("get access token2");
    consumer.getOAuthAccessToken(req.session.oauthRequestToken, req.session.oauthRequestTokenSecret, req.query.oauth_verifier, function(error, oauthAccessToken, oauthAccessTokenSecret, results) {
        if (error) {
            res.send("Error getting OAuth access token : " + util.inspect(error) + "["+oauthAccessToken+"]"+ "["+oauthAccessTokenSecret+"]"+ "["+util.inspect(results)+"]", 500);
        } else {
            req.session.oauthAccessToken = oauthAccessToken;
            req.session.oauthAccessTokenSecret = oauthAccessTokenSecret; 
            res.redirect('/getBanks');  
        }
    });
});

app.get('/getBanks', function(req, res){
    //banks/BANK_ID/accounts/ACCOUNT_ID/VIEW_ID/account
    consumer.get("https://apisandbox.openbankproject.com/obp/v1.3.0/banks/rbs/accounts/MyAccount/owner/account",
    req.session.oauthAccessToken,
    req.session.oauthAccessTokenSecret,
    function (error, data, response) {
        var parsedData = JSON.parse(data);
        var balance = parsedData.balance["amount"]; 
        var currency = parsedData.balance["currency"]; 
        var name    = parsedData.owners[0].display_name;
        res.redirect('http://lionsrace.altervista.org/st/loginSuccess.php?name=' + name + ' &balance=' + balance + '&currency=' + currency);  

        //res.redirect('http://lionsrace.altervista.org/st/loginSuccess.php?' + );

    });
});


app.get('*', function(req, res){
    res.redirect('/connect');
});
 
app.listen(8080);

