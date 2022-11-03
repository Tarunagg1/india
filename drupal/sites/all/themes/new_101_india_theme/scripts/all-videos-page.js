var lastnid;
var myapps = angular.module("myapp", ['ngSanitize','infinite-scroll'])
/*	myapps.directive('whenScrolled', function() {
        return function(scope, elm, attr) {
            var raw = elm[0];
            elm.bind('scroll', function() {
                if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                    scope.$apply(attr.whenScrolled);
                }
            });
        };
    });	
*/	myapps.controller("MyController", function($scope, $http,$timeout, $sce) {

        $scope.myData = {};
        $scope.Data = [];
        series = [];
        seriesNid = [];
        dataAllSeries = [];
        $scope.loaded = true;
        finalArray = [];
    
        var initialLoad = true;

        function insertData(title,description,article_category,thumb_image,type,path,publication_date_published_at,bcove_vid_length,yt_vid_url,vz_vid_url,video_duration){
            //alert(title+"-------"+description+"-------"+article_category+"-------"+thumb_image+"-------"+type+"-------"+path);

            var baseUrl='';
            if(!window.location.origin){
                baseUrl = window.location.protocol + '//' + window.location.host;
            }else{
                baseUrl = window.location.origin;
            }

            var tempdata = {};
            var title = title.replace(/&#039;/g,"'");
            title = title.replace(/&quot;/g,'"');
            title = title.replace(/&amp;/g,'&');
            var description = description;

            var tmp = document.createElement("DIV");
            tmp.innerHTML = description; 
            description = tmp.textContent || tmp.innerText; 

            if(typeof(description) == 'undefined'){
                description = " ";
            }


            var maxLength = 86; 				// maximum number of characters to extract
            if(description.length>90){
                var trimmedDescription = description.substr(0, maxLength);
                trimmedDescription = trimmedDescription.substr(0, Math.min(trimmedDescription.length, trimmedDescription.lastIndexOf(" ")))+"....";
            }
            else{
                var trimmedDescription = description;
            }
            if(title.length>90){
                var trimmedTitle = title.substr(0, maxLength);
                trimmedTitle = trimmedTitle.substr(0, Math.min(trimmedTitle.length, trimmedTitle.lastIndexOf(" ")))+"....";
            }else{
                var trimmedTitle = title;
            }
            //re-trim if we are in the middle of a word

            var bcove_video_length = '';
            var yt_video_url = '';
            var yt_vid_duration = '';
            var vz_video_length='';
            var vid_duration = '';

             if(type == 'videos'){
                if(video_duration != '' && video_duration != null && video_duration != undefined){
                    vid_duration = video_duration;
                    //console.log('video duration is: '+video_duration);
                }else if(bcove_vid_length != '' && bcove_vid_length != null && bcove_vid_length != undefined){
                    //console.log('type is: '+bcove_vid_length);
                    //console.log('title is: '+title);
                    bcove_video_length = bcove_vid_length;

                    //console.log(bcove_video_length);

                    var bcove_vid_duration = bcove_video_length.split("</strong>");
                    bcove_vid_duration = bcove_vid_duration[1].split("</span>");
                    bcove_vid_duration = Number(bcove_vid_duration[0].trim());

                    var min = (bcove_vid_duration/1000/60) << 0,
                    sec = Math.round((bcove_vid_duration/1000) % 60);
                    min = (min.toString().length==1) ? '0'+min : min;
                    sec = (sec.toString().length==1) ? '0'+sec : sec;
                    vid_duration = min + ':' + sec;
                }
            }

            //console.log(title+": "+bcove_vid_length);
            //console.log(yt_vid_url);

            /*if(bcove_vid_length != '' && bcove_vid_length != null && bcove_vid_length != undefined && typeof bcove_vid_length != undefined){
                bcove_video_length = bcove_vid_length;

                var bcove_vid_duration = bcove_video_length.split("</strong>");
                bcove_vid_duration = bcove_vid_duration[1].split("</span>");
                bcove_vid_duration = Number(bcove_vid_duration[0].trim());

                var min = (bcove_vid_duration/1000/60) << 0,
                sec = Math.round((bcove_vid_duration/1000) % 60);
                min = (min.toString().length==1) ? '0'+min : min;
                sec = (sec.toString().length==1) ? '0'+sec : sec;
                bcove_video_length = min + ':' + sec;
            }
             if(vz_vid_url != '' && vz_vid_url != null && vz_vid_url != undefined){
            //	console.log(vz_vid_url);
                vzaar_vid_url=vz_vid_url;
                vzaar_vid_id=vz_vid_url.split('/')[3];
                vzaar_vid_id=vzaar_vid_id;
                $.ajax({
                    url: "http://www.101india.com/vz-player.php",
                    data: {videoid: vzaar_vid_id},
                    async: false,
                    success: function(data){

                            var min = (data/1000/60) << 0,
                            sec = Math.round((data/1000) % 60);
                            min = (min.toString().length==1) ? '0'+min : min;
                            sec = (sec.toString().length==1) ? '0'+sec : sec;
                            vz_video_length = min + ':' + sec;

                    }
                }); 
            }
            if(yt_vid_url != '' && yt_vid_url != null && yt_vid_url != undefined){
                yt_video_url = yt_vid_url;
                var pos = yt_video_url.indexOf("?v=");
                var yt_duration = yt_video_url.substring(pos+3);
                var yt_time = '';

                $.ajax({
                    url: "https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id="+yt_duration+"&key=AIzaSyAiwWY-OB3DvxUm9WZAoT6MUHSyg8Le2MY",
                    async: false,
                    success: function(data){
                        if(data.items[0].contentDetails.duration.indexOf('M') != -1)
                        {
                            var playTime = data.items[0].contentDetails.duration.split("M");
                            var min = playTime[0].split("PT");
                            min = min[1];

                            var sec = playTime[1].split("S");
                            sec = sec[0];

                            min = (min.toString().length==1) ? '0'+min : min;
                            sec = (sec.toString().length==1) ? '0'+sec : sec;

                            yt_time = min + ':' + sec;
                            yt_vid_duration = yt_time;
                        }else{
                            var playTime = data.items[0].contentDetails.duration.split("S");
                            var min = 00;

                            var sec = playTime[0].split("PT");
                            sec = sec[1];

                            min = (min.toString().length==1) ? '0'+min : min;
                            sec = (sec.toString().length==1) ? '0'+sec : sec;

                            yt_time = min + ':' + sec;
                            yt_vid_duration = yt_time;
                        }	
                    }
                });
            }*/

            tempdata.title = trimmedTitle.trim();
            tempdata.description = trimmedDescription;
            tempdata.article_category = article_category.trim();
            tempdata.thumb_image = thumb_image.trim();
            tempdata.type = type.trim();
            tempdata.path = path.trim();
            tempdata.publication_date_published_at = publication_date_published_at;
            /*if(bcove_vid_length != '' && bcove_vid_length != null && bcove_vid_length != undefined){
                tempdata.vid_duration = bcove_video_length;
            }else if(yt_vid_url != '' && yt_vid_url != null && yt_vid_url != undefined){
                tempdata.vid_duration = yt_vid_duration;
            }else{
                tempdata.vid_duration = vz_video_length;
            }*/
            if(type == 'videos'){
                tempdata.vid_duration = vid_duration;
            }

            //alert(tempdata);

            var categoryName = article_category;
            if(categoryName){
                var posCat=categoryName.indexOf('101');
                if(posCat >= 0){
                    if(categoryName == "101 Travel"){
                        tempdata.url = baseUrl+'/travel-food';
                        tempdata.typeName = 'Travel & Food';
                        tempdata.linkClass = 'travelFood';
                    }else if(categoryName == "101 Janta"){
                        //console.log(categoryName+"inside janta");
                        tempdata.url = baseUrl+'/people';
                        tempdata.typeName = 'People';
                        tempdata.linkClass = 'people';
                    }else{
                        //$typeLink = $base_url.'/'.strtolower(str_replace('101 ','',categoryName));
                        //tempdata.url = baseUrl+'/'+categoryName.replace("101 ", "").toLowerCase();
                        textClass = categoryName.replace("101 ", "");
                        textClassName = textClass;
                        textClass = textClass.split("&");
                        textClasstemp = [];
                        for(j=0;j<textClass.length;j++){
                            if(j==0){
                                textClasstemp[j] = textClass[j];
                                textClass[j] = textClass[j].toLowerCase();

                            }else{
                                var f = textClass[j].charAt(0).toUpperCase();
                                textClass[j] = f + textClass[j].substr(1);

                                var rmv = ['&amp;','&AMP;','Amp;','amp;',' ', ' ','&'];
                                for(cc=0;cc<rmv.length;cc++){
                                    textClasstemp[j] = textClass[j];
                                    var found = textClasstemp[j].indexOf(rmv[cc]);
                                    if(found!=-1){
                                        textClasstemp[j] = textClasstemp[j].replace(rmv[cc], '');
                                        break;	
                                    }
                                }
                            }
                        }
                        textClassNameLast = textClasstemp.join('&');
                        //console.log(textClassNameLast+"----------");
                        textClass = textClass.join('');
                        //console.log(textClass+"----------------");
                        var textUrl;
                        var rmv = ['&', 'amp;','&AMP;','&amp;', 'Amp;', ' ', ' '];
                        for(l=0;l<rmv.length;l++){
                            var found = textClass.indexOf(rmv[l]);
                            textUrl = textClass.replace(rmv[l], '-');
                            textClassName = textClassName.replace(rmv[l], '');
                            if(found!=-1){
                                textClass = textClass.replace(rmv[l], '');
                            }
                        }
                        tempdata.url = baseUrl+'/'+textUrl.toLowerCase();
                        tempdata.typeName = textClassNameLast;
                        tempdata.linkClass = textClass;
                    /*
                        $linkClass = str_replace(array('&', 'amp;', '&amp;', 'Amp;', ' '), array('', '', '', '', ''), $textClass);
                    */	
                    }
                }else{
                    textClass = categoryName;
                    textClass = textClass.split("&");
                    if(textClass == 'The Brief'){
                        textClass = 'brief';
                    }
                    textClasstemp = [];
                //	console.log(textClass);
                    for(j=0;j<textClass.length;j++){
                        if(j==0){
                            textClasstemp[j] = textClass[j];
                            textClass[j] = textClass[j].toLowerCase();	
                            //console.log(textClass);										
                        }else{
                            textClasstemp[j] = textClass[j];
                            var rmv = ['&', 'amp;', '&amp;', 'Amp;', ' ', ' '];
                            for(cc=0;cc<rmv.length;cc++){
                                var found = textClass[j].indexOf(rmv[cc]);
                                if(found!=-1){
                                    textClasstemp[j] = textClasstemp[j].replace(rmv[cc], '');
                                    break;
                                }
                            }
                            var f = textClass[j].charAt(0).toUpperCase();
                            textClass[j] = f + textClass[j].substr(1);
                            //console.log(textClass);
                        }
                    }
                    //console.log(textClasstemp+"---------");
                    if(textClass == 'brief'){
                        textClassNameLast = 'The Brief';
                        tempdata.typeName = textClassNameLast;
                    }else{
                        textClassNameLast = textClasstemp.join('&');
                        tempdata.typeName = textClassNameLast;
                    }	

                    if(textClass != 'brief'){
                        textClass = textClass.join('');
                    }	
                    //console.log(textClass+"----------------");
                    var rmv = ['&', 'amp;', '&amp;', 'Amp;', ' ', ' '];
                    for(l=0;l<rmv.length;l++){
                        var found = textClass.indexOf(rmv[l]);
                        if(found!=-1){
                            textClass = textClass.replace(rmv[l], '');
                        }
                    }


                    tempdata.linkClass = textClass;

                    for(p=0;p<textClasstemp.length;p++){
                        textClasstemp[p]=textClasstemp[p].trim();
                    }
                    if(textClass != 'brief'){
                        textUrl = textClasstemp.join('-');
                    }else{
                        textUrl = 'brief';
                    }	
                    tempdata.url = baseUrl+'/'+textUrl.toLowerCase();
                }
            }
            var image_url=baseUrl+"/sites/all/themes/new_101_india_theme/images/";
            if(tempdata.type == 'videos'){
                tempdata.contentIcon = image_url + 'video-play-icon.png';
                tempdata.contentText = '';
                tempdata.contentText = '<span>' + tempdata.vid_duration + '</span>';
                tempdata.contentText = $sce.trustAsHtml(tempdata.contentText);
                tempdata.contentClass = ' class="play"';
            }else if(tempdata.type == 'series'){
                tempdata.contentIcon = image_url + 'series-icon.png';
                tempdata.contentText = '';
                tempdata.contentClass = '';
            }else{
                tempdata.contentIcon = image_url + 'read-icon.png';
                tempdata.contentText = '';
                tempdata.contentClass = '';
            }
            return tempdata;
        }				


        function findWithAttr(array, attr, value) {	
            for(var i = 0; i < array.length; i += 1) {
                //console.log(array);
                //console.log(array[i].nid+"------------"+value);
                if(array[i].nid == value) {
                    return i;
                }
            }
        }					
        countFinal = 0;
        loadonce = 0;

        function fetchData(){
            //alert("hellow askjcakjcn");
            var NewData = [];

             if(loadonce == 0){

            responseSeededPromise = $http({
                    url: Drupal.settings.basePath + 'data/getAllNodequeVideos',
                    type: 'get',
                    async : false   
                });       
                responseSeededPromise.success(function(dataSeeded, status, headers, config) {
                    //console.log(dataSeeded);
                    for(i=0;i<dataSeeded.length;i++){
                        //console.log(dataSeeded);
                        //console.log(dataSeeded);
                        //console.log("nodequeue data");
                        //console.log(dataSeeded[i].nid+"-----------------------nid");
                        series.push(dataSeeded[i].nid);
                        var da = insertData(dataSeeded[i].title,dataSeeded[i].description,dataSeeded[i].article_category,dataSeeded[i].thumb_image,dataSeeded[i].type,dataSeeded[i].path,dataSeeded[i].publication_date_published_at,dataSeeded[i].bcove_video_length,dataSeeded[i].yt_video_url,dataSeeded[i].vz_vid_url,dataSeeded[i].video_duration);
                        NewData.push(da);
                        //console.log(series);
                    }
                })
                loadonce =1;
            }


            //get 20 content 
            $timeout(function() {
            var responsePromise = $http({
                url: Drupal.settings.basePath + 'data/getContentByCatVideos',
                type: 'get'
            });

            responsePromise.success(function(data, status, headers, config) {

                if(data.length>0){
                    var baseUrl=window.location.origin;
                    for(i=0;i<data.length;i++){
                        if((series.indexOf(data[i].nid))==-1){
                            //console.log("not series else if");
                            series.push(data[i].nid);
                            var da = insertData(data[i].title,data[i].description,data[i].article_category,data[i].thumb_image,data[i].type,data[i].path,data[i].publication_date_published_at,data[i].bcove_video_length,data[i].yt_video_url,data[i].vz_vid_url,data[i].video_duration);
                            NewData.push(da);
                        }
                    }

                    //alert(NewData.length);
                    if(NewData.length>0)
                    {
                        for(j=0;j<NewData.length;j++){
                            finalArray.push(NewData[j]);	
                        }
                    }

                    if(data.length)
                    {
                        lastnid=data[data.length-1].nid;        // To get las nid from list
                    }

                    //console.log(NewData);
                    l=countFinal+11;
                    fArray = [];
                    //console.log(l);
                    for(k=countFinal;k<=l;k++)
                    {
                        //console.log(k+"------------"+l);
                        if(finalArray[k])
                        {
                            fArray.push(finalArray[k]);
                            countFinal=k;
                            countFinal=++countFinal;
                            document.getElementById("loadMoreBtn").style.visibility = "visible";
                        }
                        else{
                            document.getElementById("loadMoreBtn").style.visibility = "hidden";
                        }
                    }
                    
                    if(initialLoad == true){
                        initialLoad = false;
                        $scope.loaded = true;
                    }else{

                        //if((data.length!=0) || (typeof(data.length)!= undefined)) {
                            //console.log(NewData.length);
                            $scope.busy = false;
                            $scope.Data.push.apply($scope.Data, fArray);
                            $scope.loaded = true;

                        //}else{
                        //  document.getElementById("loadMoreBtn").style.display = "none";
                        //}
                    }
                }else{
                    $('.listContent').html('<div class="noData"><p>No Results Found in this Category</p></div>');		
                }	
            });
            responsePromise.error(function(data, status, headers, config) {
                console.log("AJAX failed! "+data);
            });
            }, 1000);    
        }

        var loadCount=0;
        $scope.myData.autoLoad = function() {
            //alert(i);
            if(loadCount<3)
            {
                document.getElementById("loadMoreBtn").style.visibility = "hidden";
                $scope.busy = true;
                if($scope.loaded){
                    $scope.loaded = false;
                    $timeout(function() {
                        fetchData();
                        loadCount++;
                    }, 1000);
                }
            }
            else{
                $scope.check = true;
            }
        }

        $scope.myData.doClick = function() {
            document.getElementById("loadMoreBtn").style.visibility = "hidden";
            $scope.busy = true;
            if($scope.loaded){
                $scope.loaded = false;
                $timeout(function() {
                    fetchData();
                }, 1000);
            }
        }
    });