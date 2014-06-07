<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
	<meta name="viewport" content="width=640, minimum-scale=0.5, maximum-scale=1, target-densityDpi=290,user-scalable = no,minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
	<link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title><?php echo Yii::t("lemans", "Porsche #24SocialRace")?></title>
    <link href="/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/css/js.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 9]>
	<link href="/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
    <?php if (UserAR::crtuser() && UserAR::crtuser()->from == UserAR::FROM_TWITTER): ?>
    <link href="/css/twitter.css" rel="stylesheet" type="text/css" />
    <?php endif;?>
    <script type="text/javascript">
      <?php if (UserAR::crtuser()): ?>
      window.from = "<?php echo UserAR::crtuser()->from?>";
      window.topic = "<?php echo Yii::app()->params["topic"]?>";
      <?php else:?>
        window.from = "";
      <?php endif;?>
        
      window.is_start = <?php echo $this->is_start ? 1 : 0?>
    </script>
	<?php if ($this->page_name == 'race'): ?>
    <link rel="stylesheet" type="text/css" href="/css/webFonts.css" />
    <link rel="stylesheet" type="text/css" href="/css/track.css" />
	<?php endif;?>
    <script type="application/javascript" src="/js/jquery-1.7.1.min.js"></script>
    <script type="application/javascript" src="/js/three.min.js"></script>
    <script type="application/javascript" src="/js/stats.min.js"></script>
    <script type="application/javascript" src="/js/svgTool.js"></script>
    <script type="application/javascript" src="/js/common.js"></script>
    <script type="application/javascript" src="/js/jquery.base64.js"></script>
    <script type="application/javascript" src="/js/data.min.js"></script>
    
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-40136895-27', 'porsche.com');
        ga('send', 'pageview');

    </script>
