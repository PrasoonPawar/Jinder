<?php 
session_start();
$userType = $_SESSION["user_type"];
$userEmail = $_SESSION["email"];
$host='localhost';
  $user='jbh262';
  $password='Jay@351';
  $database='jbh262';
  $table='jinder_users';
  $validate = true;
  $connection = mysql_connect($host,$user,$password,$database) or die("Connection to MYSQL failed!</br> ". mysql_error());
  
if($userType == "jobSeeker"){
	
	$query = "SELECT * FROM jbh262.Jobs_Posted WHERE Job_Posted_Id NOT IN (SELECT Job_Posted_Id from jbh262.Job_Logs where email = '". $userEmail." AND Status is not NULL')";
	$activeJobs = mysql_query($query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
	$response = array();
	$response['jobs'] = array();
	while($row = mysql_fetch_assoc($activeJobs)){
	array_push($response['jobs'],$row);
	}
	$data =  json_encode($response);
}else{
	$query = "SELECT * FROM jbh262.Job_Seekers";
	$activeJobSeekers = mysql_query($query, $connection) or die("MYSQL - " . $function . " query failed!</br> " . mysql_error());
	$response = array();
	$response['jobSeekers'] = array();
	while($row = mysql_fetch_assoc($activeJobSeekers)){
	array_push($response['jobSeekers'],$row);
	}
	$data =  json_encode($response);
}
?>
<!DOCTYPE html>
<html>
   <head>
      <link href = "https://cdnjs.cloudflare.com/ajax/libs/extjs/6.2.0/classic/theme-crisp-touch/resources/theme-crisp-touch-all.css" 
         rel = "stylesheet" />
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
      <script type = "text/javascript" 
         src = "https://cdnjs.cloudflare.com/ajax/libs/extjs/6.2.0/ext-all.js"></script>
      
      <script type = "text/javascript">
         Ext.onReady(function() {
			 var dataFromPHP = <?php echo $data ;?>;
			 console.log(Object.getOwnPropertyNames(dataFromPHP) == "jobSeekers");
			 console.log(Object.getOwnPropertyNames(dataFromPHP) == "jobs");
			 var arrayName = Object.getOwnPropertyNames(dataFromPHP);
			 console.log(dataFromPHP);
			 
			var jobID = 0;
        var deviceWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        var deviceHeight = (window.innerHeight > 0) ? window.innerHeight : screen.height;
        console.log(deviceWidth);
		var dataCount = 0;
		var userType, currJobID;
		var currUserEmail = '<?php echo $userEmail ;?>';
		console.log(currUserEmail);
		if(Object.getOwnPropertyNames(dataFromPHP) == "jobSeekers"){
			userType = "e";
		}else {
			userType = "js";
			
		}
        function addNextJob() {
			if(dataCount < dataFromPHP[arrayName].length){
			if(Object.getOwnPropertyNames(dataFromPHP) == "jobSeekers"){
				var title = dataFromPHP[arrayName][dataCount].First_Name + dataFromPHP[arrayName][dataCount].Last_Name;
				var description = dataFromPHP[arrayName][dataCount].Description;
				
			 }else{
				 var title = dataFromPHP[arrayName][dataCount].Job_Title + "-" + dataFromPHP[arrayName][dataCount].company;
				 var description = dataFromPHP[arrayName][dataCount].Description;
				 currJobID = dataFromPHP[arrayName][dataCount].Job_Posted_Id;
			 }
            /*retrive the next job from db*/
            //var newJob = "job" + jobID++;
            Ext.getCmp('mainPanel').add(
                [{
                    xtype: 'panel',
                    title: title,
                    id: "job" + dataCount,
                    width: deviceWidth/5,
                    html: description,
                    listeners: {
                        afterrender: function (view) {
                            Ext.getCmp("job" + dataCount).el.setLeft((deviceWidth/2) - (Ext.getCmp("job" + dataCount).getWidth()/2));
                            console.log(screen.height);
                            Ext.getCmp("job" + dataCount).el.setTop((deviceHeight/2)-50);
                        this.source = new Ext.drag.Source({
                element: Ext.getCmp("job" + dataCount).el,
                constrain: {
                    x: [0, 1300],
                    y: [deviceHeight/2, deviceHeight/2]

                },

                listeners: {

                    dragend: function (source, info) {
						console.log("current pos id "+ currJobID);
                        var pos = info.element.current;
                        if (pos.x >= (deviceWidth - (deviceWidth / 4)) - Ext.getCmp("job" + dataCount).getWidth()) {
							dataCount++;
                            source.getElement().hide();
							console.log(currJobID + currUserEmail);
							$.ajax({type: "GET", url: "logQuery.php", data: {func: 'checkExisting',Job_Posted_Id: currJobID, email: currUserEmail},success: function(result){ 
							console.log(result);
							console.log(userType);
							
							///CHANGE IT FROM CURRUSEREMAIL TO JSEMAIL
							var obj = JSON.parse(result);
							//window.alert(result);
							console.log("done into the check");
							if (obj === undefined || obj.length == 0) {
    // array empty or does not exist-
							console.log("empty array");
							/*******Create a new entry in the log*********/
							///CHANGE IT FROM CURRUSEREMAIL TO JSEMAIL
							if(userType == "js"){
								
							$.ajax({type: "GET", url: "logQuery.php", data: {func: 'addNew', Job_Posted_Id: currJobID, email: currUserEmail, Status: 'Accepted'}, success: function(result1){ 
								console.log("entry created");
							}
							}
							);
							}else{
									$.ajax({type: "GET", url: "logQuery.php", data: {func: 'addNew', Job_Posted_Id: currJobID, email: currUserEmail, Status_Employer: 'Accepted'}, success: function(result1){ 
								console.log("entry created");
							}
							}
							);
							}
							}
							for(row in obj){
								/*update the status for that id*/
								/*CHeck for a match*/
								console.log(obj[row]);
								/*$.ajax({type: "GET", url: "logQuery.php", data: {'func': updateEsisting, Job_Posted_Id: currJobID, email: currUserEmail}, success: function(result1){ 
							
							}
							}
							);*/
								
							}
							}
							});
							
                             Ext.toast('Applied');
                            addNextJob();
                        } else if (pos.x <= deviceWidth / 4) {
                            console.log('job rejected');
							dataCount++;
                            source.getElement().hide();
                            Ext.toast('Ignored');
                            addNextJob();
                        } else {
                            console.log('bring me backkk');
                            source.getElement().setLeft((deviceWidth/2) - (Ext.getCmp("job" + dataCount).getWidth()/2));
                            //console.log(pos.x + "///" + pos.y);
                        }
                        //source.getElement().setHtml('Drag Me!');
                    }
                }
            });
                        }

                    }
                }]);

			}
        }

  
        Ext.create('Ext.panel.Panel', {
            xtype: 'panel',
            //controller: 'drag-simple',
            id: 'mainPanel',
            width:  deviceWidth,
            height: deviceHeight,
            title: 'Jinder, start swiping start working',
            bodyPadding: 5,
            bodyStyle: {
            'background': 'url(http://159.65.173.161/redside.png), url(http://159.65.173.161/greenside.png)',
            'background-repeat': 'no-repeat, no-repeat',
            'background-position': 'left, right',
            'background-size':  (deviceWidth / 4) + 'px,' + (deviceWidth/4) + 'px',


            },
            renderTo: Ext.getBody(),
            listeners: {
                afterrender: function () {
                    addNextJob();
                }
            }
           

        });
		 
		 });
		/*var userType = <?php echo json_encode($_SESSION["user_type"]);?>;
		alert(userType);*/
      </script>
   </head>
   
   <body>
      <div id = "panel" > </div>
   </body>
</html>

