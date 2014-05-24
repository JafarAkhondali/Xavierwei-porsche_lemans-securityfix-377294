	<!--  -->
	<div class="bg1 ">
		<!-- logo -->
    <div class="header">
        <div class="logo">PORSCHE</div>
        <div class="hd_info"></div>
    </div>
    <div class="page pagebg1">
      <!-- nav -->
      <div class="nav">
          <div class="post_link"><a href="#" data-a="post_weibo" class="navicon"></a><span><?=Yii::t('lemans','Make a tweet')?></span></div>
          <p><a href="/race"><?=Yii::t('lemans','The Race')?></a></p>
          <p><a href="/monitoring"><?=Yii::t('lemans','Monitoring')?></a></p>
          <p class="on"><a href="/stand"><?=Yii::t('lemans','My Stand')?></a></p>
          <p><a href="/fuel"><?=Yii::t('lemans','Fuel')?></a></p>
      </div>
      <!-- stand -->
      <div class="stand">
        <div id="data-stand" style="display:none" 
             data-is_invited="<?php echo $is_invited ? 1: 0?>"
             data-team_id="<?php echo $team_id?>"
             data-team_name="<?php echo $team_name?>"
             >
        </div>
        
        <div class="stand_tit">
          <input class="team_name" value="" />
          <span id="team-score"></span>
        </div>
          <!--  -->
        <div class="teambuild_members cs-clear">
			</div>
			<!--  -->
			<div class="stand_achivments cs-clear">
				<h2 class="fl">Achievements</h2>
				<div class="stand_achivmentsbox">
				</div>
			</div>
			<!--  -->
			<div class="stand_tweet">
				<a class="stand_del"><img src="/images/stand_del.png"></a>
				<a class="stand_add"><img src="/images/stand_add.png"></a>
				<h2 class="fl">Lastest Posts</h2>
				<div class="stand_posts"><div class="stand_posts_inner"></div></div>
			</div>
			<!--  -->
			<div class="stand_chart">
				<div class="stand_chart_score">
				</div>
				<div class="stand_chart_speed" >
					<div class="stand_chart_tip">
						This display the number of tweets per hour.
						<span>◆</span>
					</div>
				</div>
				<div class="stand_chart_quality" >
					<div class="stand_chart_tip">
						Tweet content from Fuel section to increase your quality..
						<span>◆</span>
					</div>
				</div>
				<div class="stand_chart_assiduite" >
					<div class="stand_chart_tip">
						Answer right to Porsche challenges to improve your assiduity
						<span>◆</span>
					</div>
				</div>
				<div class="stand_chart_impact" >
					<div class="stand_chart_tip">
						This represents the number of your followers
						<span>◆</span>
					</div>
				</div>
			</div>
		</div>
		<!-- stand end -->
	</div>

	<div class="tutr-step">
		<div class="tutr-step-top"></div>
		<div class="tutr-step-bottom"></div>
		<div class="tutr-step-left"></div>
		<div class="tutr-step-right"></div>
		<div class="tutr-step-tip1">
			<p>1/3</p>
			<div class="step-con">
				<p>Welcome to the Stand. From here you will be able to follow all the statistics you need in real time to win this race.</p>
				<p>The first part is an overview of your team: name, number of followers and tweets per hour.</p>
				<p>You can also invite other pilots to join your crew and increase your chance  to win.</p>
			</div>
			<a href="#" class="step-btn" data-step="2">Next</a>
		</div>
		<div class="tutr-step-tip2">
			<p>2/3</p>
			<div class="step-con">
				<p>The Porsche graph is the most important part of the stand. It allows you to see which stats to improve to go faster in the race. It’s composed of 4 different factors.</p>
				<p>Speed: it is the number of tweets of your team per hour.  </p>
				<p>Impact: it is the number of followers of your team.</p>
				<p>Quality:  it is the quality score of your tweets. To increase it you will need to tweet contents from the Fuel gallery.</p>
				<p>Assiduity: if you stay enough time on the platform, you will be able to answer to some Q&A from Porsche. Each good answer will increase the Assiduity.</p>
				<p>The 4 factors together allow to obtain an average speed per tout. The highest it is, the more chance you will have to win.</p>
			</div>
			<a href="#" class="step-btn" data-step="3">Next</a>
		</div>
		<div class="tutr-step-tip3">
			<p>3/3</p>
			<div class="step-con">
				<p>Achievements is the number of good answers your team got from Porsche all the Porsche challenges. Latests posts will allow you to have a quick look at your tean tweets. Now your ready for the race. Don’t hesitate to share the challenge to the other pilots you might know. Good luck !</p>
			</div>
			<a href="#" class="step-btn" data-a="">Start the race</a>
		</div>
	</div>
	<!--  -->