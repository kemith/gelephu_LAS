<?php


class Leave_model extends CI_Model{
	
	public function __construct(){
	$this->load->model('Messages_model','mm');
	$this->load->model('Email_model','em');
		
		
	}
	
	public function listallType(){
		
		$result = $this->db->query("SELECT * FROM `bpas_leave_master`");
		return $result;
		
	}
	
	public function leaveHistory($cid){
		
		$leavehistory = $this->db->query("SELECT l.leaverecordId AS lid, m.ltitle AS leaveType, s.statusDetail AS status, l.startDate,l.endDate, l.leaveDays, l.datePermission, l.remarks,l.sRemarks FROM  `bpas_leave_record` l 
									LEFT JOIN `bpas_leave_status_master` s ON l.status = s.statusID
									LEFT JOIN `bpas_leave_master` m 
									
									ON l.leaveType = m.lid WHERE l.userId = '".$cid."'
									ORDER BY l.leaverecordId DESC");
		return $leavehistory;
	}
	
	public function submitLeave($start,$end,$division,$leavedays,$leavetype,$cid,$remarks,$agencyid){
		
		$success=false;
			
			if($leavetype=='4'){
				$result=$this->db->query("INSERT INTO `bpas_leave_record` (`leaveType`, `userId`, `status`, `startDate`, `endDate`, `leaveDays`,`AgencyID`,`Remarks`) 
				VALUES ('".$leavetype."', '".$cid."', '0', '".$start."', '".$end."', '".$leavedays."','".$agencyid."','".$remarks."')");
				$this->em->notifyLeaveSupervisor($agencyid,$cid,'5'); // sending email to supervisor
				$success=true;
			} else {
				$r=$this->db->query("INSERT INTO `bpas_leave_record` (`leaveType`,`status`, `userId`, `startDate`, `endDate`, `leaveDays`,`AgencyID`,`Remarks`) 
				VALUES ('".$leavetype."','0', '".$cid."', '".$start."', '".$end."', '".$leavedays."','".$agencyid."','".$remarks."')");
				
					$id=$this->db->query("SELECT `leaverecordId` FROM `bpas_leave_record` WHERE `leaveType`='".$leavetype."' AND `userId`='".$cid."' AND `startDate`='".$start."' AND `endDate`='".$end."'");
					foreach($id->result() as $l){
						$lid=$l->leaverecordId;
						//$this->approve($id);
						$getlid=$this->db->query("UPDATE bpas_leave_record SET status='1', datePermission ='".date('Y/m/d')."' WHERE leaverecordId='".$lid."'");
						if($getlid) {
							$leaves=$this->db->query("SELECT l.userId,l.leaveType,l.startDate,l.endDate,m.ltitle AS leaveName FROM bpas_leave_record l 
							LEFT JOIN bpas_leave_master m ON l.leaveType=m.lid WHERE leaverecordId='".$lid."'");
						
							foreach($leaves->result() as $leave){
								
								$cid=$leave->userId;
								$leaveType=$leave->leaveType+10;
								$leaveName=$leave->leaveName;
								$startDate=strtotime($leave->startDate);
								$endDate=strtotime($leave->endDate);
								for($i=$startDate;$i<=$endDate;$i+=86400){
									$this->db->query("INSERT IGNORE INTO bpas_attendance_log (`atdtime`,`userid`,`date`,`late`,`status`,`lid`) 
									VALUES ('NA','".$cid."','".date('Y/m/d',$i)."','".$leaveType."', '".$leaveName."','".$lid."')");
								}
				
							}
							$msg="Your leave has been approved from ".$start." to ".$end;
							$this->mm->insertMessage($msg,"Admin","Leave Approved",$cid);
							$success=true;
			//return true;
					}
						
					
				}
				
			}
		return $success;
		// if($result){
			// return true;
		// } else { return false;}
	}
	
	
	
	public function submitLeaveSupervisor($start,$end,$division,$leavedays,$leavetype,$cid,$remarks,$agencyid,$offtgrole,$headrole,$offtg){
			
	$role=$this->session->userdata('role');			
	if($leavetype=='4' && $role!=2 && $role!=7){
			$offtgId = $this->pendingOfftg($headrole,$offtgrole,$cid,$offtg,$start,$end,$remarks);
				if($offtgId!=null){
				$result=$this->db->query("INSERT INTO `bpas_leave_record` (`leaveType`, `userId`, `status`, `startDate`, `endDate`, `leaveDays`,`AgencyID`,`Remarks`,`offtgId`) 
				VALUES ('".$leavetype."', '".$cid."', '0', '".$start."', '".$end."', '".$leavedays."','".$agencyid."','".$remarks."', '".$offtgId."')");
				$success=true;
				$this->em->notifyLeaveSupervisor($agencyid,$cid,$role); // sending email to supervisor
				} else $success=false;
				
			} else {
				$r=$this->db->query("INSERT INTO `bpas_leave_record` (`leaveType`,`status`, `userId`, `startDate`, `endDate`, `leaveDays`,`AgencyID`,`Remarks`) 
				VALUES ('".$leavetype."','0', '".$cid."', '".$start."', '".$end."', '".$leavedays."','".$agencyid."','".$remarks."')");
				
					//$id=$this->db->query("SELECT `leaverecordId` FROM `bpas_leave_record` WHERE `leaveType`='".$leavetype."' AND `userId`='".$cid."' AND `startDate`='".$start."' AND `endDate`='".$end."'");
					$lid=$this->db->insert_id();
					
						//$lid=$l->leaverecordId;
						//$this->approve($id);
							
						$getlid=$this->db->query("UPDATE bpas_leave_record SET status='1', datePermission ='".date('Y/m/d')."' WHERE leaverecordId='".$lid."'");
						if($getlid) {
							$leaves=$this->db->query("SELECT l.userId,l.leaveType,l.startDate,l.endDate,m.ltitle AS leaveName FROM bpas_leave_record l 
							LEFT JOIN bpas_leave_master m ON l.leaveType=m.lid WHERE l.leaverecordId='".$lid."'");
							$assignOff=$this->assignOfftg($headrole,$offtgrole,$cid,$offtg,$start,$end,$remarks);
							if($assignOff){
								$msg="Your leave has been approved from ".strtotime($start)." to ".strtotrime($end)."";
								$this->mm->insertMessage($msg,"Admin","Leave Approved",$cid);
								$success=true;
								foreach($leaves->result() as $leave){
								$cid=$leave->userId;
								$leaveType=$leave->leaveType+10;
								$leaveName=$leave->leaveName;
								$startDate=strtotime($leave->startDate);
								$endDate=strtotime($leave->endDate);
								for($i=$startDate;$i<=$endDate;$i+=86400){
									$this->db->query("INSERT IGNORE INTO bpas_attendance_log (`atdtime`,`userid`,`date`,`late`,`status`,`lid`) 
									VALUES ('NA','".$cid."','".date('Y/m/d',$i)."','".$leaveType."', '".$leaveName."','".$lid."')");
									}
				
								}
							}
			
						} else $success=false;
					
			}
			
			return $success;
	}						
		
	public function pendingOfftg($headrole,$offtgrole,$head,$offtg,$startDate,$endDate,$remarks) {
					
		$updatelog=$this->db->query("INSERT INTO bpas_officiating_log (`headID`,`offtgID`,`headrole`,`offtgRole`,`startDate`,`endDate`,`remarks`,`status`) 
			VALUES ('".$head."','".$offtg."', '".$headrole."','".$offtgrole."', '".$startDate."','".$endDate."','".$remarks."', '0')");	
			if($updatelog){
				
				return $this->db->insert_id();
				
			} else return null;
					
			
		
	}
			
	public function updateOfftg($offtgId){
		
		if($this->db->query("UPDATE bpas_officiating_log SET `status`='2' WHERE `oId`='".$offtgId."'")) {
			$approved=$this->db->query("SELECT * from bpas_officiating_log WHERE `oId`='".$offtgId."'");
			foreach($approved->result() as $row){
				$this->approveOfftg($row->headID, $row->offtgID, $row->headRole, $row->offtgRole, $row->startDate, $row->endDate);
			}
			
			$this->activateOfftg();
			
		}
		
	}
	
	
	public function activateOfftg(){
				
			$logs=$this->db->query("SELECT * from bpas_officiating_log WHERE `status`='2'AND startDate='".date('Y/m/d')."'");
			foreach($logs->result() as $log){
				
				$id=$log->oId;
				if($this->db->query("UPDATE bpas_officiating_log SET `status`='1' WHERE `oId`='".$id."'")) {
					$agencyids=$this->db->query("SELECT AgencyID, AgencyParentID, AgencyMainParentID FROM bpas_user_profiles WHERE cid='".$log->offtgID."'");
					$agency=$agencyids->row(0);
					
					$this->db->query("INSERT INTO bpas_messages (`senderId`,`receiverId`,`mSubject`,`mDetails`) VALUES
						('".$log->headID."','".$log->offtgID."', 'Officiating Starts today', 'Your officiating role starts today and ends on ".$log->endDate."')");
					if($log->headRole=='2'){
						$this->db->query("UPDATE bpas_master_agencymainparent SET currentOfftg='".$log->offtgID."' WHERE AgencyMainParentID='".$agency->AgencyMainPrentID."'");
						$this->db->query("UPDATE bpas_user_profiles SET roleId='7' WHERE cid='".$log->offtgID."'");
					
				} elseif($log->headRole=='3'){
					$this->db->query("UPDATE bpas_master_agencyparent SET offtg='".$log->offtgID."' WHERE AgencyParentID='".$agency->AgencyParentID."'");
				$this->db->query("UPDATE bpas_user_profiles SET roleId='8' WHERE cid='".$log->offtgID."'");
					
				} elseif($log->headRole=='4'){
					$this->db->query("UPDATE bpas_master_agency SET offtg='".$log->offtgID."' WHERE AgencyID='".$agency->AgencyID."'");
					$this->db->query("UPDATE bpas_user_profiles SET roleId='9' WHERE cid='".$log->offtgID."'");
				}
				}
			}
			$this->revertOfftg();
		
	}
	
	public function approveOfftg($head,$offtg,$headrole,$offtgrole,$startDate,$endDate) {
		
		$message = "You have been assigned as my officiating from ".$startDate." to ".$endDate;
		$subject = "Officiating Order from user :".$head;
		$message=$this->db->query("INSERT INTO bpas_messages (`senderId`,`receiverId`,`mSubject`,`mDetails`) VALUES
						('".$head."','".$offtg."', 'Officiating order', '".$message."')");
		$this->em->sendEmail($message,$subject,$offtg);
						
		
				
		
	}	
			
	public function assignOfftg($headrole,$offtgrole,$head,$offtg,$startDate,$endDate,$remarks){
							
			$updatelog=$this->db->query("INSERT INTO bpas_officiating_log (`headID`,`offtgID`,`headrole`,`offtgRole`,`startDate`,`endDate`,`remarks`,`status`) 
			VALUES ('".$head."','".$offtg."', '".$headrole."','".$offtgrole."', '".$startDate."','".$endDate."','".$remarks."', '2')");			
			if($updatelog){
				
				$this->approveOfftg($head, $offtg, $headrole, $offtgrole, $startDate, $endDate);
				$this->activateOfftg();
				
				
			}
			
		
	}
	
	
	
	public function revertOfftg(){
				
		$today=date("Y/m/d", strtotime("-1 day"));
		
		$result=$this->db->query("SELECT * FROM bpas_officiating_log WHERE endDate ='".$today."' AND status='1'");
		
		foreach($result->result() as $row) {
			$agencyids=$this->db->query("SELECT AgencyID, AgencyParentID, AgencyMainParentID FROM bpas_user_profiles WHERE cid='".$row->offtgID."'");
		$agency=$agencyids->row(0);
			$this->db->query("UPDATE bpas_user_profiles SET roleId='".$row->offtgRole."' WHERE cid='".$row->offtgID."'");
			if($row->headRole=='2'||$row->headRole=='7'){
				$this->db->query("UPDATE bpas_master_agencymainparent SET currentOfftg='".$row->headID."' WHERE AgencyMainParentID='".$agency->AgencyMainParentID."'");
			} elseif($row->headRole=='3'||$row->headRole=='8'){
				$this->db->query("UPDATE bpas_master_agencyparent SET offtg='".$row->headID."' WHERE AgencyParentID='".$agency->AgencyParentID."'");
			} elseif ($row->headRole=='4'||$row->headRole=='9'){
				$this->db->query("UPDATE bpas_master_agency SET offtg='".$row->headID."' WHERE AgencyID='".$agency->AgencyID."'");
			}
			
			$this->db->query("INSERT INTO bpas_messages (`senderId`,`receiverId`,`mSubject`,`mDetails`) VALUES
						('".$row->headID."','".$row->offtgID."', 'Officiating ends today', 'Your officiating role which started on ".$row->startDate." ends today')");
			
			$this->db->query("UPDATE bpas_officiating_log set status='2' WHERE oId='".$row->oId."'"); 
		}
		
			
		
	}
	
	
	public function pendingCount(){
			
		
		$cid=$this->session->userdata('cid');
		$role=$this->session->userdata('role');
		if($role=='1'){
			$pendingLeave=$this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record WHERE leaveType='4' AND status='0'");
			foreach($pendingLeave->result() as $row){
				$count=$row->count;
			}		
		}
		elseif($role=='2'||$role=='7'){
			$pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
							WHERE leaveType='4' AND status='0' AND 
							userId IN (SELECT e.cid from bpas_user_profiles e WHERE (e.roleId ='3' OR e.roleId ='8') AND e.cid<>'".$cid."'
 							UNION ALL
							SELECT e.cid from bpas_user_profiles e
							LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
							WHERE (p.director = '".$cid."' OR p.offtg = '".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
							UNION ALL
							SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief = '".$cid."' OR a.offtg = '".$cid."') AND e.cid<>'".$cid."')");
				
		// $pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
							// WHERE leaveType='4' AND status='0' AND 
							// userId IN (SELECT e.cid from bpas_user_profiles e WHERE e.roleId ='3' AND e.cid<>'".$cid."'
 							// UNION ALL
							// SELECT e.cid from bpas_user_profiles e
							// LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
							// WHERE p.director = '".$cid."' AND e.roleId='4' AND e.cid<>'".$cid."'
							// UNION ALL
							// SELECT e.cid from bpas_user_profiles e 
							// LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							// WHERE a.chief = '".$cid."' AND e.cid<>'".$cid."')");
		foreach($pendingLeave->result() as $row){
				$count=$row->count;
			}		
		} elseif ($role=='3'||$role=='8'){
			$pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
							WHERE leaveType='4' AND status='0' AND 
							userId IN (SELECT e.cid from bpas_user_profiles e
							LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
							WHERE (p.director = '".$cid."' OR p.offtg = '".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
							UNION ALL
							SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief = '".$cid."' OR a.offtg = '".$cid."') AND e.cid<>'".$cid."')");
			// $pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
							// WHERE leaveType='4' AND status='0' AND 
							// userId IN (SELECT e.cid from bpas_user_profiles e
							// LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
							// WHERE p.director = '".$cid."' AND e.roleId='4' AND e.cid<>'".$cid."'
							// UNION ALL
							// SELECT e.cid from bpas_user_profiles e 
							// LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							// WHERE a.chief = '".$cid."' AND e.cid<>'".$cid."')");
			foreach($pendingLeave->result() as $row){
				$count=$row->count;
			}		
			
		}	elseif ($role=='4'||$role=='9'){
			$pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
							WHERE leaveType='4' AND status='0' AND 
							userId IN (SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief='".$cid."' OR a.offtg = '".$cid."') AND e.cid<>'".$cid."')");
			// $pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
							// WHERE leaveType='4' AND status='0' AND 
							// userId IN (SELECT e.cid from bpas_user_profiles e 
							// LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							// WHERE a.chief = '".$cid."' AND e.cid<>'".$cid."')");
			foreach($pendingLeave->result() as $row){
				$count=$row->count;
			}		
									
			} elseif($role=='6') {
			$pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
							WHERE leaveType='4' AND status='0' AND 
							userId IN (SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE a.chief = '".$cid."' AND e.cid<>'".$cid."')");
			foreach($pendingLeave->result() as $row){
				$count=$row->count;
			}				
					
			} /*
			elseif($role=='7'){
							
							$pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
										WHERE leaveType='4' AND status='0' AND 
										userId IN (SELECT e.cid from bpas_user_profiles e WHERE (e.roleId ='3' OR e.roleId ='8') AND e.cid<>'".$cid."'
										 UNION ALL
										SELECT e.cid from bpas_user_profiles e
										LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
										WHERE (p.director = '".$cid."' OR p.offtg = '".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
										UNION ALL
										SELECT e.cid from bpas_user_profiles e 
										LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
										WHERE (a.chief = '".$cid."' OR a.offtg = '".$cid."') AND e.cid<>'".$cid."')");
							foreach($pendingLeave->result() as $row){
							$count=$row->count;
							}
			
						} elseif($role=='8'){
							
							$pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
										WHERE leaveType='4' AND status='0' AND 
										userId IN (SELECT e.cid from bpas_user_profiles e
										LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
										WHERE (p.director = '".$cid."' OR p.offtg = '".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
										UNION ALL
										SELECT e.cid from bpas_user_profiles e 
										LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
										WHERE (a.chief = '".$cid."' OR a.offtg = '".$cid."') AND e.cid<>'".$cid."')");
							foreach($pendingLeave->result() as $row){
							$count=$row->count;
							}
			
						} elseif($role=='9'){
							
							$pendingLeave= $this->db->query("SELECT COUNT(*) AS count FROM bpas_leave_record 
										WHERE leaveType='4' AND status='0' AND 
										userId IN (SELECT e.cid from bpas_user_profiles e 
										LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
										WHERE a.offtg = '".$cid."' AND e.cid<>'".$cid."')");
							foreach($pendingLeave->result() as $row){
							$count=$row->count;
							}
			
						}*/
			
		return $count;
	}
	
	public function pendingLeave(){
				
		$cid=$this->session->userdata('cid');
		$role=$this->session->userdata('role');
		if($role=='1'){
		$pending=$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND r.status='0'");
		} elseif($role=='2'||$role=='7'){
			$pending =$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND r.status='0' 
					AND r.userId IN (SELECT e.cid from bpas_user_profiles e WHERE (e.roleId ='3' OR e.roleId='8') AND e.cid<>'".$cid."'
		 							UNION ALL
									SELECT e.cid from bpas_user_profiles e
									LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
									WHERE (p.director = '".$cid."' OR p.offtg='".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
									UNION ALL
									SELECT e.cid from bpas_user_profiles e 
									LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
									WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."') AND e.cid<>'".$cid."')");			
		} elseif($role=='3'||$role=='8'){
				$pending =$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND r.status='0' 
					AND r.userId IN (SELECT e.cid from bpas_user_profiles e
									LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
									WHERE (p.director = '".$cid."' OR p.offtg='".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
									UNION ALL
									SELECT e.cid from bpas_user_profiles e 
									LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
									WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."') AND e.cid<>'".$cid."')");			
			
		} elseif($role=='4'||$role=='9'){
			$pending =$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND r.status='0' 
					AND r.userId IN (SELECT e.cid from bpas_user_profiles e 
									LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
									WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."') AND e.cid<>'".$cid."')");			
			
			 } 
			 //elseif($role=='7'){
						// $pending =$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.leaverecordId AS lid FROM bpas_leave_record r 
					// LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					// LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					// LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					// LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					// WHERE r.leaveType='4' AND r.status='0' 
					// AND r.userId IN (SELECT e.cid from bpas_user_profiles e WHERE e.roleId ='3' AND e.cid<>'".$cid."'
		 							// UNION ALL
									// SELECT e.cid from bpas_user_profiles e
									// LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
									// WHERE p.director = '".$cid."' AND e.roleId='4' AND e.cid<>'".$cid."'
									// UNION ALL
									// SELECT e.cid from bpas_user_profiles e 
									// LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
									// WHERE a.chief = '".$cid."' AND e.cid<>'".$cid."')");	
// 					
// 				
			// }				
		return $pending;
		
	}
	
	
	public function approve($lid,$remarks){
		
		if($this->db->query("UPDATE bpas_leave_record SET status='1', datePermission ='".date('Y/m/d')."', approvedBy='".$this->session->userdata('cid')."',sRemarks='".$remarks."' WHERE leaverecordId='".$lid."'")) {
			$leaves=$this->db->query("SELECT l.userId,l.leaveType,l.startDate,l.endDate,m.ltitle AS leaveName, l.offtgId FROM bpas_leave_record l 
			LEFT JOIN bpas_leave_master m ON l.leaveType=m.lid WHERE leaverecordId='".$lid."'");
			
			foreach($leaves->result() as $leave){
				$offtgId=$leave->offtgId;
				if($offtgId!=null){
					
					$this->updateOfftg($offtgId);
				}
				
				
				$cid=$leave->userId;
				$leaveType=$leave->leaveType+10;
				$leaveName=$leave->leaveName;
				
				$startDate=$leave->startDate;
				$start=strtotime($startDate);
				$endDate=$leave->endDate;
				$end=strtotime($endDate);
				$msg="Your leave has been approved from ".$startDate." to ".$endDate."";
				$subject = "Leave approved";
				$this->mm->insertMessage($msg,"Admin",$subject,$cid);
				$this->em->sendEmail($msg,$subject,$cid);
				for($i=$start;$i<=$end;$i+=86400){
					$this->db->query("INSERT IGNORE INTO bpas_attendance_log (`atdtime`,`userid`,`date`,`late`,`status`,`lid`) 
					VALUES ('NA','".$cid."','".date('Y/m/d',$i)."','".$leaveType."', '".$leaveName."','".$lid."')");
				}
				
			}
			
			//return true;
		} //else false;
		
	}
	
	public function leaveBalance($cid){
					
				$date=date('Y/m/d');
				$month=date('m', strtotime($date));
				$year=date('Y',strtotime($date));
			if($month>6){
				$nextyear=$year+1;
				$query=$this->db->query("SELECT SUM(leaveDays) as leavetaken from bpas_leave_record WHERE userId = '".$cid."' AND leaveType='4' AND status='1' AND startDate BETWEEN '".$year."/07/01' AND '".$nextyear."/06/01'");
				foreach($query->result() as $row){
					$days=$row->leavetaken;
				}
				$bal=10-$days;
				return $bal;
			} else {
				$lastyear=$year-1;
				$query=$this->db->query("SELECT SUM(leaveDays) as leavetaken from bpas_leave_record WHERE userId = '".$cid."' AND leaveType='4' AND status='1' AND startDate BETWEEN '".$lastyear."/07/01' AND '".$year."/06/01'");
				foreach($query->result() as $row){
					$days=$row->leavetaken;
				}
				$days=$row->leavetaken;
				$bal=10-$days;
				return $bal;
			}
			
		
	}
	
	public function reject($lid,$remarks){
				$cid=$this->session->userdata('cid');
			if($this->db->query("UPDATE bpas_leave_record SET status='2',sRemarks='".$remarks."',approvedBy = '".$cid."'  WHERE leaverecordId='".$lid."'")) {
			$query=$this->db->query("SELECT userId from bpas_leave_record WHERE leaverecordId='".$lid."'");
			foreach($query->result() as $row){
				$userid=$row->userId;
				
			}
			
			$msg="Your leave has been rejected by user :".$cid."\n Remarks :".$remarks.".";
			$subject="Leave rejected!";
			
			$this->mm->insertMessage($msg,"Admin",$subject,$userid);
			$this->em->sendEmail($msg,$subject,$userid);
			return true;
		} else false;
		
	}
	
	public function cancelLeave($lid){
		
		if($this->db->query("DELETE FROM bpas_leave_record WHERE leaverecordId='".$lid."' AND status='0'")){
				return true;
			
		} else return false;
	}

	
	public function getAllLeaveToday(){
		
		$leave=$this->db->query("SELECT CONCAT(e.FirstName, ' ',e.MiddleName,' ',e.LastName) AS Name, lm.ltitle,  a.name AS AgencyName, p.name AS ParentAgencyName, e.Grade, 
			mp.Description AS PositionTitle, lr.startDate AS StartDate, lr.endDate AS EndDate FROM bpas_user_profiles e
			LEFT JOIN bpas_attendance_log l ON e.cid = l.userid
			LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
			LEFT JOIN bpas_master_agencyparent p ON e.AgencyParentID = p.AgencyParentID
			LEFT JOIN masterposition mp ON mp.PositionID = e.PositionTitle
			LEFT JOIN bpas_leave_master lm ON lm.lid+10=l.Late
			LEFT JOIN bpas_leave_record lr ON lr.leaverecordId=l.lid
			WHERE l.date='".date('Y/m/d')."' AND l.Late BETWEEN '11' AND '24'");
		
		return $leave;
		
	}
	
	public function leaveRecord(){
		$cid=$this->session->userdata('cid');
		$role=$this->session->userdata('role');
		if($role=='1'){
			
			$lrecords=$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.sRemarks, r.approvedBy,r.datePermission, r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND (r.status='1' OR r.status='2')");
		}
		elseif($role=='2'||$role=='7'){
		$lrecords=$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.sRemarks, r.approvedBy,r.datePermission, r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND (r.status='1' OR r.status='2')
					AND r.userId IN (SELECT e.cid from bpas_user_profiles e WHERE (e.roleId ='3' OR e.roleId='8') AND e.cid<>'".$cid."'
		 							UNION ALL
									SELECT e.cid from bpas_user_profiles e
									LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
									WHERE (p.director = '".$cid."' OR p.offtg='".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
									UNION ALL
									SELECT e.cid from bpas_user_profiles e 
									LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
									WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."') AND e.cid<>'".$cid."')");
			
		}elseif($role=='3'||$role=='8'){
			
					$lrecords=$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.sRemarks, r.approvedBy,r.datePermission, r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND (r.status='1' OR r.status='2')
					AND r.userId IN (SELECT e.cid from bpas_user_profiles e
									LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
									WHERE (p.director = '".$cid."' OR p.offtg='".$cid."') AND (e.roleId='4' OR e.roleId='9') AND e.cid<>'".$cid."'
									UNION ALL
									SELECT e.cid from bpas_user_profiles e 
									LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
									WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."') AND e.cid<>'".$cid."')");
			
				
			
		} elseif($role=='4'||$role=='9'){
				$lrecords=$this->db->query("SELECT m.ltitle AS leaveType,CONCAT(u.FirstName, ' ', u.LastName) AS name,r.userId AS userId, a.name AS AgencyID, s.statusDetail AS status, r.startDate, r.endDate, r.leaveDays,r.Remarks,r.sRemarks, r.approvedBy,r.datePermission, r.leaverecordId AS lid FROM bpas_leave_record r 
					LEFT JOIN bpas_leave_master m ON m.lid=r.leaveType
					LEFT JOIN bpas_leave_status_master s ON s.statusID=r.status
					LEFT JOIN bpas_user_profiles u ON u.cid=r.userId
					LEFT JOIN bpas_master_agency a ON a.AgencyID=r.AgencyID
					WHERE r.leaveType='4' AND (r.status='1' OR r.status='2')
					AND r.userId IN (SELECT e.cid from bpas_user_profiles e 
									LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
									WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."') AND e.cid<>'".$cid."')");
			
				
			
				}
			
						return $lrecords;
					
				
			
	}
	
}
