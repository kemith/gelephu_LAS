<?php



class ATD_model extends CI_Model {
	
	
	
	
	public function checkattendance($date, $cid) {
		
		$this->db->where('date',$date);
		$this->db->where('userid',$cid);
		
		$result = $this->db->get('bpas_attendance_log');
		
		if($result->num_rows()>=1){
			
			
			foreach($result->result() as $row){
				$atdtime=$row->atdtime;
				$data = array (
				
				'atd_time' => $atdtime
				
				
				);
				
				$this->session->set_userdata($data);
			}
			return true;
			
		} else {
			
			return false;
			
		}
		
		
		
	}
	
	public function checkloggedin(){
		
		if($this->session->userdata('logged_in')!='1'){
			redirect('ATD/login');
		}
	}
	
	public function dailyAttendance() {
		
		$divisionSelected = $this->session->userdata('divFeed');
		
		if($divisionSelected==null){
			
			$divisionSelected=$this->session->userdata('divName');
			$data = array (
			'divFeed' => $divisionSelected
			);
			$this->session->set_userdata($data);
			$query="SELECT 
	
		CONCAT(bpas_user_profiles.FirstName,' ',bpas_user_profiles.MiddleName,' ', bpas_user_profiles.LastName) AS name, 
		bpas_master_agency.name AS Agency,
		bpas_attendance_log.atdtime,
		bpas_attendance_log.status,
		bpas_attendance_log.statusRemarks,
		bpas_user_profiles.telephone
		FROM bpas_user_profiles
		LEFT JOIN bpas_attendance_log ON bpas_attendance_log.userid=bpas_user_profiles.cid  AND bpas_attendance_log.date='".date('Y/m/d')."'
		LEFT JOIN bpas_master_agency ON bpas_master_agency.AgencyID=bpas_user_profiles.AgencyID
		WHERE bpas_master_agency.name='".$this->session->userdata('divFeed')."'
		ORDER BY FIELD(bpas_user_profiles.Grade,'EX1','EX2','EX3','P1','P2','P3','P4','P5','S1','S2','S3','S4','S5','SS1','SS2','SS3','SS4','O1','O2','O3','O4','GSP1','GSP2','ESP') ";

		$result = $this->db->query($query);
		return $result;
		} elseif($divisionSelected=="All"){
			
			$query="SELECT CONCAT(bpas_user_profiles.FirstName,' ',bpas_user_profiles.MiddleName,' ', bpas_user_profiles.LastName) AS name, 
			bpas_master_agency.name AS Agency, bpas_attendance_log.atdtime, bpas_attendance_log.status,bpas_attendance_log.statusRemarks, bpas_user_profiles.telephone 
			FROM bpas_user_profiles 
			LEFT JOIN bpas_attendance_log ON bpas_attendance_log.userid=bpas_user_profiles.cid AND bpas_attendance_log.date='".date('Y/m/d')."' 
			LEFT JOIN bpas_master_agency ON bpas_master_agency.AgencyID=bpas_user_profiles.AgencyID 
			ORDER BY FIELD(bpas_user_profiles.Grade,'EX1','EX2','EX3','P1','P2','P3','P4','P5','S1','S2','S3','S4','S5','SS1','SS2','SS3','SS4','O1','O2','O3','O4','GSP1','GSP2','ESP')";

		$result = $this->db->query($query);
		return $result;
			
			
		} else {
		
		$query="SELECT 
	
		CONCAT(bpas_user_profiles.FirstName,' ',bpas_user_profiles.MiddleName,' ', bpas_user_profiles.LastName) AS name, 
		bpas_master_agency.name AS Agency,
		bpas_attendance_log.atdtime,
		bpas_attendance_log.status,
		bpas_attendance_log.statusRemarks,
		bpas_user_profiles.telephone
		FROM bpas_user_profiles
		LEFT JOIN bpas_attendance_log ON bpas_attendance_log.userid=bpas_user_profiles.cid  AND bpas_attendance_log.date='".date('Y/m/d')."'
		LEFT JOIN bpas_master_agency ON bpas_master_agency.AgencyID=bpas_user_profiles.AgencyID
		WHERE bpas_master_agency.name='".$this->session->userdata('divFeed')."' 
		ORDER BY FIELD(bpas_user_profiles.Grade,'EX1','EX2','EX3','P1','P2','P3','P4','P5','S1','S2','S3','S4','S5','SS1','SS2','SS3','SS4','O1','O2','O3','O4','GSP1','GSP2','ESP')";
		$result = $this->db->query($query);
		return $result;
		}
		
		
	}
	
	
	
	
	