</head>
<body data-lang="<?php echo Yii::app()->language;?>" class="lang-<?php echo Yii::app()->language == "en_us" ? "en": "cn" ?> bg1 <?php echo $this->classname ?> <?php if (UserAR::crtuser()){echo UserAR::crtuser()->from;} ?>" data-page="<?php echo $this->page_name?>">
	<div class="turnphone" style="display: none;">
		<div class="phone"></div>
	    <div class="tips"></div>
	</div>
	<!--  -->
	<?php echo $content?>
	<!--  -->
  
	<div class="footer">
        <div class="footer_link cs-clear">
            <a class="btn footer-icon" href="/stand" data-a="start-tutr"><?php echo Yii::t("lemans", "Tutorial")?></a>
            <p class="btn legal" data-a="legal-mentions"><?php echo Yii::t("lemans", "Legal Notice")?></p>
            <div class="btn <?php echo Yii::app()->language;?>" id="share"> <span class="label"> <?php echo Yii::t("lemans", "Share")?></span>
            	<div class="share-btns">
	            <?php if (Yii::app()->language == "zh_cn"): ?>
			            <a target="_blank" href="http://v.t.sina.com.cn/share/share.php?title=%e5%92%8c%e6%88%91%e4%bb%ac%e4%b8%80%e5%90%8c%e5%9b%9e%e5%bd%92%e5%8b%92%e8%8a%92%ef%bc%8c%e4%bd%a0%e5%87%86%e5%a4%87%e5%a5%bd%e4%ba%86%e5%90%97%ef%bc%9f%40%e4%bf%9d%e6%97%b6%e6%8d%b7+%e9%82%80%e4%bd%a0%e5%8f%82%e5%8a%a0%23%e5%8b%92%e8%8a%92%e7%a4%be%e4%ba%a4%e8%80%90%e5%8a%9b%e8%b5%9b%23%e3%80%82&url=http://24socialrace.porsche.com" class="i-sina"></a>
			            <a target="_blank" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://24socialrace.porsche.com&title=%e5%92%8c%e6%88%91%e4%bb%ac%e4%b8%80%e5%90%8c%e5%9b%9e%e5%bd%92%e5%8b%92%e8%8a%92%ef%bc%8c%e4%bd%a0%e5%87%86%e5%a4%87%e5%a5%bd%e4%ba%86%e5%90%97%ef%bc%9f%40%e4%bf%9d%e6%97%b6%e6%8d%b7+%e9%82%80%e4%bd%a0%e5%8f%82%e5%8a%a0%23%e5%8b%92%e8%8a%92%e7%a4%be%e4%ba%a4%e8%80%90%e5%8a%9b%e8%b5%9b%23%e3%80%82" class="i-qz"></a>
			            <a target="_blank" href="http://v.t.qq.com/share/share.php?title=%e5%92%8c%e6%88%91%e4%bb%ac%e4%b8%80%e5%90%8c%e5%9b%9e%e5%bd%92%e5%8b%92%e8%8a%92%ef%bc%8c%e4%bd%a0%e5%87%86%e5%a4%87%e5%a5%bd%e4%ba%86%e5%90%97%ef%bc%9f%40%e4%bf%9d%e6%97%b6%e6%8d%b7+%e9%82%80%e4%bd%a0%e5%8f%82%e5%8a%a0%23%e5%8b%92%e8%8a%92%e7%a4%be%e4%ba%a4%e8%80%90%e5%8a%9b%e8%b5%9b%23%e3%80%82" class="i-qq"></a>
			            <a target="_blank" href="http://www.douban.com/recommend/?url=http://24socialrace.porsche.com&title=%e5%92%8c%e6%88%91%e4%bb%ac%e4%b8%80%e5%90%8c%e5%9b%9e%e5%bd%92%e5%8b%92%e8%8a%92%ef%bc%8c%e4%bd%a0%e5%87%86%e5%a4%87%e5%a5%bd%e4%ba%86%e5%90%97%ef%bc%9f%40%e4%bf%9d%e6%97%b6%e6%8d%b7+%e9%82%80%e4%bd%a0%e5%8f%82%e5%8a%a0%23%e5%8b%92%e8%8a%92%e7%a4%be%e4%ba%a4%e8%80%90%e5%8a%9b%e8%b5%9b%23%e3%80%82" class="i-db"></a>
			            <a target="_blank" href="http://share.renren.com/share/buttonshare.do?link=http://24socialrace.porsche.com&title=%e5%92%8c%e6%88%91%e4%bb%ac%e4%b8%80%e5%90%8c%e5%9b%9e%e5%bd%92%e5%8b%92%e8%8a%92%ef%bc%8c%e4%bd%a0%e5%87%86%e5%a4%87%e5%a5%bd%e4%ba%86%e5%90%97%ef%bc%9f%40%e4%bf%9d%e6%97%b6%e6%8d%b7+%e9%82%80%e4%bd%a0%e5%8f%82%e5%8a%a0%23%e5%8b%92%e8%8a%92%e7%a4%be%e4%ba%a4%e8%80%90%e5%8a%9b%e8%b5%9b%23%e3%80%82" class="i-rr"></a>
	            <?php else:?>
			            <a target="_blank" href="https://www.facebook.com/share.php?u=http://24socialrace.porsche.com&t=24&pic=" class="i-fb"></a>
			            <a target="_blank" href="https://twitter.com/intent/tweet?text=http://24socialrace.porsche.com&pic=" class="i-tw"></a>
			            <a target="_blank" href="https://plus.google.com/share?url=http://24socialrace.porsche.com&t=24" class="i-g"></a>
			            <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=http://24socialrace.porsche.com&title=24&ro=false&summary=&source=" class="i-in"></a>
			            <a target="_blank" href="http://pinterest.com/pin/create/button/?url=http://24socialrace.porsche.com" class="i-p"></a>
	            <?php endif;?>
	            	<div class="popup_close" data-a="close-share"></div>
	            </div>
            </div>
        </div>
		<?php if ($this->page_name != 'index'): ?>
		<div class="footer_logout no-m">
			<a data-a="logout" class="logout" href="/api/user/logout"><?php echo Yii::t("lemans", "Log out")?></a>
		</div>
		<?php endif;?>
        <div class="footer_language">
	        <?php if (Yii::app()->language == "zh_cn"): ?>
		        <a class="f_lang_en" data-lang="en_us" href="#">En</a> | <span>中文</span>
	        <?php else:?>
		        <span>En</span> | <a class="f_lang_cn" data-lang="zh_cn" href="#">中文</a>
	        <?php endif;?>
        </div>
    </div>

	<div class="loading-wrap">
		<div class="logo"></div>
		<div class="loading-loader">
			<div class="loading-bar"></div>
		</div>
		<div class="loading-percentage"></div>
	</div>

    <div id="legal-notice">
      <div class="popup_close"></div>
      <div style="margin: 0 100px;position: relative;height: 100%;">
	      <div class="legal-con clearfix">
	      	<div>
	            <h2><?php echo Yii::t("lemans", "Legal Notice")?></h2>
		        <div class="intro"><?php echo Yii::t("lemans", "Legal_Notice_Content")?></div>
		</div>
      </div>
    </div>
<!--  -->
<script type="text/javascript" src="/js/sea/sea-debug.js" data-config="../config.js"></script>
<script type="text/javascript" src="/js/lp.core.js"></script>
<script type="text/javascript" src="/js/lang/<?php echo Yii::app()->language;?>.js"></script>
<script type="text/javascript" src="/js/lp.base.js"></script>
<!--  -->
    <!--IE6透明判断-->
    <!--[if IE 6]>
    <script src="/js/DD_belatedPNG.js"></script>
    <script>
        DD_belatedPNG.fix('*');
        document.execCommand("BackgroundImageCache", false, true);
    </script>
    <![endif]-->

    <!--[if lt IE 9]>
    <style type="text/css">
    	body .teambuild_member{position:relative;}
    	/*body .member_add{*/
    	/*background: none;*/
    	/*filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#66000000, endColorstr=#66000000);*/
    /* For IE 8*/
    /*-ms-filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#66000000, endColorstr=#66000000);*/
/*z-index:1; */
/*behavior: url(/css/iecss3.htc); }*/
    </style>
	<![endif]-->
</body>
</html>