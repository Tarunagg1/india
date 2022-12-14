<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Responsive Player3</title>
   
	<style type="text/css">
        .containing-block {
		  width: 75%;
		}
		.outer-container {
          position: relative;
          height: 0;
          padding-bottom: 56.25%;
        }
        .BrightcoveExperience {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
        }
    </style>
    
</head>

<body>
	
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et tellus at nunc varius dapibus a eget arcu. Fusce venenatis ullamcorper viverra. Integer vitae lorem vel nulla interdum commodo. Donec mauris mi, commodo eget egestas at, malesuada vel lorem. Nullam eleifend congue aliquam. Vestibulum tincidunt ante at nisi blandit sollicitudin. Cras ut magna lacus, lacinia faucibus orci.</p>
    
    <br />
    
    <div id="container2" class="containing-block">
        <div id="container1" class="outer-container">
    
            <!-- Start of Brightcove Player -->

            <div style="display:none">
            
            </div>
            
            <!--
            By use of this code snippet, I agree to the Brightcove Publisher T and C 
            found at https://accounts.brightcove.com/en/terms-and-conditions/. 
            -->
        
            <script language="JavaScript" type="text/javascript" src="//sadmin.brightcove.com/js/BrightcoveExperiences.js"></script>
        
            <object id="myExperience1754276221001" class="BrightcoveExperience">
              <param name="bgcolor" value="#FFFFFF" />
              <param name="width" value="480" />
              <param name="height" value="270" />
              <param name="playerID" value="1785957921001" />
              <param name="playerKey" value="AQ~~,AAABmA9XpXk~,-Kp7jNgisrdzE4WB9lhVzM13pYBWmmbj" />
              <param name="isVid" value="true" />
              <param name="isUI" value="true" />
              <param name="dynamicStreaming" value="true" />
              
              <param name="@videoPlayer" value="1754276221001" />
              
              <!-- smart player api params -->
              <param name="includeAPI" value="true" />
              <param name="templateLoadHandler" value="onTemplateLoad" />
              <param name="templateReadyHandler" value="onTemplateReady" />
            </object>
        
            <!-- 
            This script tag will cause the Brightcove Players defined above it to be created as soon
            as the line is read by the browser. If you wish to have the player instantiated only after
            the rest of the HTML is processed and the page load is complete, remove the line.
            -->
            <script src="//docs.brightcove.com/en/scripts/https-fix.js"></script><script type="text/javascript">brightcove.createExperiences();</script>
            
            <!-- End of Brightcove Player -->
        
        </div>
    </div>
    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et tellus at nunc varius dapibus a eget arcu. Fusce venenatis ullamcorper viverra. Integer vitae lorem vel nulla interdum commodo. Donec mauris mi, commodo eget egestas at, malesuada vel lorem. Nullam eleifend congue aliquam. Vestibulum tincidunt ante at nisi blandit sollicitudin. Cras ut magna lacus, lacinia faucibus orci.</p>
    
	  <!-- jquery script -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript">
	    /******** Any scripts specific to page samples should go here *********/
	    var player,
		APIModules,
		videoPlayer,
		experienceModule,
		contentModule;
	    var onTemplateLoaded = function (experienceID) {
		console.log("EVENT: onTemplateLoaded");
		player = brightcove.api.getExperience(experienceID);
		APIModules = brightcove.api.modules.APIModules;
	    }
	    var onTemplateReady = function (evt) {
		console.log("EVENT.onTemplateReady");
		videoPlayer = player.getModule(APIModules.VIDEO_PLAYER);
		experienceModule = player.getModule(APIModules.EXPERIENCE);
		contentModule = player.getModule(APIModules.CONTENT);
		videoPlayer.getCurrentRendition(function (renditionDTO) {
		    var newPercentage = (renditionDTO.frameHeight / renditionDTO.frameWidth) * 100;
		    newPercentage = newPercentage + "%";
		    console.log("Video Width = " + renditionDTO.frameWidth + " and Height = " + renditionDTO.frameHeight);
		    console.log("New Percentage = " + newPercentage);
		    document.getElementById("container1").style.paddingBottom = newPercentage;
		    var evt = document.createEvent('UIEvents');
		    evt.initUIEvent('resize', true, false, 0);
		    window.dispatchEvent(evt);
		});
		// fetch the playlist
		buildPlaylistData();
	    }
	    var buildPlaylistData = function () {
		// retrieves the playlist data from the Video Cloud service
		contentModule.getPlaylistByID(1754200320001, function (playlistDTO) {
		    console.dir(playlistDTO);
		    // create the video thumbnail links in the scroller and write it into the HTML
		    var str = "";
		    for (var i in playlistDTO.videos) {
			str += "<div id='playlist-item' onClick='playVideo(" + playlistDTO.videos[i].id + ");'><img src='" + playlistDTO.videos[i].videoStillURL +
			"' /><div class=\"scroller-caption\"><span>" +
			playlistDTO.videos[i].shortDescription + "</span></div></div>";
		    }
		    console.log("str=" + str);
		    document.getElementById("playlist").innerHTML = str;
		});
	    };
	    var playVideo = function (videoid) {
		// play selected video
		if (videoPlayer.canPlayWithoutInteraction()) {
		    videoPlayer.loadVideoByID(videoid);
		} else {
		    videoPlayer.cueVideoByID(videoid);
		}
	    };
	    window.onresize = function (evt) {
		var resizeWidth = $(".BrightcoveExperience").width(),
		resizeHeight = $(".BrightcoveExperience").height();
		if (experienceModule.experience.type == "html") {
		    experienceModule.setSize(resizeWidth, resizeHeight)
		}
	    }
	</script>
    
</body>
</html>