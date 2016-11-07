<?php


namespace Interfaces\Controller;
use Think\Controller;
class MotivationAnalysisController extends Controller{

	public function rerunLastJob(){
		$companyid = $_REQUEST['companyid'];
        $lastJob = $this->getLastJob($companyid);
        $lastJobID = $lastJob["jobid"];
        if($lastJobID!=null){
        	D("shopbatchjob")->where("jobid=".$lastJobID)->setField("jobstatus",BatchJobController::$RERUN_JOB_STATUS);

        	$rep["jobid"] = $lastJobID;
        	//echo $this->formatResponse($rep, true, "Set Job Rerun, jobid ".$lastJobID);
			return $lastJobID;
        }else{
        	//echo $this->formatResponse("", true, "No Job scheduled, will start batch next time");
			return 0;
        }
	}

    public function getLastJob($companyid){
        $jobModel = M("companyusers");
        $lastJob = $jobModel->join('LEFT JOIN `easy_shopbatchjob` ON easy_companyusers.companyid = easy_shopbatchjob.companyid' )
             ->where("easy_companyusers.status='".BatchJobController::$READY_COMPANY_STATUS."' and easy_companyusers.companyid=".$companyid)->order('jobstartdt desc')->find();
        return $lastJob;
    }

	public function getMotivationRecordsByJobID() {
		$lastJobID = $this->rerunLastJob();
	
		
		$condition['datatype'] ='motivation';
    	$condition['jobid'] = $lastJobID;
		$condition['_logic'] = 'AND';


		 $recordModel = M("directword_analysis",null);
	  	 $records = $recordModel->where($condition)->select();
		 //echo count($records);
		 return $records;
	}


	public function getMotivationWords() {
		 $condition['wordsubcategory'] ='motivation';

 		 $recordModel = M("wordlibrary");
 		 $records = $recordModel->where($condition)->select();

		//echo count($records);

		return $records;
	}

	
	public function countMainMotivation(){
		$dataRecords = $this->getMotivationRecordsByJobID();
		$motivationType = $this->getMotivationWords();

		$dataRecordsCount = count($dataRecords);
		$mTypeCount = count($motivationType);

		$count  = array ("coupledates"=>0, "friendMeal"=>0, "familyMeal"=>0,"workmateMeal"=>0,"festivalParty"=>0,"businessMeal"=>0);

		
		
		 if($dataRecordsCount > 0) {
			
			for ($i=0;$i<$dataRecordsCount;$i++){
    			
					for ($j=0;$j<$mTypeCount;$j++){

						if($dataRecords[$i]['wordid'] == $motivationType[$j]['wordid']) {

							
							$name = $motivationType[$j]['wordsubsubcategory'];

							$count["$name"] += 1;

							break;

						}
					}
			}
		} 
		
		foreach ($count as $key=>$value) {
    		$count[$key] = $value / $dataRecordsCount * 100;
		}
		
		echo $this->formatResponse($count, true, "");


	}



	public function getPeopleCountRecordsByJobID() {
		$lastJobID = $this->rerunLastJob();
	
		
		$condition['datatype'] ='peoplecount';
    	$condition['jobid'] = $lastJobID;
		$condition['_logic'] = 'AND';


		 $recordModel = M("directword_analysis",null);
	  	 $records = $recordModel->where($condition)->select();
		 //echo count($records);
		 return $records;
	}

	public function getPeoplecountWords() {
		 $condition['wordsubcategory'] ='peoplecount';

 		 $recordModel = M("wordlibrary");
 		 $records = $recordModel->where($condition)->select();


		 return $records;
	}


	public function countPeople(){
		$dataRecords = $this->getPeopleCountRecordsByJobID();
		$peopleCountType = $this->getPeoplecountWords();

		$dataRecordsCount = count($dataRecords);
		$pTypeCount = count($peopleCountType);

		$count  = array ("one"=>0, "two"=>0, "threefour"=>0,"fiveandmore"=>0);

		
		
		 if($dataRecordsCount > 0) {
			
			for ($i=0;$i<$dataRecordsCount;$i++){
    			
					for ($j=0;$j<$pTypeCount;$j++){

						if($dataRecords[$i]['wordid'] == $peopleCountType[$j]['wordid']) {

							
							$name = $peopleCountType[$j]['wordsubsubcategory'];

							$count["$name"] += 1;

							break;

						}
					}
			}
		} 
		
		foreach ($count as $key=>$value) {
    		$count[$key] = $value / $dataRecordsCount * 100;
		}
		
		echo $this->formatResponse($count, true, "");


	}



