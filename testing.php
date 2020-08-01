<?php
	require($_SERVER['DOCUMENT_ROOT']."/NCS/dbconnect.php");
    

    $myquery = "select t1.sdname as name,cifname as parent,t2.sdname as child from (select  sdname,cifname,cifid from ncsstudentdetails t1 inner join (ncscounsellordetails inner join ncscounsellorinfo t2 using (CIFid)) using (sdrollid) where sdbatch=2014 ) as t1
,(select sdname,cifid from ncsstudentdetails  inner join ncscounsellordetails using (sdrollid) where sdbatch=2015) as t2 where t1.cifid=t2.cifid;";
    $query = pg_exec($connection,$myquery);
	
    if ( ! $query ) {
			echo pg_last_error();
        die;
    }
    
    $data = array();
    
    for ($x = 0; $x < pg_numrows($query); $x++) {
        $data[] = pg_fetch_assoc($query);
    }
    
    echo json_encode($data);     
     
    pg_close();
?>