<?php


class Messages_model extends CI_Model {
	
	
	public function getMessages(){
		
		$cid=$this->session->userdata('cid');
		
		$messages=$this->db->query("SELECT m.mId, CONCAT(p.FirstName, ' ',p.MiddleName,' ',p.LastName) AS Sender, m.mSubject, m.mDetails, mTimestamp FROM bpas_messages m 
		LEFT JOIN bpas_user_profiles p ON m.senderId=p.cid
		WHERE receiverId ='".$cid."' ORDER BY mTimestamp DESC LIMIT 3");
		
		return $messages;
		
	}
	
	public function getCountMessages(){
			$cid=$this->session->userdata('cid');
		
		$messages=$this->db->query("SELECT COUNT(*) AS count FROM bpas_messages m 
		LEFT JOIN bpas_user_profiles p ON m.senderId=p.cid
		WHERE receiverId ='".$cid."' AND flag='1'");
		foreach($messages->result() as $message){
			
			$count=$message->count;
		}
		return $count;
		
	}
	
	public function singleMessage($messageId){
		
		
		$message=$this->db->query("SELECT m.mId, CONCAT(p.FirstName, ' ',p.MiddleName,' ',p.LastName) AS Sender, m.mSubject AS subject, m.mDetails AS message, mTimestamp AS time FROM bpas_messages m 
		LEFT JOIN bpas_user_profiles p ON m.senderId=p.cid
		WHERE m.mId='".$messageId."'");
		$this->flagMessage($messageId);
		return $message;
		
	}
	
	public function flagMessage($messageId){
				
			$update=$this->db->query("UPDATE bpas_messages SET flag='0' WHERE mId='".$messageId."'");
			
		
	}
	
	public function allMessages(){
		
		$cid=$this->session->userdata('cid');
		$messages= $this->db->query("SELECT m.mId, CONCAT(p.FirstName, ' ',p.MiddleName,' ',p.LastName) AS Sender, m.mSubject AS subject, m.mDetails AS message, mTimestamp AS time FROM bpas_messages m 
		LEFT JOIN bpas_user_profiles p ON m.senderId=p.cid
		WHERE receiverId='".$cid."'");
		foreach($messages->result() as $message){
			
			$mId=$message->mId;
			$this->flagMessage($mId);
		}
		return $messages;
	
	}
	
	public function insertMessage($msg,$sender,$subject,$receiver){
			$result=$this->db->query("INSERT INTO bpas_messages (`senderId`,`receiverId`,`mSubject`,`mDetails`) 
			VALUES ('".$sender."','".$receiver."', '".$subject." ', '".$msg."')");
			
		
	}
}
