<?php


class Holidays extends CI_Model {
	
	public function countHolidays($start,$end) {
		
		 $query = "SELECT COUNT(*) as count FROM `bpas_holidays` WHERE `date`>='".$start."' && `date`<='".$end."'";
	// $query = "SELECT COUNT(*) as count FROM `bpas_holidays` WHERE `date`>'2016/10/01' && `date`<'2016/11/30'";
		$result = $this->db->query($query);
		
		return $result;
		
		
	}
	public function listHolidays(){
		
		
		//$holidays = $this->db->query("SELECT * FROM bpas_holidays GROUP BY name ORDER BY date ASC");
		$holidays = $this->db->query("SELECT * FROM bpas_holidays");
		return $holidays;
	}
	
	public function holidaysMonth($month,$year){
		
		$result= $this->db->query("SELECT * from bpas_holidays t WHERE MONTH(t.date)='".$month."' AND YEAR(t.date)='".$year."'");
		$holidays = array();
		foreach($result->result() as $row){
			$hdate=strtotime($row->date);
			$holidays[] = date('d',$hdate);
		}
		return $holidays;
	}
	
	public function insertHoliday($startdate,$enddate,$name){
		
		
		$s=$startdate;
		$e=$enddate;
		
		for($i=$s;$i<=$e;$i+=86400){
			
			$result = $this->db->query("INSERT INTO bpas_holidays (`name`,`date`) VALUES ('".$name."', '".date('Y/m/d',$i)."') ");
			
		}
	}
	
}
