<?php

/**
 * @author Jackey <jziwenchen@gmail.com>
 * 系统级别的Controller 比如 404  / 错误 
 */
class WebController extends Controller {
  public function init() {
    parent::init();
  }
  
  public function actionError() {
    $error = Yii::app()->errorHandler->error;
    if (!$error) {
      $event = func_get_arg(0);
      if ($event instanceof CExceptionEvent) {
        return $this->responseError($event);
      }
    }
    $this->responseError($error);
  }
  
  // 生成邀请链接时候我们在URL上加了密，所以这里调用接口解密
  public function actionDecryptionURL() {
    $requst = Yii::app()->getRequest();
    $d = $requst->getParam("d", FALSE);
    
    if (!$d) {
      return $this->responseError("invalid params", ErrorAR::ERROR_MISSED_REQUIRED_PARAMS);
    }
    $user = UserAR::crtuser();
    if (!$user) {
      //return $this->responseError("user not login", ErrorAR::ERROR_NOT_LOGIN);
    }
    
    if ($d) {
      $userAr = new UserAR();
      $data = $userAr->decryptionInvitedData($d);
      // 还需要判断邀请数据是否有效
      
      Yii::app()->session["invited_data"] = $data;
    }
    
    $this->responseJSON($data, "success");
  }
  
  public function actionWelcome() {
    $request = Yii::app()->getRequest();
    $d = $request->getParam("d");
    if ($d) {
      $userAr = new UserAR();
      $data = $userAr->decryptionInvitedData($d);
      Yii::app()->session["invited_data"] = $data;
    }
    $this->responseJSON("hello, lemans", "");
  }
  
  public function actionInittoken() {
    $this->render("inittoken");
  }
  
  public function actionTime() {
    $time = date("Y-m-d H:i:s");
    $startTime = Yii::app()->params["startTime"];
    
    $this->responseJSON(array("time_now" => $time, "time_start" => $startTime), "success");
  }

  public function actionTranslation() {
    $source = Yii::app()->getComponent("messages");
    $language = Yii::app()->getLanguage();
    $language_file_path = $source->getMessageFile("lemans", $language);

    print $language_file_path;
    die();
  }
  
  public function actionCronNewTwitte() {
    $request = Yii::app()->getRequest();
    if (!$request->isPostRequest) {
      return $this->responseError("error", 500);
    }
    
    $data = $request->getPost("data");
    if (!$data) {
      return $this->responseError("error", 500);
    }
      
    $statuses = json_decode($data);
    
    $from = $request->getPost("from");
    
    if ($from == UserAR::FROM_WEIBO) {
      foreach ($statuses as $status) {
        $weibo_user = $status["user"];
        $weibo_uid = $weibo_user["idstr"];
        $weibo_name = $weibo_user["screen_name"];
        $location = $weibo_user["location"];
        $friends = $weibo_user["followers_count"];
        $from = UserAR::FROM_WEIBO;
        $profile_msg = $weibo_user["description"];
        $avatar = $weibo_user["profile_image_url"];

        // 查找数据库， 调查用户是否已经被自动存入
        $cond = array("condition" => "uuid=:uuid AND `from`=:from", 
            "params" => array(":uuid" => $weibo_uid, ":from" => $from));
        $userAr = UserAR::model()->find($cond);
        if ($userAr) {
          print "time: ". date("Y-m-d H:m:s"). ': user [ '. $weibo_name.' ] has existed already';
        }
        else {
          $userAr = new UserAR();
          $userAr->uuid = $weibo_uid;
          $userAr->location = $location;
          $userAr->avatar = $avatar;
          $userAr->name = $weibo_name;
          $userAr->from = $from;
          $userAr->profile_msg = $profile_msg;
          $userAr->friends = $friends;
          $userAr->status = UserAR::STATUS_AUTO_JOIN;

          $userAr->save();

          $isExist = TRUE;

          print "time: ". date("Y-m-d H:m:s"). ": user [ ". $weibo_name. " ] being to insert system.\r\n";
        }

        // 第二, 查找用户的组 然后有可能自动建组
        if ($userAr) {
          $userTeamAr  = new UserTeamAR();
          $userTeam = $userTeamAr->loadUserTeam($userAr);
          // 用户如果没有组，则我们自动建组
          if (!$userTeam) {
            TeamAR::newteam(Yii::t("lemans", "New Team"), $userAr);
          }
        }

        // 第三，保存用户发的微博
        if ($userAr) {
          $uuid = $status["idstr"];
          $content = $status["text"];

          $cond = array("condition" => "uuid=:uuid", "params" => array(":uuid" => $uuid ));
          $found = TwitteAR::model()->find($cond);
          if ($found) {
            print "time: ". date("Y-m-d H:m:s"). ": content [ ". $content . ' ] has existed already'."\r\n";
          }
          else {
            $content = $status["text"];
            $uid = $userAr->uid;
            $type = $userAr->from;

            $twitteAr = new TwitteAR();
            $twitteAr->uid = $uid;
            $twitteAr->content = $content;
            $twitteAr->uuid = $uuid;
            $twitteAr->type = $type;
            $twitteAr->is_from_thirdpart = 1;

            // entities media
            if (isset($status["original_pic"])) {
              $twitteAr->thirdpart_ref_media = $status["original_pic"];
            }
            try {
              $twitteAr->save();
            }
            catch (Exception $e) {
              continue;
            }

            print "time: ". date("Y-m-d H:m:s"). ": content [ ". $content . ' ] being to insert system.'. "\r\n";
          }
        }
        else {
          print "time: ". date("Y-m-d H:m:s"). "unknow error\r\n";
        }
      }
    }
  }
}

