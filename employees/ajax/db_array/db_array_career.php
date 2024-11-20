<?
	if(session_id()==''){session_start();}
	ob_start();

    $emp_career_db['id'] = $lng['ID'];
    $emp_career_db['month'] = $lng['month'];
    $emp_career_db['emp_id'] = $lng['Employee ID'];
    $emp_career_db['position'] = $lng['Position'];
    $emp_career_db['start_date'] = $lng['Start Date'];
    $emp_career_db['end_date'] = $lng['End date'];
    $emp_career_db['salary'] = $lng['Salary'];
    $emp_career_db['benefits'] = $lng['Benefits'];
    $emp_career_db['other_benifits'] = $lng['Other benefits'];
    $emp_career_db['remarks'] = $lng['Remarks'];