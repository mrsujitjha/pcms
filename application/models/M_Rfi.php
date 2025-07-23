<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Rfi extends CI_Model
{
	public function get_Rfi($a)
	{
		if ($a == "") {
			$tm_project = $this->db->get('tabrfi')->result();
		} else {
			$myquery = "SELECT tabrfi.*,(SELECT `action` FROM tabrfiaction WHERE rfiid=tabrfi.rfiid AND (`action`='Approved' OR `action`='Rejected') LIMIT 1)myn FROM tabrfi WHERE tabrfi.rsubid LIKE '" . $a . "%'";
			$tm_project = $this->db->query($myquery)->result();
			return $tm_project;
		}
	}
	public function get_Rfi_activity($a)
	{
		$myquery = "SELECT `rfiid`,`location`,`mdate`,`mtime`,`rem`,`mid`,`muser`,`action` FROM `tabrfi` WHERE `rfiid` = '" . $a . "' UNION SELECT `rfiid`,'-',`mdate`,`mtime`,`rem`,`mid`,`muser`,`action` FROM `tabrfiaction` WHERE `rfiid` = '" . $a . "'";
		$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
	}
	public function get_road()
	{
		$data = array();
		$i = 0;
		$rlist = $this->session->userdata('rlist');
		$myquery = "SELECT * FROM `tabroad`";
		$tm_project = $this->db->query($myquery)->result_array();
		if (strlen($rlist) == 0) {
			return $tm_project;
		} else {
			$rid = explode(',', $rlist);
			foreach ($rid as $r) {
				foreach ($tm_project as $road) {
					if ($road["rid"] == $r) {
						$rowv = array('rid' => $road["rid"], 'rname' => $road["rname"], 'sc' => $road["sc"]);
						$data[] = $rowv;
						break;
					}
				}
			}
			return $data;
		}
	}

	public function get_item()
	{
		$a = "R00";
		if ($this->session->has_userdata('roadid')) {
			$a = $this->session->userdata('roadid');
		}
		$myquery = "SELECT * FROM (SELECT (SELECT if(length(F2.item)-Length(replace(F2.item,itemid,''))>0,itemid,'')
FROM (SELECT GROUP_CONCAT(F1.b) item FROM( SELECT DISTINCT (`tcsid`) b, substring(`roadid`,1,3)a FROM `tabsection` WHERE `roadid` LIKE '" . $a . "%')F1 GROUP BY F1.a) as F2) a,name as b FROM tabitemcode) as F3 WHERE length(F3.a)>0
UNION SELECT Distinct(`itemid`)a,itemname as b FROM `tabstageitem` WHERE `id`LIKE '" . $a . "%'
UNION SELECT DISTINCT (F1.itemid)a, (F1.itemsize)b FROM (SELECT tabitemcode.itemid,tabschedule.itemsize FROM tabschedule LEFT JOIN tabitemcode ON tabschedule.itemsize=tabitemcode.name WHERE tabschedule.itemcode LIKE '" . $a . "%') F1";
		$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
	}
	public function get_item_remaining_ch($b)
	{
		$a = $this->session->userdata('roadid');
		$tinfo = $this->verify_item($b);
		if ($tinfo['unit'] == 'Km') {
			$myquery = "SELECT F2.roadid,CONCAT(F2.fromch ,'-', F2.toch)ch,(F2.l-COALESCE(F1.q, 0))r FROM (SELECT phycode,sum(qyt)q FROM `tabphysical`  WHERE `phycode` LIKE '" . $a . "%' AND `item`=" . $b . " GROUP BY phycode)F1 Right JOIN (SELECT roadid,(toch-fromch)l,toch,fromch FROM `tabsection` WHERE `roadid` LIKE '" . $a . "%' and (length(tcsid)-length(Replace(tcsid,'" . $b . "','')))>0 AND wdone=2)F2 ON F1.phycode=F2.roadid WHERE (F2.l-COALESCE(F1.q, 0)) >0";
		}
		if ($tinfo['unit'] == 'No') {
			$myquery = "SELECT chainage as ch FROM tabschedule WHERE wdone=2 AND progress!='COMPLETED'AND itemcode LIKE '" . $a . "%' AND itemsize =(SELECT name FROM tabitemcode WHERE itemid=" . $b . ")";
		}
		if ($tinfo['unit'] == 'Stage') {
			$myquery = "SELECT chainage as ch FROM tabstageitem WHERE wdone=2 AND id LIKE '" . $a . "%' AND  SUBSTRING(ID,6,3)=" . $b . " and (length(Replace(status,'COMPLETED',''))-(Length(stages)-Length(Replace(stages,',',''))))>0";
		}

		$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
	}
	public function get_userid()
	{
		$a = $this->session->userdata('roadid');
		//$myquery="SELECT username FROM `user` WHERE (length(rlist)-length(Replace(rlist,'".$a."',''))>0 OR length(rlist)=0) AND (length(autho)-length(Replace(autho,'274',''))>0)";
		$myquery = "SELECT username FROM `user` WHERE (length(rlist)-length(Replace(rlist,'" . $a . "',''))>0) AND (length(autho)-length(Replace(autho,'274',''))>0)";

		$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
	}


	public function save_Rfi()
	{
		$a = $this->session->userdata('roadid');
		$oid = $this->maxRfiid($a);
		$i = $this->input->post('rfirow');
		$j = str_replace($a, "", $oid['rsubid']);
		$newid = $a . sprintf("%04d", $j + 1);
		$object = [];
		for ($x = 0; $x < $i; $x++) {
			$object[] = array(
				'rsubid' => $newid,
				'rfiid' => $this->input->post('rfiid' . $x),
				'location' => $this->input->post('ch' . $x),
				'mdate' => $this->input->post('md' . $x),
				'mtime' => $this->input->post('mt' . $x),
				'rem' => $this->input->post('rm' . $x),
				'muser' => $this->input->post('ulist'),
				'action' => 'RFI Generated.',
				'mid' => $this->session->userdata('username')
			);
		}
		if (count($object) > 0) {
			return $this->db->insert_batch('tabrfi', $object);
		} else {
			return false;
		}
	}
	public function save_Rfi_action()
	{
		date_default_timezone_set('Asia/Kolkata');
		$currentDate = date("Y-m-d");
		$currentTime = date("H:i");
		$a = $this->input->post('chepro');
		$apprv = $this->input->post('action2');
		$object = array(
			'rfiid' => $this->input->post('rfiid2'),
			'muser' => $this->input->post('ulist2'),
			'rem' => $this->input->post('descrip2'),
			'mid' => $this->session->userdata('username'),
			'mdate' => $currentDate,
			'mtime' => $currentTime,
			'action' => $apprv
		);
		$b = $this->db->insert('tabrfiaction', $object);
		if ($b && $apprv == 'Approved') {
			$id = substr($this->input->post('rfiid2'), 3, 3);
			$tinfo = $this->verify_item($id);
			if ($tinfo['a'] == '0') { // no rfi sub item exist
				if ($tinfo['unit'] == 'Km') { // linear item
					$b = $this->insert_linear_progress($this->input->post('chd'), $this->input->post('rfiid2'));
				}
				if ($tinfo['unit'] == 'No') { // Point item
					$b = $this->insert_point_progress($this->input->post('chd'), $this->input->post('rfiid2'));
				}
			} else {
				$phycode = $this->rfi_subitem_approve_status($this->input->post('chd'), $this->input->post('rfiid2'));
				if ($tinfo['unit'] == 'Km') { // linear item							
					if ($phycode['s'] == 0) {
						$b = $this->insert_linear_progress($this->input->post('chd'), $this->input->post('rfiid2'));
					}
				}
				if ($tinfo['unit'] == 'No') { // Point item
					if ($phycode['s'] == 0) {
						$b = $this->insert_point_progress($this->input->post('chd'), $this->input->post('rfiid2'));
					}
				}
				if ($tinfo['unit'] == 'Stage') { // Stage item
					if ($phycode['s'] == 0) {
						$b = $this->insert_Stage_progress($this->input->post('chd'), $this->input->post('rfiid2'));
					}
				}
			}
		}
		return $b;
	}

	public function insert_Stage_progress($a, $b)
	{
		$phycode = $this->get_stagerecord($a, $b);
		$sp = $phycode['span'];
		$st = explode(',', $phycode['stages']);
		$i = Count($st) + $sp;
		$rid = $phycode['id'];
		$fstatus = 'COMPLETED';
		//bulk entry delete old record
		$this->db->where('rid', $rid)->delete('tabstgp');
		$object2 = [];
		for ($j = 0; $j < $i; $j++) {
			if ($j <= $sp) {
				$nid = $a . '-' . $st[0];
			} else {
				$nid = $a . '-' . $st[$j - $sp];
			}
			$object2[] = array(
				'rid' => $rid,
				'stageid' => $nid,
				'status' => 'COMPLETED',
				'yrm' => str_replace('-', '', date("Y-m"))
			);
			if ($j > 0) {
				$fstatus = $fstatus . ',' . 'COMPLETED';
			}
		}
		$p1 = $this->db->insert_batch('tabstgp', $object2);
		$object = array('status' => $fstatus);
		$p2 = $this->db->where('id', $phycode['id'])->update('tabstageitem', $object);
		if ($p1 && $p2) {
			return true;
		} else {
			return false;
		}
	}
	public function insert_linear_progress($a, $b)
	{
		$chd = explode('-', $a);
		$id = substr($b, 3, 3);
		$phycode = $this->get_phyidrecord($chd[0], $chd[1], $b);

		$object = array(
			'item' => $id,
			'qyt' => $chd[1] - $chd[0],
			'fromch' => $chd[0],
			'toch' => $chd[1],
			'phycode' => $phycode['phycode'],
			'yrm' => str_replace('-', '', date("Y-m")),
			'recno' => $phycode['rec']
		);
		return $this->db->insert('tabphysical', $object);
	}
	public function insert_point_progress($a, $b)
	{
		$phycode = $this->get_schedulerecord($a, $b);
		$object = array(
			'progress' => 'COMPLETED',
			'percent' => '100',
			'yrm' => str_replace('-', '', date("Y-m"))
		);
		return $this->db->where('itemcode', $phycode['itemcode'])->update('tabschedule', $object);
	}
	public function rfi_subitem_approve_status($ch, $phycode)
	{
		$rid = substr($phycode, 0, 3);
		$itemid = substr($phycode, 3, 3);
		$pcode = substr($phycode, 0, 6);
		$myquery = "SELECT (count(F1.id)-sum(if(F3.action='Approved',1,0)))s FROM (SELECT if(id <10,CONCAT('" . $rid . "','" . $itemid . "','0',id),CONCAT('" . $rid . "','" . $itemid . "',id))id FROM `tabrfiitem` WHERE `itemid`='" . $itemid . "') as F1 Left JOIN (SELECT substring(`rfiid`,1,8)id,action,rfiid FROM `tabrfi` WHERE `rfiid` LIKE '" . $pcode . "%' and location='" . $ch . "')F2 ON F1.id=F2.id LEFT JOIN (SELECT action,rfiid FROM tabrfiaction WHERE action='Approved')F3 ON F3.rfiid=F2.rfiid";
		$tm_project = $this->db->query($myquery)->row_array();
		return $tm_project;
	}
	public function detail($a)
	{
		$b = explode(':', $a);
		$this->session->set_userdata('mypage', $b[1]);
		$this->db->select('tabrfi.*');
		$this->db->from('tabrfi');
		$this->db->where('rfiid', $b[0]);
		$query = $this->db->get()->row();
		return $query;
	}
	public function verify_drawing($ch, $id)
	{
		$a = $this->session->userdata('roadid');
		$b = explode('-', $ch);
		$ch1 = $b[0];
		if (count($b) > 1) {
			$ch2 = $b[1];
		} else {
			$ch2 = $b[0];
		}
		$myquery = "SELECT (Select count(id) FROM tabdraw WHERE tabdraw.itemid=" . $id . ")t,Count(status)a FROM (SELECT SUBSTRING_INDEX(tabdrawings.TCS, '-', 1)ch1,SUBSTRING_INDEX(SUBSTRING_INDEX(tabdrawings.TCS, '-', 2),'-',-1)ch2 ,tabdrawings.status FROM tabdraw LEFT JOIN tabdrawings ON tabdraw.descrip=tabdrawings.dtype WHERE tabdraw.itemid=" . $id . ") as F1 WHERE (F1.ch1<=" . $ch1 . " AND F1.ch2>=" . $ch1 . " AND F1.ch1<=" . $ch2 . " AND F1.ch2>=" . $ch2 . " AND F1.status='Approved')";
		$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
	}
	public function get_phyidrecord($ch1, $ch2, $phycode)
	{
		$rid = substr($phycode, 0, 3);
		$itemid = substr($phycode, 3, 3);
		$myquery = "SELECT phycode,sum(qyt)l,Min(fromch)c1,Max(toch)C2,max(recno+1)rec FROM tabphysical WHERE phycode=(SELECT roadid FROM tabsection WHERE (Length(tcsid)-Length(Replace(tcsid,'" . $itemid . "','')))>0 AND fromch<=" . $ch1 . " AND toch>=" . $ch1 . "  and  fromch<=" . $ch2 . " AND toch>=" . $ch2 . " AND roadid LIKE '" . $rid . "%') AND item='" . $itemid . "' GROUP bY phycode";
		$tm_project = $this->db->query($myquery)->row_array();
		if (empty($tm_project)) {
			$myquery = "SELECT roadid as phycode ,0 as rec FROM tabsection WHERE (Length(tcsid)-Length(Replace(tcsid,'" . $itemid . "','')))>0 AND fromch<=" . $ch1 . " AND toch>=" . $ch1 . "  and  fromch<=" . $ch2 . " AND toch>=" . $ch2 . " AND roadid LIKE '" . $rid . "%'";
			$tm_project = $this->db->query($myquery)->row_array();
		}
		return $tm_project;
	}
	public function get_schedulerecord($ch, $phycode)
	{
		$rid = substr($phycode, 0, 3);
		$itemid = substr($phycode, 3, 3);
		$myquery = "SELECT `itemcode` FROM `tabschedule` WHERE `chainage`=" . $ch . " and `itemcode` LIKE '" . $rid . "%'";
		$tm_project = $this->db->query($myquery)->row_array();
		return $tm_project;
	}
	public function get_stagerecord($ch, $phycode)
	{
		$rid = substr($phycode, 0, 3);
		$itemid = substr($phycode, 3, 3);
		$myquery = "SELECT id,span,stages FROM `tabstageitem` WHERE `chainage`=" . $ch . " and `id` LIKE '" . $rid . "%'";
		$tm_project = $this->db->query($myquery)->row_array();
		return $tm_project;
	}
	public function verify_item($id)
	{
		$myquery = "SELECT if(`sitem`='YES',(SELECT count(id) FROM tabrfiitem WHERE itemid=" . $id . " GROUP BY itemid),'0') as a ,unit FROM `tabitemcode` WHERE `itemid`=" . $id;
		$tm_project = $this->db->query($myquery)->row_array();
		return $tm_project;
	}
	public function maxRfiid($a)
	{
		return $this->db->select_max('rsubid')
			->like('rsubid', $a)
			->from('tabrfi')
			->get()->row_array();
	}

	public function save_saveroadno()
	{
		$rtext = $this->input->post('proid');
		$a = explode(':', $rtext);
		$this->session->set_userdata('roadid', $a[0]);
		return true;
	}

	public function edit_Rfi()
	{
		$object = array(
			'location' => $this->input->post('ch0'),
			'mdate' => $this->input->post('md0'),
			'mtime' => $this->input->post('mt0'),
			'rem' => $this->input->post('rm0')
		);
		return $this->db->where('rfiid', $this->input->post('rfiid0'))
			->where('action', 'RFI Generated.')
			->update('tabrfi', $object);
	}

	public function hapus_Rfi($id = '')
	{
		return $this->db->where('rfiid', $id)->delete('tabrfi');
	}
}