	public function getFrequencyRecordsByJobID() {
		$lastJobID = $this->rerunLastJob();
	
		
		$condition['datatype'] ='frequency';
    	$condition['jobid'] = $lastJobID;
		$condition['_logic'] = 'AND';


		 $recordModel = M("directword_analysis",null);
	  	 $records = $recordModel->where($condition)->select();
		 //echo count($records);
		 return $records;
	}


		public function getFrequencyWords() {
		 $condition['wordsubcategory'] ='frequency';

 		 $recordModel = M("wordlibrary");
 		 $records = $recordModel->where($condition)->select();

		//echo count($records);
		 return $records;
	}


	public function countFrequency(){
		$dataRecords = $this->getFrequencyRecordsByJobID();
		$frequencyType = $this->getFrequencyWords();

		$dataRecordsCount = count($dataRecords);
		$fTypeCount = count($frequencyType);

		$count  = array ("newcust"=>0, "backcust"=>0);

		
		
		 if($dataRecordsCount > 0) {
			
			for ($i=0;$i<$dataRecordsCount;$i++){
    			
					for ($j=0;$j<$fTypeCount;$j++){

						if($dataRecords[$i]['wordid'] == $frequencyType[$j]['wordid']) {

							
							$name = $frequencyType[$j]['wordsubsubcategory'];

							$count["$name"] += 1;

							break;

						}
					}
			}
		} 
		
		foreach ($count as $key=>$value) {
    		$count[$key] = $value / $dataRecordsCount * 100;
		}
		
		echo $this->formatResponse($count, true, "");


	}

	
	public function getLostandkeepRecordsByJobID() {
		$lastJobID = $this->rerunLastJob();
	
		
		$condition['datatype'] ='lostandkeep';
    	$condition['jobid'] = $lastJobID;
		$condition['_logic'] = 'AND';


		 $recordModel = M("directword_analysis",null);
	  	 $records = $recordModel->where($condition)->select();
		 //echo count($records);
		 return $records;
	}


	public function getLostandkeepWords() {
		 $condition['wordsubcategory'] ='lostandkeep';

 		 $recordModel = M("wordlibrary");
 		 $records = $recordModel->where($condition)->select();

		//echo count($records);
		 return $records;
	}


	public function countLostandkeep(){
		$dataRecords = $this->getLostandkeepRecordsByJobID();
		$lostandkeepType = $this->getLostandkeepWords();

		$dataRecordsCount = count($dataRecords);
		$lTypeCount = count($lostandkeepType);

		$count  = array ("totalkeep"=>0, "totallost"=>0);

		
		
		 if($dataRecordsCount > 0) {
			
			for ($i=0;$i<$dataRecordsCount;$i++){
    			
					for ($j=0;$j<$lTypeCount;$j++){

						if($dataRecords[$i]['wordid'] == $lostandkeepType[$j]['wordid']) {

							
							$name = $lostandkeepType[$j]['wordsubsubcategory'];

							$count["$name"] += 1;

							break;

						}
					}
			}
		} 
		
		//foreach ($count as $key=>$value) {
    		//$count[$key] = $value / $dataRecordsCount * 100;
		//}
		
		echo $this->formatResponse($count, true, "");


	}


	public function getIntoRecordsByJobID() {
		$lastJobID = $this->rerunLastJob();
	
		
		$condition['datatype'] ='into';
    	$condition['jobid'] = $lastJobID;
		$condition['_logic'] = 'AND';


		 $recordModel = M("directword_analysis",null);
	  	 $records = $recordModel->where($condition)->select();
		 //echo count($records);
		 return $records;
	}

	public function getIntoWords() {
		 $condition['wordsubcategory'] ='into';

 		 $recordModel = M("wordlibrary");
 		 $records = $recordModel->where($condition)->select();

		 //echo count($records);
		 return $records;
	}


	public function countInto(){
		$dataRecords = $this->getIntoRecordsByJobID();
		$intoType = $this->getIntoWords();

		$dataRecordsCount = count($dataRecords);
		$iTypeCount = count($intoType);

		$count  = array ();

		
		
		 if($dataRecordsCount > 0) {
			
			for ($i=0;$i<$dataRecordsCount;$i++){
    			
					for ($j=0;$j<$iTypeCount;$j++){

						if($dataRecords[$i]['wordid'] == $intoType[$j]['wordid']) {

							
							$name = $intoType[$j]['wordcharacter'];

							if(empty($count["$name"])) {
								$count["$name"] = 1;
							}else {
								$count["$name"] += 1;
							}
							break;

						}
					}
			}
		} 
		
		//foreach ($count as $key=>$value) {
    		//$count[$key] = $value / $dataRecordsCount * 100;
		//}
		
		echo $this->formatResponse($count, true, "");


	}

	 private function formatResponse($data, $success, $message){
    	$response["success"] = $success;
    	$response["message"] = $message;
    	$response["data"] = $data;
    	return json_encode($response);
    }

}
?>