	public function putAttendance($date,$cid,$time){
		
		if(strtotime($time)>strtotime('09:00:00AM')){
		$sql = "INSERT IGNORE INTO bpas_attendance_log (atdtime, userid, date,Late) VALUES (".$this->db->escape($time).", ".$this->db->escape($cid).", ".$this->db->escape($date).",'1')";
		$this->db->query($sql);
		} else{
			
			$sql = "INSERT IGNORE INTO bpas_attendance_log (atdtime, userid, date,Late) VALUES (".$this->db->escape($time).", ".$this->db->escape($cid).", ".$this->db->escape($date).",'2')";
		$this->db->query($sql);
		}
		if($this->db->affected_rows()==1)
		{
			return true;
		} else return false;
		
	}
	
	
	public function userstatus($decodedstatus,$remarks){
		
		//$decodedstatus = urldecode($status);
		$query = "UPDATE `bpas_attendance_log` SET `status` = '".$decodedstatus."', `statusRemarks` = '".$remarks."' WHERE `date` = '".date('Y/m/d')."' AND `userid`='".$this->session->userdata('cid')."'";
		
		if($this->db->query($query)){
					return true;
				
			
		} else return false;
		
	}
	
	public function checkholiday($date) {
			
		$this->db->where('date',$date);
		$result=$this->db->get('bpas_holidays');
		if($result->num_rows()>=1){		
			return true;
		} else return false;
	
	}
	
	
	public function monthreport($month,$year,$agency){
		
	
		$startdate="01-".$month."-".$year;
		$starttime=strtotime($startdate);
		$endtime=strtotime("+1 month",$starttime);
		$result=array();
		$i=$starttime;
		$days=1;
		for($i=$starttime;$i<$endtime;$i+=86400) {
			$e=1;
			//$days=1;
				$query=$this->db->query("SELECT CONCAT(bpas_user_profiles.FirstName,' ',bpas_user_profiles.MiddleName,' ', bpas_user_profiles.LastName) AS name, 
				bpas_master_agency.name AS Agency, 
				bpas_attendance_log.Late, 
				bpas_user_profiles.telephone FROM bpas_user_profiles 
				LEFT JOIN bpas_attendance_log ON bpas_attendance_log.userid=bpas_user_profiles.cid AND bpas_attendance_log.date='".date('Y/m/d',$i)."' 
				LEFT JOIN bpas_master_agency ON bpas_master_agency.AgencyID=bpas_user_profiles.AgencyID WHERE bpas_master_agency.AgencyID='".$agency."'
				ORDER BY bpas_user_profiles.profileId");
			
			//$result[$d]=$query;
			//return $query;
			 foreach($query->result() as $row){
				$result[$e][$days]=$row;
			 $e++;
			 }
			
			$days++;
		}
		$result[0][0]=$days;
		$result[0][1]=$e;
		return $result;
	
	}

public function monthreportall($month,$year){
		
	
		$startdate="01-".$month."-".$year;
		$starttime=strtotime($startdate);
		$endtime=strtotime("+1 month",$starttime);
		$result=array();
		$i=$starttime;
		$days=1;
		for($i=$starttime;$i<$endtime;$i+=86400) {
			$e=1;
			//$days=1;
				$query=$this->db->query("SELECT CONCAT(bpas_user_profiles.FirstName,' ',bpas_user_profiles.MiddleName,' ', bpas_user_profiles.LastName) AS name, 
				bpas_master_agency.name AS Agency, 
				bpas_attendance_log.Late, 
				bpas_user_profiles.telephone FROM bpas_user_profiles 
				LEFT JOIN bpas_attendance_log ON bpas_attendance_log.userid=bpas_user_profiles.cid AND bpas_attendance_log.date='".date('Y/m/d',$i)."' 
				LEFT JOIN bpas_master_agency ON bpas_master_agency.AgencyID=bpas_user_profiles.AgencyID
				ORDER BY bpas_user_profiles.profileId");
			
			//$result[$d]=$query;
			//return $query;
			 foreach($query->result() as $row){
				$result[$e][$days]=$row;
			 $e++;
			 }
			
			$days++;
		}
		$result[0][0]=$days;
		$result[0][1]=$e;
		return $result;
	
	}
public function monthreportsingle($month,$year,$cid){
		
	
		$startdate="01-".$month."-".$year;
		$starttime=strtotime($startdate);
		$endtime=strtotime("+1 month",$starttime);
		$result=array();
		$i=$starttime;
		$days=1;
		for($i=$starttime;$i<$endtime;$i+=86400) {
			$e=1;
			//$days=1;
				$query=$this->db->query("SELECT CONCAT(bpas_user_profiles.FirstName,' ',bpas_user_profiles.MiddleName,' ', bpas_user_profiles.LastName) AS name, 
				bpas_master_agency.name AS Agency, 
				bpas_attendance_log.Late, 
				bpas_user_profiles.telephone FROM bpas_user_profiles 
				LEFT JOIN bpas_attendance_log ON bpas_attendance_log.userid=bpas_user_profiles.cid AND bpas_attendance_log.date='".date('Y/m/d',$i)."' 
				LEFT JOIN bpas_master_agency ON bpas_master_agency.AgencyID=bpas_user_profiles.AgencyID 
				WHERE bpas_user_profiles.cid='".$cid."'");
			
			//$result[$d]=$query;
			//return $query;
			 foreach($query->result() as $row){
				$result[$e][$days]=$row;
			 $e++;
			 }
			
			$days++;
		}
		$result[0][0]=$days;
		$result[0][1]=$e;
		return $result;
	
	}
	
	public function lateCount(){
		$cid=$this->session->userdata('cid');
		$role=$this->session->userdata('role');
		
		if($role=='1'){
		$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' AND late='1'");
		foreach($result->result() as $row){
			
			$count = $row->count;		
			}
		} elseif($role=='2'){
			$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' 
			AND late='1'");
			foreach($result->result() as $row){
			
				$count = $row->count;		
			}	
			
		} elseif($role=='3'){
			$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' 
			AND late='1' AND userId IN ( SELECT e.cid from bpas_user_profiles e
							LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
							WHERE (p.director = '".$cid."' OR p.offtg= '".$cid."'))");
			foreach($result->result() as $row){
			
				$count = $row->count;		
			}	
			
		} elseif($role=='4'){
			$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' 
			AND late='1' AND userId IN ( SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."'))");
			foreach($result->result() as $row){
			
				$count = $row->count;		
			}	
			
		} elseif($role=='7'){
			$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' 
			AND late='1'");
			foreach($result->result() as $row){
			
				$count = $row->count;		
			}	
			
		} elseif($role=='8'){
					$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' 
			AND late='1' AND userId IN ( 							SELECT e.cid from bpas_user_profiles e
							LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
							WHERE (p.director = '".$cid."' OR p.offtg='".$cid."') AND e.roleId='4' 
							UNION ALL
							SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."'))");
			foreach($result->result() as $row){
			
				$count = $row->count;		
			}	
				
			
		} elseif($role=='9'){
					$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' 
			AND late='1' AND userId IN ( SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."') )");
			foreach($result->result() as $row){
			
				$count = $row->count;		
			}	
		
		
		}
		return $count;
	
	}
	public function lateOfficials(){
				
			$cid=$this->session->userdata('cid');
			$role=$this->session->userdata('role');
			if($role=='1'){				
			$result = $this->db->query("SELECT CONCAT(e.FirstName, ' ',e.MiddleName,' ',e.LastName) AS Name,l.atdtime, a.name AS AgencyName, p.name AS ParentAgencyName, e.Grade, mp.Description AS PositionTitle FROM bpas_user_profiles e
			LEFT JOIN bpas_attendance_log l ON e.cid = l.userid
			LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
			LEFT JOIN bpas_master_agencyparent p ON e.AgencyParentID = p.AgencyParentID
			LEFT JOIN masterposition mp ON mp.PositionID = e.PositionTitle
			WHERE l.date='".date('Y/m/d')."' AND l.Late = '1'");
			} elseif($role=='2'|| $role=='7'){
					$result = $this->db->query("SELECT CONCAT(e.FirstName, ' ',e.MiddleName,' ',e.LastName) AS Name,l.atdtime, a.name AS AgencyName, p.name AS ParentAgencyName, e.Grade, mp.Description AS PositionTitle FROM bpas_user_profiles e
						LEFT JOIN bpas_attendance_log l ON e.cid = l.userid
						LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
						LEFT JOIN bpas_master_agencyparent p ON e.AgencyParentID = p.AgencyParentID
						LEFT JOIN masterposition mp ON mp.PositionID = e.PositionTitle
						WHERE l.date='".date('Y/m/d')."' AND l.Late = '1'");
				
			} elseif($role=='3'|| $role=='8'){
					$result = $this->db->query("SELECT CONCAT(e.FirstName, ' ',e.MiddleName,' ',e.LastName) AS Name,l.atdtime, a.name AS AgencyName, p.name AS ParentAgencyName, e.Grade, mp.Description AS PositionTitle FROM bpas_user_profiles e
						LEFT JOIN bpas_attendance_log l ON e.cid = l.userid
						LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
						LEFT JOIN bpas_master_agencyparent p ON e.AgencyParentID = p.AgencyParentID
						LEFT JOIN masterposition mp ON mp.PositionID = e.PositionTitle
						WHERE l.date='".date('Y/m/d')."' AND l.Late = '1' AND l.userId IN ( SELECT e.cid from bpas_user_profiles e
							LEFT JOIN bpas_master_agencyparent p ON p.AgencyParentID = e.AgencyParentID
							WHERE (p.director = '".$cid."' OR p.offtg='".$cid."')
							UNION ALL
							SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief ='".$cid."' OR a.offtg='".$cid."'))");
				
			} elseif($role=='4' || $role=='9'){
					$result = $this->db->query("SELECT CONCAT(e.FirstName, ' ',e.MiddleName,' ',e.LastName) AS Name,l.atdtime, a.name AS AgencyName, p.name AS ParentAgencyName, e.Grade, mp.Description AS PositionTitle FROM bpas_user_profiles e
						LEFT JOIN bpas_attendance_log l ON e.cid = l.userid
						LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
						LEFT JOIN bpas_master_agencyparent p ON e.AgencyParentID = p.AgencyParentID
						LEFT JOIN masterposition mp ON mp.PositionID = e.PositionTitle
						WHERE l.date='".date('Y/m/d')."' AND l.Late = '1' AND l.userId IN ( SELECT e.cid from bpas_user_profiles e 
							LEFT JOIN bpas_master_agency a ON a.AgencyID = e.AgencyID
							WHERE (a.chief = '".$cid."' OR a.offtg='".$cid."'))");
				
			}
			return $result;
		
	}
	
	
	public function leaveCountAll(){
		$result = $this->db->query("SELECT COUNT(*) as count FROM bpas_attendance_log WHERE date='".date('Y/m/d')."' AND (late BETWEEN '11' AND '24')");
		foreach ($result->result() as $row){
			$count = $row->count;
		}	
			return $count;
		
	}

	public function notUsedAll(){
			 $agenciesimplemented="2698,2702,2705,2698,2707,2712,2713, 6887,6889,6890,6917,6920,6921,6922,6929,6930,6931,6934,6935,6936";
                        $result = $this->db->query("SELECT COUNT(*) as count FROM bpas_user_profiles p
                        LEFT JOIN bpas_attendance_log a ON p.cid = a.userid AND a.date='".date('Y/m/d')."' WHERE a.Late IS NULL AND AgencyID IN (".$agenciesimplemented.")");
                        foreach ($result->result() as $row){
                        $count = $row->count;
                }
                        return $count;

		
	}
	
}
