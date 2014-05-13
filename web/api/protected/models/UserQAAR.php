<?php

class UserQAAR extends CActiveRecord {
  const ANSWER_WRONG = 0;
  const ANSWER_RIGHT = 1;
  public function tableName() {
    return "user_question_answer";
  }
  
  public function primaryKey() {
    return "uqaid";
  }
  
  public static function model($classname = __CLASS__) {
    return parent::model($classname);
  }
  
  public function beforeSave() {
    $this->cdate = date("Y-m-d H:i:s");
    
    // 检查用户是否之前已经回答了这个问题
    $qaid = $this->qaid;
    $uid = $this->uid;
    $cond = array("condition" => "qaid=:qaid AND uid=:uid", "params" => array(":uid" => $uid, ":qaid" => $qaid));
    $row = $this->find($cond);
    if ($row) {
      $this->addError("uid", "user answered question before");
      return FALSE;
    }
    
    return parent::beforeSave();
  }
  
  public function afterSave() {
    // TODO:: 用户回答后 判断用户是否回答正确，如果正确，我们则进行加分
    return parent::afterSave();
  }
  
  /**
   * 加载用户已经回答过的问题
   * @param type $uid
   * @return type
   */
  public function loadUserAnwseredQuestiones($user) {
    $cond = array(
        "condition" => "uid=:uid",
        "params" => array(":uid" => $user->uid),
    );
    
    $rows = $this->findAll($cond);
    return $rows;
  }
  
  /**
   * 用户回答问题接口
   * @param type $qaid
   * @param type $answer
   */
  public function answer($qaid, $answer) {
    $qa_ar = QAAR::model()->findByPk($qaid);
    if (!$qa_ar) {
      return FALSE;
    }
    else {
      if ($qa_ar->right == $answer) {
        $right = self::ANSWER_RIGHT;
      }
      else {
        $right = self::ANSWER_WRONG;
      }
      $this->qaid = $qaid;
      $this->uid = UserAR::crtuser()->uid;
      $this->is_right = $right;
      $this->answer_id = $answer;
      
      $this->save();
      
      return $this;
    }
  }
}
