<?php

 /**
 * Freshdesk Extension for Yii
 * Developed by: Dci Development Team
 */
 
class Freshdesk extends CApplicationComponent
{
	public $token;        // value set in config / main.php
    public $freshdeskurl; // value set in config / main.php
    
	 /**
     * @param $email   - should be the user email who send ticket.
     * @param $subject - should be the subject of the ticket.
     * @param $description - should be the description of the ticket.
     * @return the Array
     */
     
	public function createTicket($email="", $subject="", $description="")
	{
		$ticket = array(
		  'helpdesk_ticket[email]' => $email,
		  'helpdesk_ticket[subject]' => $subject,
		  'helpdesk_ticket[description]' => $description,
		);
		$header[] = "Content-type: multipart/form-data";
		$url = "$this->freshdeskurl/helpdesk/tickets.json";
		$response = $this->CurlWrap($url,$ticket,$header);
		if(empty($response))
			return FALSE;
		else
			return $response;
	}
	
	 /**
     * Returns all the tickets
     * @params $page
     * @return bool FALSE if it doesn't exist, the Array otherwise.
     */
     
	public function getAllTickets($page="")
	{
		if(trim($page) == "" || trim($page) == "0" )
			$page = "1";
		$url = "$this->freshdeskurl/helpdesk/tickets.json?filter_name=all_tickets&page=$page";
		
		$response = $this->CurlWrap($url);
		if(empty($response))
			return FALSE;
		else
			return $response;
	}
	
	 /**
     * Returns the Ticket, this method takes the IDs for a ticket.
     * @param $ticketId
     * @return bool FALSE if it doesn't exist, the Array otherwise.
     */
	
	public function getSingleTicket($ticketId="")
	{
		if(!is_numeric(trim($ticketId)))
		{ 
			$response["errors"]["error"] = "Invalid Id";
			return $response;
		}
		
		$url = "$this->freshdeskurl/helpdesk/tickets/$ticketId.json";
		$response = $this->CurlWrap($url);
		if(empty($response))
			return FALSE;
		else
			return $response;
	}
	
	 /**
     * Returns all tickets from the user specified by email address
     * @param $email 
     * @return bool FALSE if it doesn't exist, the Array otherwise.
     */
	
	public function getUserTickets($email="")
	{
		if(empty($email))
		{ 
			$response["errors"]["error"] = "Invalid Email";
			return $response;
		}
		
		$url = "$this->freshdeskurl/helpdesk/tickets.json?email=$email&filter_name=all_tickets";
		$response = $this->CurlWrap($url);
		if(empty($response))
			return FALSE;
		else
			return $response;
	}
	
	 /**
     * Returns the fields available to helpdesk tickets
     * @return bool FALSE if it doesn't exist, the Array otherwise.
     */
     
	public function getTicketFields()
	{
		$url = "$this->freshdeskurl/ticket_fields.json";
		$response = $this->CurlWrap($url);
		if(empty($response))
			return FALSE;
		else
			return $response;
	}
	
	 /**
     * Returns all the Users
     * @params $page
     * @return bool FALSE if it doesn't exist, the Array otherwise.
     */
     
	public function getAllUsers($page ="")
	{
		if(trim($page) == "" || trim($page) == "0" )
			$page = "1";
			
		$url = "$this->freshdeskurl/contacts.json?state=all&page=$page";
		$response = $this->CurlWrap($url);
		if(empty($response))
			return FALSE;
		else
			return $response;
	}
	
	 /**
     * Returns the User, this method takes the IDs for a user.
     * @param $user_id
     * @return bool FALSE if it doesn't exist, the Array otherwise.
     */
     
	public function getSingleUser($user_id="")
	{
		if(!is_numeric(trim($user_id)))
		{ 
			$response["errors"]["error"] = "Invalid Id";
			return $response;
		}
			
		$url = "$this->freshdeskurl/contacts/$user_id.json";
		$response = $this->CurlWrap($url);
		if(empty($response))
			return FALSE;
		else
			return $response;
	}
	
	 /**
     * @param $url - url to curl freshdesk api
     * @param $ticket - Contains the ticket details in array used only for creating ticket.
     * @headers - Type of the header
     * @return Array
     */
     
	protected function CurlWrap($url ="",$ticket ="",$headers ="")
	{
		$ch = curl_init ($url);
		if(!empty($ticket))
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket);
		}
		curl_setopt($ch, CURLOPT_USERPWD, "$this->token:X");
		
		if(!empty($headers))
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$server_output = curl_exec ($ch);  
		$tickets = json_decode($server_output,true);
		curl_close ($ch);
		return $tickets;
	}
}
