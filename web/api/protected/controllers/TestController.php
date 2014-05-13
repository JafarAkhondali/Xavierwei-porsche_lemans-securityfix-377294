<?php

class TestController extends Controller {
  public function actionIndex() {
    $userAr = new UserAR();
    $invited_url = $userAr->generateInvitedURL("200238123", "30209847");
    
    $this->render("index", array("url" => $invited_url));
  }
  
  public function actionAddMedia() {
    $this->render("addmedia");
  }
  
  public function actionTwitte() {
    $this->render("twitte");
  }

  public function actionAddSomeThing()
  {
//      （只是把需要做计算的数据拿出来，计算步骤尚且不说）
//计算团队分数
//1：计算团队内所有人员的发帖数量，（注意是所有团队内人员）
//   发帖数量从 twittes  	检索 uid 为团队成员 && 满足时间内  &&  (ref_type && ref_id)为空，表示不是转发	计算平均值
//
//2.高质量转发（只需要检索满足条件的tid，不需要检索成员）
//  从 twittes	检索 tid && (ref_type && ref_id)不为空，表示是转发
//
//3.队伍问题回答（检索所有成员）
//  从 user_question_answer 检索团队成员的总答题数 正确答题数，累加 计算
//
//4.粉丝（检索所有成员）
//  从 users 表 获取 friend 进行累加

        //echo date("Y-m-d H:i:s", time()) ;
        //添加一批新用户
//      $sql='';
//      for($i=1 ; $i<7;$i++)
//      {
//          $type=(intval($i % 2)+1);
//          $time=date("Y-m-d H:i:s", time()-rand(-36000,36000));
//          $rand=rand(100,3000);
//          $sql=$sql . "INSERT INTO `users` (`uid`, `name`, `from`, `cdate`, `friends`) VALUES ('" . $i   ."', '". $i ."', '".$type."', '".$time."', '".$rand."'); ";
//      }
//      echo $sql;

      //为用户分配团队
//      for($i=1;$i<1000;$i++)
//      {
//          $userTeam=new UserTeamAR();
//          $userTeam->uid=$i;
//          $userTeam->tid=rand(1,4);
//          var_dump($userTeam->save(false));
//          $userTeam->setIsNewRecord(true);
//      }

      //为用户新增回答问题
//      for($j=0;$j<20;$j++)
//      {
//        for($i=0;$i<1000;$i++)
//        {
//            $usqa=new UserQAAR();
//            $usqa->is_right=rand(0,1);
//            $usqa->uid=$i;
//            var_dump($usqa->save(false));
//            $usqa->setIsNewRecord(true);
//        }
//      }

      //新增 3000 个不转发的原始帖子
//        for($i=1;$i<3000;$i++)
//        {
//            $twittes=new TwitteAR();
//            $twittes->uid=rand(1,999);
//            $twittes->content=$twittes->tid;
//            $twittes->redirect_count=rand(10,2000);
//            var_dump($twittes->save(false));
//            $twittes->setIsNewRecord(true);
//        }

      //新增转发贴3000个
//         for($i=1;$i<3000;$i++)
//        {
//            $twittes=new TwitteAR();
//            $twittes->uid=rand(1,999);
//            $twittes->content=$twittes->tid;
//            $twittes->redirect_count=rand(10,2000);
//            $twittes->ref_id=rand(1,40);
//            $twittes->ref_type=rand(1,2);
//            var_dump($twittes->save(false));
//            $twittes->setIsNewRecord(true);
//        }
  }

