# simple prepaid card service

    git clone git@github.com:shivanshuit914/prepaid-card.git
    cd prepaid-card
    composer install

To run the application in development, you can also run this command. 

	php composer.phar start

Run this command to run the test suite

	vendor/bin/phpspec run

Rest API points to create card

	[POST]http://0.0.0.0:8080/v1/card/create
	{
    	"user_details": {
    		"name": "testname",
    		"address": "london. E123SD"
    	}
    }

Rest API point to Load money
    
    [POST]http://0.0.0.0:8080/v1/card/load-money
    {
    	"card_details": {
    		"number": 1493852665647864,
    		"issue": "03-17",
    		"expiry": "03-19",
    		"security": 388
    	},
    	"amount" : 100
    }

Rest API point to authorise
    
    [POST]http://0.0.0.0:8080/v1/card/transaction
    {
    	"card_details": {
    		"number": 1493852665647864,
    		"issue": "03-17",
    		"expiry": "03-19",
    		"security": 388
    	},
    	"merchant_details": {
    		"name" : "Costa",
    		"account_details" : {
    			"sortcode" : 123455,
    			"account_number" : 12343545
    		}
    	},
    	"amount" : 20
    }

Capture Transaction

    [POST]http://0.0.0.0:8080/v1/card/transactionCapture
    {
    	"card_details": {
    		"number": 1493852665647864,
    		"issue": "03-17",
    		"expiry": "03-19",
    		"security": 388
    	},
    	"merchant_details": {
    		"name" : "Costa",
    		"account_details" : {
    			"sortcode" : 123455,
    			"account_number" : 12343545
    		}
    	},
    	"amount" : 20
    }
    
Refund Transaction
    
    [POST]http://0.0.0.0:8080/v1/card/transactionRefund
    {
    	"card_details": {
    		"number": 1493852665647864,
    		"issue": "03-17",
    		"expiry": "03-19",
    		"security": 388
    	},
    	"merchant_details": {
    		"name" : "Costa",
    		"account_details" : {
    			"sortcode" : 123455,
    			"account_number" : 12343545
    		}
    	},
    	"amount" : 20
    }


Get Balances
    
    http://0.0.0.0:8080/v1/card/statement/1493852665647864





