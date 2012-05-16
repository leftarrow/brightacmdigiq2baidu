<?php

class ApiController extends Controller
{
	public function actionQuery($code='',$name='',$phone='',$email='')
	{
		$user = new User();
		if ($code != ''){
			$user->code = $code;
		}
		if ($name != ''){
			$user->name = $name;
		}
		if ($phone != ''){
			$user->phone = $phone;
		}
		if ($email != ''){
			$user->email = $email;
		}
		$results = array('status'=>1,'participants'=>$user->apiQuery());
		echo CJavaScript::jsonEncode($results);
		Yii::app()->end();
	}

	public function actionCheckin($ids,$ipad_id)
	{
		$idArray = explode(',', $ids);
		$participants = array();
		foreach ($idArray as $id ){
			$user = User::model()->findByPk($id);
			if($user===null){

			}else{
				//if check_in?
				if($user->has_checked_in == 1){
					$user->display = '已经注册过。';
				}else{
					$user = $this->printCode($user,$ipad_id);
				}
				$participants[]=$user;
			}
		}
		$results = array('results'=>$participants
		);
		echo CJavaScript::jsonEncode($results);
		Yii::app()->end();
	}
	
	/**
	 * list all questions
	 */
	public function actionQuestions(){
		$questions = Question::model()->findAll(array('order'=>'id desc'));
		echo CJavaScript::jsonEncode($questions);
		Yii::app()->end();
	}
	
	/**
	 * create a question
	 */
	public function actionCreateQuestion()
	{
		$result = array('message'=>'false');
		$model=new Question;
			
		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$result['message'] = 'success';
		}
		echo CJavaScript::jsonEncode($result);
		Yii::app()->end();
	}
}