    public function actionTScore()
    {
        set_time_limit(0);  //临时设置脚本运算为不限时

        $t1=microtime(true);

        //测试计算积分
        $allTeams=TeamAR::model()->findAll(
            [
                'select'=>'tid,owner_uid',
            ]
        );
        if(!$allTeams)          //没有查找到团队
            return false;

        $teamScore=[];      //记录团队此次计分
        //遍历团队
        foreach($allTeams as $key => $value)
        {
            //计算团队问题回答答对率 Assiduity ，检索结果已经是按照团队总数了，直接除就好
            $connection=Yii::app()->db;
            $rightSql='SELECT is_right,COUNT(*) AS count  FROM user_question_answer WHERE uid IN (SELECT uid FROM user_teams WHERE tid = :tid) AND is_right = 1';
            $command=$connection->createCommand($rightSql);
            $command->bindParam(":tid",$value->tid);
            $rightCount=$command->queryRow()['count'];

            $errorSql='SELECT is_right,COUNT(*) AS count  FROM user_question_answer WHERE uid IN (SELECT uid FROM user_teams WHERE tid = :tid)';
            $command=$connection->createCommand($errorSql);
            $command->bindParam(":tid",$value->tid);
            $allCount=$command->queryRow()['count'];

            //得到当前团队的  assiduity 百分比
            $teamScore[$value->tid]['assiduity']=round( $rightCount/$allCount , 3);

            //获取粉丝总数
            $connection->active=false;      //断开连接，
            $connection->active=true;       //重新连接 ，防止数据库断开

            $friendSql="SELECT Sum(friends) AS count FROM users WHERE uid IN (SELECT uid FROM user_teams WHERE tid = :tid)";
            $command=$connection->createCommand($friendSql);
            $command->bindParam(":tid",$value->tid);
            $friendCount=$command->queryRow()['count'];

            //粉丝百分比
            $teamScore[$value->tid]['impact']= round( $friendCount / 20000 , 3) > 1 ? 1 : round( $friendCount / 20000 , 3) ;

            //获取 Quality 百分比
            $connection->active=false;      //断开连接，
            $connection->active=true;       //重新连接 ，防止数据库断开

            $qualitySql="SELECT COUNT(*) AS count FROM twittes WHERE uid IN (SELECT uid FROM user_teams WHERE tid = :tid) AND ref_type IS NOT NULL AND ref_id IS NOT NULL";
            $command=$connection->createCommand($qualitySql);
            $command->bindParam(":tid",$value->tid);
            $qualityCount=$command->queryRow()['count'];

            //质量百分比
            $teamScore[$value->tid]['quality']= round( $qualityCount / 100 , 3) > 1 ? 1 : round( $qualityCount / 100 , 3) ;

            //Speed 百分比
            $connection->active=false;      //断开连接，
            $connection->active=true;       //重新连接 ，防止数据库断开

            //获取团队内的所有成员信息
            $allTeamsUsers=UserTeamAR::model()->findAll(
                [
                    'select'=>'uid',
                    'condition'=>'tid = :tid ',
                    'params'=>[':tid'=>$value->tid],
                ]
            );

            $userSpeedNum=0;
            $userSpeedSum=0.000;
            //遍历获取当前用户的speed
            foreach($allTeamsUsers as $ke => $val)
            {
                $cdate= Yii::app()->params['startTime'] ?  Yii::app()->params['startTime']  : '1970-10-10';
                $speedSql="SELECT uid,DATE_FORMAT( cdate,'%H') AS hour, COUNT( * ) AS count
                                              FROM twittes WHERE uid = :uid  AND ref_type IS NULL AND ref_id IS NULL AND cdate > :cdate GROUP BY hour";
                $command=$connection->createCommand($speedSql);
                $command->bindParam(":uid",$val->uid);
                $command->bindParam(":cdate",$cdate);
                $speedCountArray=$command->queryAll();

                $speedSum=0.000;
                $speedArrayCount=count($speedCountArray);           //用户在活动时间按照小时是否有发送的个数
                if($speedArrayCount > 0)
                {
                    foreach($speedCountArray as $k => $v)
                    {
                        $temp=($v['count'] / 40) >1 ?  1 : ($v['count'] / 40);
                        $speedSum = $speedSum + $temp;
                        $speedArrayCount++;
                    }
                    $userSpeedNum++;
                    $userSpeedSum=$userSpeedSum + ($speedSum / $speedArrayCount);
                }
            }

            $teamScore[$value->tid]['speed']=  round( $userSpeedSum / $userSpeedNum , 3) > 1 ? 1 : round( $userSpeedSum / $userSpeedNum  , 3);

            $teamScore[$value->tid]['frontSpeed']=($teamScore[$value->tid]['impact'] + 2* ($teamScore[$value->tid]['speed'] + $teamScore[$value->tid]['quality'] + $teamScore[$value->tid]['assiduity']) / 7)* 246 ;

        }
        echo microtime(true)-$t1;

        echo '<pre>';
        print_r($teamScore);
        die;

//        //检索团队内的所有成员
//        foreach($allTeams as $key => $value)
//        {
//        $test=1;
//            $connection=Yii::app()->db;
//            $sql='SELECT uid FROM user_teams WHERE tid = :tid';
//            $command=$connection->createCommand($sql);
//            $command->bindParam(":tid",$test);
//            $res=$command->queryAll();
//        print_r($res);
//        }

        //sleep(2);       //休眠2秒
    }

}

