<?php


class Training_model extends CI_Model {
	
	
	public function addTraining($cid,$title,$ttype,$country,$university,$funding,$reportandcert,$approvalletter,$status,$startdate,$enddate,$appdate) {
		
		$query=$this->db->query("SELECT * FROM bpas_user_profiles WHERE cid='".$cid."'");
		foreach($query->result() as $row){
				
		$agency=$row->AgencyID;
		
		}
		$result=$this->db->query("INSERT INTO bpas_training_record (`userId`,`title`,`AgencyID`, `type`,`country`,`university`, `funding`,`reportandcert`,`approvalLetter`,`trainingStatus`,`startdate`,`enddate`,`approvalDate`) 
		VALUES ('".$cid."', '".$title."', '".$agency."', '".$ttype."', '".$country."', '".$university."', '".$funding."','".$reportandcert."','".$approvalletter."', '".$status."', '".$startdate."', '".$enddate."', '".$appdate."')");
		if($result){
			
			return true;
		} else return false;
	}
	
	
	public function getRecords($agency){
		
		$result=$this->db->query("SELECT tr.title, tr.type,tr.startdate,tr.enddate,tr.country,tr.university,tr.funding,tr.trainingStatus,tr.reportandcert,tr.approvalLetter, tr.approvalDate,  CONCAT (p.FirstName, ' ',p.MiddleName, ' ',p.LastName) AS name, p.cid,mp.Description AS positiontitle, a.name AS division, p.Grade from bpas_training_record tr 
						LEFT JOIN bpas_user_profiles p ON p.cid=tr.userId
						LEFT JOIN bpas_master_agency a ON a.AgencyID=tr.AgencyID
						LEFT JOIN masterposition mp ON mp.PositionID = p.PositionTitle
						WHERE p.AgencyID='".$agency."'
						ORDER BY p.Grade AND p.cid");
		
		return $result;
		
	}
	
}
