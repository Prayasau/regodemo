<?php 
    if(session_id()==''){session_start();}
	//ob_start();
	include('../../dbconnect/db_connect.php');
	//echo $_REQUEST['year'];die;
	$sql='SHOW CREATE PROCEDURE copy_holidays';
	if($dbc->query($sql)){
	$sql="CALL copy_holidays({$_REQUEST['year']})";
	//echo $_REQUEST['year'];die;
	if($dbc->query($sql)){
	    echo 'success';
	    //writeToLogfile($_SESSION['xhr']['cid'], 'action', 'Update time settings');
	}else{
	    echo mysqli_error($dbc);
	}}else{
	    $sql="CREATE PROCEDURE copy_holidays(IN year1 INT)
BEGIN
DECLARE d INT DEFAULT 0; 
DECLARE c_id INT;  
DECLARE date1, en1, cdate1,th1 TEXT;  

DECLARE Get_cur CURSOR FOR SELECT id,date,en,cdate,th FROM {$prefix}regodemo.rego_default_holidays WHERE year=year1;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET d = 1; 
SELECT COUNT(*)
INTO @e1
FROM {$prefix}regodemo.rego_default_holidays
WHERE year=year1;
SET @c1=0;

OPEN Get_cur;  
REPEAT
 
FETCH Get_cur INTO c_id,date1, en1, cdate1,th1;  
SET @found=0;

SELECT date, en, cdate,th
INTO @date2, @en2, @cdate2, @th2
FROM {$prefix}{$cid}.{$cid}_holidays
WHERE date=date1 LIMIT 1;
SET @count1=0;
SELECT COUNT(*)
INTO @count1
FROM {$prefix}{$cid}.{$cid}_holidays
WHERE date=date1;

##########
IF(@count1>1) THEN 
block2: BEGIN
DECLARE c INT DEFAULT 0;
DECLARE id3 INT;
DECLARE date3, en3, cdate3, th3 TEXT;
DECLARE Get_cur2 CURSOR FOR SELECT id,date,en,cdate,th FROM {$prefix}{$cid}.{$cid}_holidays WHERE date=date1;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET c = 1;

OPEN Get_cur2;
REPEAT

FETCH Get_cur2 INTO id3,date3, en3, cdate3,th3;

IF(en3=en1 AND cdate1=cdate3) THEN 
SET @found=1;
END IF;


UNTIL c OR @found END REPEAT;
CLOSE Get_cur2;
END block2;
END IF;
##########
SET d=0;

IF(@count1<1) THEN 
INSERT INTO {$prefix}{$cid}.{$cid}_holidays (year,date,cdate,en,th) SELECT year,date,cdate,en,th FROM {$prefix}regodemo.rego_default_holidays where id=c_id;

ELSEIF((en1!=@en2 OR cdate1!=@cdate2) AND @found=0) THEN 
INSERT INTO {$prefix}{$cid}.{$cid}_holidays (year,date,cdate,en,th) 
SELECT year,date,cdate,en,th FROM {$prefix}regodemo.rego_default_holidays where id=c_id;

END IF;
#END IF; 
SET @c1=@c1+1;
UNTIL d or @c1=@e1 END REPEAT;
#END LOOP;  
  
CLOSE Get_cur; 
END;
"/*"
CREATE PROCEDURE copy_holidays(IN year1 INT)
BEGIN
DECLARE d INT DEFAULT 0; 
DECLARE c INT DEFAULT 0; 
DECLARE c_id INT;  
DECLARE date1, en1, cdate1,th1 TEXT;  
  
DECLARE Get_cur CURSOR FOR SELECT id,date,en,cdate,th FROM {$prefix}regodemo.rego_default_holidays WHERE year=year1;

DECLARE CONTINUE HANDLER FOR SQLSTATE '02000'  
SET d = 1;  
DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'  
SET d = 1;  


OPEN Get_cur;  
lbl: LOOP  
IF d = 1 THEN  
LEAVE lbl;  
END IF;  
IF NOT d = 1 THEN  
  
FETCH Get_cur INTO c_id,date1, en1, cdate1,th1;  

SELECT date, en, cdate,th
INTO @date2, @en2, @cdate2, @th2
FROM {$prefix}{$cid}.{$cid}_holidays
WHERE date=date1 LIMIT 1;
SET @count1=0;
SELECT COUNT(*)
INTO @count1
FROM {$prefix}{$cid}.{$cid}_holidays
WHERE date=date1;

##########
IF(@count1>1) THEN SET c=0;
SET @found=0; 

lbl1: LOOP  
IF c = @count1 OR @found=1 THEN  
LEAVE lbl1;  
END IF;  
#IF NOT c = @count1 THEN  
  
SELECT id,date, en, cdate,th 
INTO @id3,@date3, @en3, @cdate3, @th3 
FROM {$prefix}{$cid}.{$cid}_holidays 
WHERE date=date1 

LIMIT c,1;


IF(@en3=en1 AND cdate1=@cdate3) THEN 
SET @found=1;
SET c_id=@id3;
END IF;

SET c=c+1;
#END IF;  
END LOOP; 
END IF;
##########

IF(@count1<1) THEN 
INSERT INTO {$prefix}{$cid}.{$cid}_holidays (year,date,cdate,en,th) SELECT year,date,cdate,en,th FROM {$prefix}regodemo.rego_default_holidays where id=c_id;

ELSEIF(en1!=@en2 OR cdate1!=@cdate2) THEN 
INSERT INTO {$prefix}{$cid}.{$cid}_holidays (year,date,cdate,en,th) 
SELECT year,date,cdate,en,th FROM {$prefix}regodemo.rego_default_holidays where id=c_id;

END IF;
END IF;  
END LOOP;  
  
CLOSE Get_cur; 
END;
""CREATE PROCEDURE copy_holidays(IN year1 YEAR){
BEGIN
DECLARE d INT DEFAULT 0;  
DECLARE c_id INT;  
DECLARE date1, en1, cdate1,th1 TEXT;  
  
DECLARE Get_cur CURSOR FOR SELECT id,date,en,cdate,th FROM {$prefix}regodemo.rego_default_holidays WHERE year=year1;

DECLARE CONTINUE HANDLER FOR SQLSTATE '02000'  
SET d = 1;  
DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'  
SET d = 1;  


OPEN Get_cur;  
lbl: LOOP  
IF d = 1 THEN  
LEAVE lbl;  
END IF;  
IF NOT d = 1 THEN  
  
FETCH Get_cur INTO c_id,date1, en1, cdate1,th1;  

SELECT date, en, cdate,th
INTO @date2, @en2, @cdate2, @th2
FROM {$prefix}{$cid}.{$cid}_holidays
WHERE date=date1 LIMIT 1;
SET @count1=0;
SELECT COUNT(*)
INTO @count1
FROM {$prefix}{$cid}.{$cid}_holidays
WHERE date=date1;


##########
IF(@count1>1) THEN DECLARE c INT DEFAILT 0;
SET @found=0; 
END IF;

lbl1: LOOP  
IF c = @count1 OR @found=1 THEN  
LEAVE lbl1;  
END IF;  
IF NOT c = @count1 THEN  
  
SELECT id,date, en, cdate,th
INTO @id3,@date3, @en3, @cdate3, @th3
FROM {$prefix}{$cid}.{$cid}_holidays
WHERE date=date1 LIMIT c-1,1;

IF(@en3=en1,cdate1=@cdate3) THEN 
SET @found=1;
SET c_id=@id3;
END IF;

@c=@c+1;
END IF;  
END LOOP; 
##########


IF(@count1<1) THEN 
INSERT INTO {$prefix}{$cid}.{$cid}_holidays (year,date,cdate,en,th) SELECT year,date,cdate,en,th FROM admin_regodemo.rego_default_holidays where id=c_id;

ELSEIF(en1!=@en2 OR cdate1!=@cdate2) THEN 
INSERT INTO {$prefix}{$cid}.{$cid}_holidays (year,date,cdate,en,th) 
SELECT year,date,cdate,en,th FROM {$prefix}regodemo.rego_default_holidays where id=c_id;
END IF;
END IF;  
END LOOP;  
  
CLOSE Get_cur; 
END
}
CALL copy_holidays({$_REQUEST['year']})"*/;
	    if($dbc->query($sql)){
	        $sql="CALL copy_holidays({$_REQUEST['year']})";
	        if($dbc->query($sql)){
	        echo 'success';
	        }else{
	            echo mysqli_error($dbc);
	        }
	        //writeToLogfile($_SESSION['xhr']['cid'], 'action', 'Update time settings');
	    }
}
	
	
	
	
	