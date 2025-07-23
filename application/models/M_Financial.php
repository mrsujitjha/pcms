<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Financial extends CI_Model
{


	public function get_sps($a)
	{
		$b = $this->session->userdata('userid');

		if ($a == "") {
			$querystring = "
            SELECT n.*,
                   (SELECT flow FROM tabfinprocess tp WHERE tp.pkgid = n.pkgid LIMIT 1) AS flow
            FROM
                (SELECT fincode, MAX(sn) AS sn FROM tabfinance GROUP BY fincode) AS m
            JOIN tabfinance n ON m.fincode = n.fincode AND m.sn = n.sn
            WHERE (n.fromid = $b OR n.toid = $b)
        ";
		} else if ($a == "All") {
			$querystring = "
            SELECT n.*,
                   (SELECT flow FROM tabfinprocess tp WHERE tp.pkgid = n.pkgid LIMIT 1) AS flow
            FROM
                (SELECT fincode, MAX(sn) AS sn FROM tabfinance GROUP BY fincode) AS m
            JOIN tabfinance n ON m.fincode = n.fincode AND m.sn = n.sn
        ";
		} else {
			$querystring = "
            SELECT n.*,
                   (SELECT flow FROM tabfinprocess tp WHERE tp.pkgid = n.pkgid LIMIT 1) AS flow
            FROM
                (SELECT fincode, MAX(sn) AS sn FROM tabfinance GROUP BY fincode) AS m
            JOIN tabfinance n ON m.fincode = n.fincode AND m.sn = n.sn
            WHERE (n.fromid = $b OR n.toid = $b OR $b = 1) AND n.pkgid = '$a'
        ";
		}

		$query = $this->db->query($querystring)->result();
		return $query;
	}


	
	// public function generate_invoice()
	// {
	// 	$a = $this->input->post('proad');
	// 	$locationitem = "(SELECT CONCAT(M.pid,M.itemid)bid,M.itemid,M.T,M.qyt,M.wp,M.mw,(SELECT logic from tabpaycon Where cid= M.l)l FROM (SELECT Sum(C.T)T,Sum(C.qyt)qyt,D.wp,D.mw,D.condition as l,C.pid,C.itemid FROM (SELECT A.pid,A.rid,tabitemcode.itemid,A.qyt,A.rlength as T FROM (SELECT Substring(itemcode,1,5)as pid,Substring(itemcode,1,3) as rid,itemsize,if(rem='%',descrip,count(itemsize)) as rlength,if(rem='%',Round(percent*descrip/100,0),Sum(if(progress='COMPLETED',1,0))) as qyt FROM tabschedule GROUP BY  Substring(itemcode,1,3),itemsize)As A JOIN tabitemcode ON tabitemcode.name=A.itemsize) as C LEFT JOIN
	// 			(SELECT tabsubweight.*,tabweightage.mw,tabweightage.roadid FROM `tabsubweight` JOIN tabweightage ON tabweightage.id=tabsubweight.wid) as D ON D.roadid=C.rid  AND D.itemid=C.itemid WHERE  D.roadid='" . $a . "'GROUP BY D.mw,D.wp,itemid) as M) AS F1";
	// 	$this->prepare_bill($locationitem);
	// 	$linearitem = "(SELECT(M.pid)bid,substring(M.itemid,1,3)itemid,M.T,M.qyt,M.wp,M.mw,(SELECT logic from tabpaycon Where cid= M.l)l FROM (SELECT Sum(C.T)T,Sum(C.qyt)qyt,D.wp,D.mw,D.condition as l,C.pid,C.itemid FROM(SELECT B.pid,B.rid,B.itemid,B.qyt,(SELECT sum(toch-fromch) FROM tabsection WHERE substring(roadid,1,length(roadid)-5)=substring(B.pid,1,length(B.pid)-5) AND length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') as T FROM (SELECT phycode as pid,substring(phycode,1,3)as rid,concat(item,substring(phycode,6,length(phycode)-10))as itemid,sum(qyt) as qyt,item FROM tabphysical WHERE substring(phycode,Length(phycode)-3,1)!='R' GROUP BY rid,substring(phycode,1,length(phycode)-5),itemid) as B JOIN  tabroad ON tabroad.rid=B.rid) as C LEFT JOIN (SELECT tabsubweight.*,tabweightage.mw,tabweightage.roadid FROM `tabsubweight` JOIN tabweightage ON tabweightage.id=tabsubweight.wid) as D ON D.roadid=C.rid  AND D.itemid=C.itemid WHERE  D.roadid='" . $a . "'GROUP BY D.mw,D.wp,itemid) as M  JOIN tabitemcode ON tabitemcode.itemid=M.itemid) AS F1";
	// 	$this->prepare_bill($linearitem);
	// 	$linearitem = "(SELECT CONCAT(M.rid,M.stageid)bid,M.stageid as itemid,Count(M.qyt)T,Sum(M.qyt)qyt,M.mw,tabsubweight.wp ,(SELECT logic from tabpaycon Where cid= tabsubweight.condition)l FROM (SELECT tabstgp.rid, tabstgp.stageid,E.mw,E.wid,(if(status='COMPLETED',1,0)) qyt FROM tabstgp LEFT JOIN (SELECT D.wid,C.id,(D.mw * C.length / C.l) AS mw FROM (SELECT A.*,B.l FROM (SELECT id, length, itemid FROM tabstageitem WHERE id LIKE '" . $a . "%') AS A LEFT JOIN (SELECT itemid, SUM(length) AS l FROM tabstageitem WHERE id LIKE '" . $a . "%' GROUP BY itemid) AS B ON A.itemid = B.itemid) AS C LEFT JOIN (SELECT tabweightage.id AS wid,SUBSTRING(tabsubweight.itemid, 1, 3) AS  itemid,tabweightage.mw FROM tabsubweight JOIN tabweightage ON tabweightage.id = tabsubweight.wid WHERE tabweightage.roadid = '" . $a . "'GROUP BY tabweightage.id,SUBSTRING(tabsubweight.itemid, 1, 3)) AS D ON D.itemid = C.itemid) AS E ON E.id = tabstgp.rid)M LEFT JOIN tabsubweight ON tabsubweight.wid=M.wid AND tabsubweight.itemid=M.stageid WHERE M.rid LIKE '" . $a . "%' GROUP BY M.rid,M.stageid) AS F1";
	// 	$this->prepare_bill($linearitem);
	// 	$amt = $this->db->select('sum(bamt) as amt')->where('spsid', $this->input->post('spsid'))->get('tabbill')->row_array();

	// 	return $this->save_sps($amt['amt']);
	// }

	// public function generate_invoice()
	// {
	// 	$proad = $this->input->post('proad');
	// 	$spsid = $this->input->post('spsid');

	// 	// LOCATION ITEM QUERY
	// 	$locationitem = "
	// 		SELECT 
	// 			CONCAT(M.pid, M.itemid) AS bid,
	// 			M.itemid,
	// 			M.T,
	// 			M.qyt,
	// 			M.wp,
	// 			M.mw,
	// 			P.logic AS l
	// 		FROM (
	// 			SELECT 
	// 				SUM(C.T) AS T,
	// 				SUM(C.qyt) AS qyt,
	// 				D.wp,
	// 				D.mw,
	// 				D.condition AS l,
	// 				C.pid,
	// 				C.itemid
	// 			FROM (
	// 				SELECT 
	// 					A.pid,
	// 					A.rid,
	// 					tabitemcode.itemid,
	// 					A.qyt,
	// 					A.rlength AS T
	// 				FROM (
	// 					SELECT 
	// 						SUBSTRING(itemcode, 1, 5) AS pid,
	// 						SUBSTRING(itemcode, 1, 3) AS rid,
	// 						itemsize,
	// 						IF(rem = '%', descrip, COUNT(itemsize)) AS rlength,
	// 						IF(rem = '%', ROUND(percent * descrip / 100, 0), SUM(IF(progress = 'COMPLETED', 1, 0))) AS qyt
	// 					FROM tabschedule
	// 					GROUP BY SUBSTRING(itemcode, 1, 3), itemsize
	// 				) AS A
	// 				JOIN tabitemcode ON tabitemcode.name = A.itemsize
	// 			) AS C
	// 			LEFT JOIN (
	// 				SELECT tabsubweight.*, tabweightage.mw, tabweightage.roadid 
	// 				FROM tabsubweight 
	// 				JOIN tabweightage ON tabweightage.id = tabsubweight.wid
	// 			) AS D ON D.roadid = C.rid AND D.itemid = C.itemid
	// 			WHERE D.roadid = ?
	// 			GROUP BY D.mw, D.wp, itemid
	// 		) AS M
	// 		LEFT JOIN tabpaycon P ON P.cid = M.l
	// 	";

	// 	$this->prepare_bill($locationitem, [$proad]);

	// 	// LINEAR ITEM QUERY
	// 	$linearitem = "
	// 		SELECT 
	// 			M.pid AS bid,
	// 			SUBSTRING(M.itemid, 1, 3) AS itemid,
	// 			M.T,
	// 			M.qyt,
	// 			M.wp,
	// 			M.mw,
	// 			P.logic AS l
	// 		FROM (
	// 			SELECT 
	// 				SUM(C.T) AS T,
	// 				SUM(C.qyt) AS qyt,
	// 				D.wp,
	// 				D.mw,
	// 				D.condition AS l,
	// 				C.pid,
	// 				C.itemid
	// 			FROM (
	// 				SELECT 
	// 					B.pid,
	// 					B.rid,
	// 					B.itemid,
	// 					B.qyt,
	// 					(
	// 						SELECT SUM(toch - fromch)
	// 						FROM tabsection 
	// 						WHERE SUBSTRING(roadid, 1, LENGTH(roadid) - 5) = SUBSTRING(B.pid, 1, LENGTH(B.pid) - 5)
	// 						AND LENGTH(tcsid) - LENGTH(REPLACE(tcsid, B.item, '')) > 0
	// 						AND SUBSTRING(roadid, LENGTH(roadid) - 3, 1) != 'R'
	// 					) AS T
	// 				FROM (
	// 					SELECT 
	// 						phycode AS pid,
	// 						SUBSTRING(phycode, 1, 3) AS rid,
	// 						CONCAT(item, SUBSTRING(phycode, 6, LENGTH(phycode) - 10)) AS itemid,
	// 						SUM(qyt) AS qyt,
	// 						item
	// 					FROM tabphysical
	// 					WHERE SUBSTRING(phycode, LENGTH(phycode) - 3, 1) != 'R'
	// 					GROUP BY rid, SUBSTRING(phycode, 1, LENGTH(phycode) - 5), itemid
	// 				) AS B
	// 				JOIN tabroad ON tabroad.rid = B.rid
	// 			) AS C
	// 			LEFT JOIN (
	// 				SELECT tabsubweight.*, tabweightage.mw, tabweightage.roadid 
	// 				FROM tabsubweight 
	// 				JOIN tabweightage ON tabweightage.id = tabsubweight.wid
	// 			) AS D ON D.roadid = C.rid AND D.itemid = C.itemid
	// 			WHERE D.roadid = ?
	// 			GROUP BY D.mw, D.wp, itemid
	// 		) AS M
	// 		JOIN tabitemcode ON tabitemcode.itemid = M.itemid
	// 		LEFT JOIN tabpaycon P ON P.cid = M.l
	// 	";

	// 	$this->prepare_bill($linearitem, [$proad]);

	// 	// STAGE ITEM QUERY
	// 	$stageitem = "
	// 		SELECT 
	// 			CONCAT(M.rid, M.stageid) AS bid,
	// 			M.stageid AS itemid,
	// 			COUNT(M.qyt) AS T,
	// 			SUM(M.qyt) AS qyt,
	// 			M.mw,
	// 			tabsubweight.wp,
	// 			tabpaycon.logic AS l
	// 		FROM (
	// 			SELECT 
	// 				tabstgp.rid,
	// 				tabstgp.stageid,
	// 				E.mw,
	// 				E.wid,
	// 				(IF(status = 'COMPLETED', 1, 0)) AS qyt
	// 			FROM tabstgp
	// 			LEFT JOIN (
	// 				SELECT 
	// 					D.wid,
	// 					C.id,
	// 					(D.mw * C.length / C.l) AS mw
	// 				FROM (
	// 					SELECT 
	// 						A.*, 
	// 						B.l
	// 					FROM (
	// 						SELECT id, length, itemid 
	// 						FROM tabstageitem 
	// 						WHERE id LIKE ?
	// 					) AS A
	// 					LEFT JOIN (
	// 						SELECT itemid, SUM(length) AS l 
	// 						FROM tabstageitem 
	// 						WHERE id LIKE ?
	// 						GROUP BY itemid
	// 					) AS B ON A.itemid = B.itemid
	// 				) AS C
	// 				LEFT JOIN (
	// 					SELECT 
	// 						tabweightage.id AS wid,
	// 						SUBSTRING(tabsubweight.itemid, 1, 3) AS itemid,
	// 						tabweightage.mw
	// 					FROM tabsubweight 
	// 					JOIN tabweightage ON tabweightage.id = tabsubweight.wid
	// 					WHERE tabweightage.roadid = ?
	// 					GROUP BY tabweightage.id, SUBSTRING(tabsubweight.itemid, 1, 3)
	// 				) AS D ON D.itemid = C.itemid
	// 			) AS E ON E.id = tabstgp.rid
	// 		) AS M
	// 		LEFT JOIN tabsubweight ON tabsubweight.wid = M.wid AND tabsubweight.itemid = M.stageid
	// 		LEFT JOIN tabpaycon ON tabpaycon.cid = tabsubweight.condition
	// 		WHERE M.rid LIKE ?
	// 		GROUP BY M.rid, M.stageid
	// 	";

	// 	$this->prepare_bill($stageitem, ["$proad%", "$proad%", $proad, "$proad%"]);

	// 	// Fetch total amount
	// 	$amt = $this->db->select('SUM(bamt) AS amt')
	// 		->where('spsid', $spsid)
	// 		->get('tabbill')
	// 		->row_array();
	// 	// echo $this->db->last_query();die;

	// 	return $this->save_sps($amt['amt']);
	// }

	public function generate_invoice()
	{
		$proad = $this->input->post('proad');
		$spsid = $this->input->post('spsid');

		// LOCATION ITEM QUERY
		$locationitem = "SELECT CONCAT(M.pid, M.itemid) AS bid, M.itemid, M.T, M.qyt, M.wp, M.mw, P.logic AS l FROM (SELECT SUM(C.T) AS T, SUM(C.qyt) AS qyt, D.wp, D.mw, D.condition AS l, C.pid, C.itemid FROM (SELECT A.pid, A.rid, tabitemcode.itemid, A.qyt, A.rlength AS T FROM (SELECT SUBSTRING(itemcode, 1, 5) AS pid, SUBSTRING(itemcode, 1, 3) AS rid, itemsize, IF(rem = '%', descrip, COUNT(itemsize)) AS rlength, IF(rem = '%', ROUND(percent * descrip / 100, 0), SUM(IF(progress = 'COMPLETED', 1, 0))) AS qyt FROM tabschedule GROUP BY SUBSTRING(itemcode, 1, 3), itemsize) AS A JOIN tabitemcode ON tabitemcode.name = A.itemsize) AS C LEFT JOIN (SELECT tabsubweight.*, tabweightage.mw, tabweightage.roadid FROM tabsubweight JOIN tabweightage ON tabweightage.id = tabsubweight.wid) AS D ON D.roadid = C.rid AND D.itemid = C.itemid WHERE D.roadid = ? GROUP BY D.mw, D.wp, itemid) AS M LEFT JOIN tabpaycon P ON P.cid = M.l";
		$this->prepare_bill($locationitem, [$proad]);

		// LINEAR ITEM QUERY
		$linearitem = "SELECT M.pid AS bid, SUBSTRING(M.itemid, 1, 3) AS itemid, M.T, M.qyt, M.wp, M.mw, P.logic AS l FROM (SELECT SUM(C.T) AS T, SUM(C.qyt) AS qyt, D.wp, D.mw, D.condition AS l, C.pid, C.itemid FROM (SELECT B.pid, B.rid, B.itemid, B.qyt, (SELECT SUM(toch - fromch) FROM tabsection WHERE SUBSTRING(roadid, 1, LENGTH(roadid) - 5) = SUBSTRING(B.pid, 1, LENGTH(B.pid) - 5) AND LENGTH(tcsid) - LENGTH(REPLACE(tcsid, B.item, '')) > 0 AND SUBSTRING(roadid, LENGTH(roadid) - 3, 1) != 'R') AS T FROM (SELECT phycode AS pid, SUBSTRING(phycode, 1, 3) AS rid, CONCAT(item, SUBSTRING(phycode, 6, LENGTH(phycode) - 10)) AS itemid, SUM(qyt) AS qyt, item FROM tabphysical WHERE SUBSTRING(phycode, LENGTH(phycode) - 3, 1) != 'R' GROUP BY rid, SUBSTRING(phycode, 1, LENGTH(phycode) - 5), itemid) AS B JOIN tabroad ON tabroad.rid = B.rid) AS C LEFT JOIN (SELECT tabsubweight.*, tabweightage.mw, tabweightage.roadid FROM tabsubweight JOIN tabweightage ON tabweightage.id = tabsubweight.wid) AS D ON D.roadid = C.rid AND D.itemid = C.itemid WHERE D.roadid = ? GROUP BY D.mw, D.wp, itemid) AS M JOIN tabitemcode ON tabitemcode.itemid = M.itemid LEFT JOIN tabpaycon P ON P.cid = M.l";
		$this->prepare_bill($linearitem, [$proad]);

		// STAGE ITEM QUERY
		$stageitem = "SELECT CONCAT(M.rid, M.stageid) AS bid, M.stageid AS itemid, COUNT(M.qyt) AS T, SUM(M.qyt) AS qyt, M.mw, tabsubweight.wp, tabpaycon.logic AS l FROM (SELECT tabstgp.rid, tabstgp.stageid, E.mw, E.wid, (IF(status = 'COMPLETED', 1, 0)) AS qyt FROM tabstgp LEFT JOIN (SELECT D.wid, C.id, (D.mw * C.length / C.l) AS mw FROM (SELECT A.*, B.l FROM (SELECT id, length, itemid FROM tabstageitem WHERE id LIKE ?) AS A LEFT JOIN (SELECT itemid, SUM(length) AS l FROM tabstageitem WHERE id LIKE ? GROUP BY itemid) AS B ON A.itemid = B.itemid) AS C LEFT JOIN (SELECT tabweightage.id AS wid, SUBSTRING(tabsubweight.itemid, 1, 3) AS itemid, tabweightage.mw FROM tabsubweight JOIN tabweightage ON tabweightage.id = tabsubweight.wid WHERE tabweightage.roadid = ? GROUP BY tabweightage.id, SUBSTRING(tabsubweight.itemid, 1, 3)) AS D ON D.itemid = C.itemid) AS E ON E.id = tabstgp.rid) AS M LEFT JOIN tabsubweight ON tabsubweight.wid = M.wid AND tabsubweight.itemid = M.stageid LEFT JOIN tabpaycon ON tabpaycon.cid = tabsubweight.condition WHERE M.rid LIKE ? GROUP BY M.rid, M.stageid";
		$this->prepare_bill($stageitem, ["$proad%", "$proad%", $proad, "$proad%"]);

		// Fetch total amount
		$amt = $this->db->select('SUM(bamt) AS amt')->where('spsid', $spsid)->get('tabbill')->row_array();

		return $this->save_sps($amt['amt']);
	}

	// public function prepare_bill($myquery, $bindings = [])
	// {
	// 	date_default_timezone_set('Asia/Kolkata');
	// 	$mdate = date('Y-m-d H:i:s');

	// 	$this->db->query("DROP TEMPORARY TABLE IF EXISTS temp_point");

	// 	$querystring = "
	//     CREATE TEMPORARY TABLE temp_point AS
	// 	    SELECT 
	// 	        F1.bid,
	// 	        F1.itemid,
	// 	        F1.T,
	// 	        (F1.qyt - COALESCE(F2.b, 0)) AS n,
	// 	        F1.wp,
	// 	        F1.mw,
	// 	        (F1.T - COALESCE(F2.b, 0)) AS r,
	// 	        F1.l
	// 	    FROM (" . $myquery . ") AS F1
	// 	    LEFT JOIN (
	// 	        SELECT billcode, SUM(qyt) AS b 
	// 	        FROM tabbill 
	// 	        GROUP BY billcode
	// 	    ) AS F2 ON F1.bid = F2.billcode
	// 	    WHERE (F1.qyt - COALESCE(F2.b, 0)) > 0
	// 	";

	// 	// ✅ safe execution with bound parameters
	// 	$this->db->query($querystring, $bindings);

	// 	$tm_project = $this->db->get('temp_point')->result_array();

	// 	foreach ($tm_project as $bill) {
	// 		$camt = $this->session->userdata('Camount');
	// 		$min = 100000;

	// 		if (strpos($bill['l'], 'or') !== false || strpos($bill['l'], 'and') !== false) {
	// 			$orcondition = explode('or', $bill['l']);
	// 			$min1 = $this->get_condition_val($orcondition[0], $bill['T']);
	// 			$min2 = $this->get_condition_val($orcondition[1], $bill['T']);
	// 			$min = min($min1, $min2);
	// 		} else {
	// 			$min = $this->get_condition_val($bill['l'], $bill['T']);
	// 		}

	// 		if ((($bill['n'] == $bill['r']) || ($bill['l'] == '100%') || ($bill['n'] >= $min)) && !is_null($bill['l'])) {
	// 			$billamt = round($bill['n'] / $bill['T'] * $bill['mw'] * $bill['wp'] / 10000 * $camt, 3);
	// 			$object = array(
	// 				'billcode' => $bill['bid'],
	// 				'itemid' => $bill['itemid'],
	// 				'Tqyt' => $bill['T'],
	// 				'qyt' => $bill['n'],
	// 				'mw' => $bill['mw'],
	// 				'sw' => $bill['wp'],
	// 				'bamt' => $billamt,
	// 				'bdate' => $mdate,
	// 				'spsid' => $this->input->post('spsid')
	// 			);
	// 			echo "<pre>";print_r($object);die;
	// 			$this->db->insert('tabbill', $object);
	// 		}
	// 	}
	// }

	public function prepare_bill($myquery, $bindings = [])
	{
		date_default_timezone_set('Asia/Kolkata');
		$mdate = date('Y-m-d H:i:s');

		$wrapped_query = " SELECT F1.bid, F1.itemid, F1.T, (F1.qyt - COALESCE(F2.b, 0)) AS n, F1.wp, F1.mw, (F1.T - COALESCE(F2.b, 0)) AS r, F1.l FROM (" . $myquery . ") AS F1 LEFT JOIN ( SELECT billcode, SUM(qyt) AS b FROM tabbill GROUP BY billcode ) AS F2 ON F1.bid = F2.billcode WHERE (F1.qyt - COALESCE(F2.b, 0)) > 0 ";

		$rows = $this->db->query($wrapped_query, $bindings)->result_array();

		foreach ($rows as $bill) {
			$camt = $this->session->userdata('Camount');
			$min = 100000;

			if (strpos($bill['l'], 'or') !== false || strpos($bill['l'], 'and') !== false) {
				$orcondition = explode('or', $bill['l']);
				$min1 = $this->get_condition_val(trim($orcondition[0]), $bill['T']);
				$min2 = $this->get_condition_val(trim($orcondition[1]), $bill['T']);
				$min = min($min1, $min2);
			} else {
				$min = $this->get_condition_val($bill['l'], $bill['T']);
			}

			if ((($bill['n'] == $bill['r']) || ($bill['l'] == '100%') || ($bill['n'] >= $min)) && !is_null($bill['l'])) {
				$billamt = round($bill['n'] / $bill['T'] * $bill['mw'] * $bill['wp'] / 10000 * $camt, 3);

				$object = array(
					'billcode' => $bill['bid'],
					'itemid'   => $bill['itemid'],
					'Tqyt'     => $bill['T'],
					'qyt'      => $bill['n'],
					'mw'       => $bill['mw'],
					'sw'       => $bill['wp'],
					'bamt'     => $billamt,
					'bdate'    => $mdate,
					'spsid'    => $this->input->post('spsid')
				);

				$this->db->insert('tabbill', $object);
			}
		}
	}

	// public function prepare_bill($myquery)
	// {
	// 	date_default_timezone_set('Asia/Kolkata');
	// 	$mdate = date('Y-m-d H:i:s');


	// 	$this->db->query("DROP TEMPORARY TABLE IF EXISTS temp_point");
	// 	$querystring = "CREATE TEMPORARY TABLE temp_point AS
	// 	SELECT F1.bid,F1.itemid,F1.T,(F1.qyt - COALESCE(F2.b, 0)) AS n,F1.wp,F1.mw,(F1.T - COALESCE(F2.b, 0)) AS r, F1.l FROM " . $myquery . " LEFT JOIN 
	// 	(SELECT billcode, SUM(qyt) AS b FROM tabbill GROUP BY billcode) AS F2 ON F1.bid = F2.billcode WHERE (F1.qyt - COALESCE(F2.b, 0)) > 0";
	// 	$this->db->query($querystring);

	// 	$tm_project = $this->db->get('temp_point')->result_array();
	// 	foreach ($tm_project as $bill) {
	// 		$camt = $this->session->userdata('Camount');
	// 		$min = 100000; //big number to confirm 	
	// 		//all payment condition checked here
	// 		if (strpos($bill['l'], 'or') !== false || strpos($bill['l'], 'and') !== false) {
	// 			//complicated query will do later
	// 			$orcondition = explode('or', $bill['l']);
	// 			$min1 = $this->get_condition_val($orcondition[0], $bill['T']);
	// 			$min2 = $this->get_condition_val($orcondition[0], $bill['T']);
	// 			$min = min($min1, $min2);
	// 		} else {
	// 			//$min=1;
	// 			$min = $this->get_condition_val($bill['l'], $bill['T']);
	// 		}
	// 		// remainig quantity is equal to billed quantiyt or no condition or condition fullfilled
	// 		if ((($bill['n'] == $bill['r']) || ($bill['l'] == '100%') || ($bill['n'] >= $min)) && !is_null($bill['l'])) {
	// 			$billamt = Round($bill['n'] / $bill['T'] * $bill['mw'] * $bill['wp'] / 10000 * $camt, 3);
	// 			$object = array(
	// 				'billcode' => $bill['bid'],
	// 				'itemid' => $bill['itemid'],
	// 				'Tqyt' => $bill['T'],
	// 				'qyt' => $bill['n'],
	// 				'mw' => $bill['mw'],
	// 				'sw' => $bill['wp'],
	// 				'bamt' => $billamt,
	// 				'bdate' => $mdate,
	// 				'spsid' => $this->input->post('spsid')
	// 			);
	// 			$this->db->insert('tabbill', $object);
	// 		}
	// 	}
	// }
	public function get_condition_val($a, $mv)
	{
		$mresult = 1;
		if (strpos($a, '%') !== false) {
			$f = str_replace(['min', '%'], '', $a);
			$mresult = $f * $mv / 100;
		} else {
			if (strpos($a, 'min') !== false) {
				$f = str_replace(['min'], '', $a);
				$mresult = $f;
			}
		}
		return $mresult;
	}


	public function get_sps_activity($a)
	{
		if ($a == "") {
			$myquery = "SELECT *,(SELECT CONCAT(fullname,'(',level,')') from user where user_code=tabfinance.fromid) as fuser,(SELECT CONCAT(fullname,'(',level,')') from user where user_code=tabfinance.toid) as tuser FROM `tabfinance`";
		} else {
			$myquery = "SELECT *,(SELECT CONCAT(fullname,'(',level,')') from user where user_code=tabfinance.fromid) as fuser,(SELECT CONCAT(fullname,'(',level,')') from user where user_code=tabfinance.toid) as tuser FROM `tabfinance`WHERE fincode='" . $a . "'";
		}
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function viewselectedsps($a)
	{
		$myquery = "SELECT tabitemcode.name,F1.T,F1.Q,F1.A FROM (SELECT  substring(itemid,1,3)id,Round(sum(Tqyt),2)T,Round(sum(qyt),2)Q,Round(sum(bamt),3)A FROM tabbill WHERE spsid='" . $a . "' GROUP BY substring(itemid,1,3))F1 LEFT JOIN tabitemcode ON F1.id=tabitemcode.itemid";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	// public function get_pkg()
	// {	$data=array();
	// 	$i=0;
	// 	$rlist=$this->session->userdata('pkglist');
	// 	$tm_project=$this->db->ORDER_BY ('flowid') ->get('tabfinprocess')->result_array();
	// 	if (strlen($rlist) ==0){ return $tm_project;}else{
	// 		$rid=explode(',', $rlist);
	// 		foreach ($rid as $r) {
	// 			foreach ($tm_project as $road) {
	// 				if	($road["flowid"]==$r){
	// 					$rowv=array('flowid'=> $road["flowid"],'pkgid'=> $road["pkgid"]);
	// 					$data[]=$rowv;
	// 				break;
	// 				}
	// 			}
	// 		}

	// 		return $data;}

	// }
	// public function get_pkg()
	// {
	// 	$rlist = $this->session->userdata('pkglist');
	// 	// print_r($rlist);die;

	// 	if (empty($rlist)) {
	// 		return $this->db->order_by('flowid')->get('tabfinprocess')->result_array();
	// 	}

	// 	// Remove leading colon, explode by colon
	// 	$rlist = ltrim($rlist, ':');
	// 	$pkgids = explode(':', $rlist);

	// 	// Get all rows where pkgid in $pkgids
	// 	$tm_project = $this->db
	// 		->order_by('flowid')
	// 		->where_in('pkgid', $pkgids)
	// 		->get('tabfinprocess')
	// 		->result_array();
	// 		// echo $this->db->last_query();die;

	// 	return $tm_project;
	// }

	public function get_pkg()
	{
		$pkglist = $this->session->userdata('pkglist');
		$level = $this->session->userdata('level');

		// ✅ If admin, return all packages
		if ($level === 'Admin') {
			return $this->db->order_by('flowid')->get('tabfinprocess')->result_array();
		}

		// ✅ If not admin but pkglist is empty, also return all
		if (empty($pkglist)) {
			return $this->db->order_by('flowid')->get('tabfinprocess')->result_array();
		}

		// 🔄 Remove leading colon, explode by colon
		$pkglist = ltrim($pkglist, ':');
		$pkgids = explode(':', $pkglist);

		// 🧹 Remove duplicates
		$pkgids = array_unique($pkgids);

		// ✅ Get only allowed packages
		$tm_project = $this->db
			->order_by('flowid')
			->where_in('pkgid', $pkgids)
			->get('tabfinprocess')
			->result_array();

		return $tm_project;
	}


	public function get_road()
	{
		$data = array();
		$i = 0;
		$rlist = $this->session->userdata('rlist');
		$tm_project = $this->db->get('tabroad')->result_array();
		if (strlen($rlist) == 0) {
			return $tm_project;
		} else {
			$rid = explode(',', $rlist);
			foreach ($rid as $r) {
				foreach ($tm_project as $road) {
					if ($road["rid"] == $r) {
						$rowv = array('rid' => $road["rid"], 'rname' => $road["rname"], 'pkg' => $road["pkg"]);
						$data[] = $rowv;
						break;
					}
				}
			}
			return $data;
		}
	}
	public function save_sps($auto)
	{
		if ($auto == 0) {
			$amt = $this->input->post('amt');
		} else {
			$amt = $auto;
		}
		$b = explode(':', $this->input->post('pdetail'));
		$id = $this->session->userdata('userid');
		$object = array(
			'fincode' => $this->input->post('spsid'),
			'sn' => $b[0],
			'pkgid' => $b[4],
			'mdate' => date("Y-m-d"),
			'amount' => $amt,
			'descrip' => $this->input->post('descrip'),
			'fromid' => $id,
			// 'fromid' => $b[1],
			'toid' => $b[2],
			'status' => $b[3]
		);
		return $this->db->insert('tabfinance', $object);
	}
	public function save_otherpayment()
	{
		$b = explode(':', $this->input->post('opdetail'));
		$object = array(
			'fincode' => $this->input->post('bid'),
			'sn' => $b[0],
			'pkgid' => $b[4],
			'mdate' => date("Y-m-d"),
			'amount' => $this->input->post('oamt'),
			'descrip' => $this->input->post('odescrip'),
			'fromid' => $b[1],
			'toid' => $b[2],
			'status' => $b[3]
		);
		return $this->db->insert('tabfinance', $object);
	}
	public function save_sps_progress()
	{
		$b = explode(':', $this->input->post('pdetail2'));

		$object = array(
			'fincode' => $this->input->post('spsid2'),
			'sn' => $b[0],
			'pkgid' => $b[4],
			'mdate' => date("Y-m-d"),
			'amount' => $this->input->post('amt2'),
			'descrip' => $this->input->post('descrip2'),
			'fromid' => $b[1],
			'toid' => $b[2],
			'status' => $b[3]
		);
		return $this->db->insert('tabfinance', $object);
	}
	public function detail($a)
	{
		$b = explode(':', $a);
		$this->session->set_userdata('mypage', $b[1]);
		return $this->db->where('fincode', $b[0])
			->get('tabfinance')
			->row();
	}

	public function maxspsid($a)
	{
		return $this->db->like('fincode', $a, 'after')
			->from('tabfinance')
			->get()
			->num_rows();
	}
	public function maxprogressid($a)
	{
		return $this->db->select_max('sn')->select('pkgid')->select('toid')
			->where('fincode', $a)
			->from('tabfinance')
			->get()
			->row();
	}
	public function save_pkg()
	{
		$rtext = $this->input->post('proid');
		$a = explode(':', $rtext);
		$this->session->set_userdata('pkgid', $a[1]);
		$camt = $this->db->SELECT('camt')->where('pkgsn', $a[0])->from('tabproject')->get()->row_array();
		$this->session->set_userdata('Camount',	$camt['camt']);
		return true;
	}
	public function clean_pkg()
	{
		$this->session->set_userdata('pkgid', "All");
		$this->session->set_userdata('Camount', 0);
		//	unset ($_SESSION["pkgid"]);
		return true;
	}
	public function edit_finance($a)
	{
		$b = explode(':', $a);
		$object = array(
			//	'fincode'=>$this->input->post('fincode'),
			//	'mdate'=>date("Y-m-d"),
			'amount' => $this->input->post('amt'),
			'descrip' => $this->input->post('descrip'),
			'fromid' => $b[0],
			'toid' => $b[1],
			'status' => $this->input->post('status')
		);
		return $this->db->where('fincode', $this->input->post('user_code_lama'))->update('tabfinance', $object);
	}

	public function hapus_finance($id = '')
	{
		$this->db->where('spsid', $id)->delete('tabbill');
		return $this->db->where('fincode', $id)->delete('tabfinance');
	}

	public function get_Financial_flow_progress()
	{
		$this->session->set_userdata('reporttype', "Packagewise payment Flow details");
		$r = $this->session->userdata('pkgname');
		$myquery = "SELECT F.pkgid,F.fincode,GROUP_CONCAT(F.l SEPARATOR ',') as 'a1', GROUP_CONCAT(F.mdate SEPARATOR ':') as 'd1',GROUP_CONCAT(F.amount SEPARATOR ':') as 'a2',GROUP_CONCAT(F.descrip SEPARATOR ':') as 'd2' FROM (SELECT A.*,Replace(user.level,'Financial','') as l FROM (SELECT pkgid,fincode,mdate,amount,descrip,fromid ,max(sn) as s FROM tabfinance WHERE pkgid='" . $r . "' GROUP BY fincode,fromid) as A JOIN user ON A.fromid=user.user_code) as F GROUP BY F.fincode";

		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function get_Financial_progress_summary()
	{
		$r = $this->session->userdata('phyroadid');
		$b = $this->session->userdata('phyyear') + 2023;
		$c = $this->session->userdata('phymonth');
		if ($c < 10) {
			$a = $b . "0" . $c;
		} else {
			$a = $b . $c;
		}
		$this->session->set_userdata('reporttype', "Financial Progress report");
		$myquery = "SELECT F.pkg, F.scope,B.amt as c1,D.amt as c2,(COALESCE(B.amt,0)+COALESCE(D.amt,0)) as c3,Round(((COALESCE(B.amt,0)+COALESCE(D.amt,0))/F.scope*100),2) as d1 FROM (SELECT pkg,sum(rcost) as scope FROM `tabroad` GROUP BY pkg)as F Left JOIN
(SELECT A.* FROM (SELECT pkgid,sum(amount) as amt,replace(substring(mdate,1,7),'-','')as md FROM `tabfinance` WHERE toid='Paid' GROUP BY pkgid) as A WHERE A.md<'" . $a . "') as B ON B.pkgid=F.pkg
Left JOIN
(SELECT C.* FROM (SELECT pkgid,sum(amount) as amt,replace(substring(mdate,1,7),'-','')as md FROM `tabfinance` WHERE toid='Paid' GROUP BY pkgid) as C WHERE C.md='" . $a . "') as D ON D.pkgid=F.pkg";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
}
