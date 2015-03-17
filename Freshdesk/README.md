 yii-freshdesk
===========

Yii Extension for the FreshDesk API


### Installation

in your **main.php** your configuration would look like this

```php
	'freshdesk' => array(
		'class' => 'ext.freshdesk.Freshdesk',
		'token' => 'YOUR API KEY', //From Freshdesk Account Settings
		'freshdeskurl' => 'YOUR FRESHDESK URL', // Verify if you are using https, and change accordingly!
	  ),
```

in your **Controller file** your code would look this

**Create Ticket using Freshdesk**

```php

	$freshdesk = Yii::app()->freshdesk;
	$email = "YOUR EMAIL";
	$subject = "YOUR SUBJECT";
	$description = "YOUR DESCRIPTION";
	$freshdesk->createTicket($email,$subject,$description);

```

**Get All Tickets using Freshdesk**  

```php

	$freshdesk = Yii::app()->freshdesk;
	$page = "YOUR PAGE NUMBER"; //Default is set 1
	$freshdesk->getAllTickets($page);

```

**Get Ticket By TICKET ID using Freshdesk**  

```php

	$freshdesk = Yii::app()->freshdesk;
	$ticketId = "YOUR TICKET ID";
	$freshdesk->getSingleTicket($ticketId);

```

**Filter Tickets By User Email using Freshdesk**  

```php

	$freshdesk = Yii::app()->freshdesk;
	$email = "USER EMAIL";
	$freshdesk->getUserTickets($email);

```

**Get Ticket Fields using Freshdesk**  

```php

	$freshdesk = Yii::app()->freshdesk;
	$freshdesk->getTicketFields();

```

**Get Users using Freshdesk**  

```php

	$freshdesk = Yii::app()->freshdesk;
	$page = "YOUR PAGE NUMBER"; //Default is set 1
	$freshdesk->getAllUsers($page);

```

**Get Users by USER ID using Freshdesk**  

```php

	$freshdesk = Yii::app()->freshdesk;
	$user_id = "USER ID";
	$freshdesk->getSingleUser($user_id);

```


Class Structure
===========

 * token                - Your API_key set in config.
 * freshdeskurl         - Your freshdesk url set in config.
 * createTicket         - Create ticket with email,subject and description
 * getAllTickets        - Returns Tickets
 * getSingleTicket      - Get ticket by ticket ID
 * getUserTickets       - Helper function which returns criteria for all tickets
                          associated with email
 * getTicketFields      - Return all the fields used in tickets.
 * getAllUsers          - Returns Users
 * getSingleUser        - Get User by User ID
 * CurlWrap             - Curl Wrapper for Curling Freshdesk API

 
