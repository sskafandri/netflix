$(document).scroll(function(){
    var isScrolled = $(this).scrollTop() > $(".topBar").height();//this is the document that is page
    $(".topBar").toggleClass("scrolled",isScrolled);// this will add scrolled class if isScrolled is true
})

function volumeToggle(button) {
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);

    $(button).find("i").toggleClass("fa-volume-mute"); //fa-volume-mute is already present so it will remove it as  toggleClass does opposite of every this if it is present it will remove if not it will add it
    $(button).find("i").toggleClass("fa-volume-up");   // this class will be added
}

function previewEnded() {
    $(".previewVideo").toggle(); //it will reverse it video is playing it will pause it 
    $(".previewImage").toggle();// image is hidde then it will be shown
}
function goBack(){  //back button to wrok in video player
    window.history.back();
}

// when ever person move the mouse clear the current timer So stop it show the navigation bar if it is hidden 
// and start the new timer where after 2sec 2000mil sec it will hide the banner
function startHideTimer(){
    var timeout = null;

    $(document).on("mousemove", function(){
       clearTimeout(timeout); //it is javascript function
       $(".watchNav").fadeIn();
       
       timeout = setTimeout(function(){
           $(".watchNav").fadeOut();
       },2000);
    })
}

function initVideo(videoId,username){
    startHideTimer();
    setStartTime(videoId,username);
    updateProgressTimer(videoId,username);
}
function updateProgressTimer(videoId,username){
    addDuration(videoId,username);
//to increase the timer when the video playes
    var timer;

    $("video").on("playing",function(event){
        window.clearInterval(); //stop the timer we will start the new timer
        timer = window.setInterval(function(){
            updateProgress(videoId,username,event.target.currentTime); //playing event is self that is playing and event.target is video and we are saying take the current time of the video
        },3000); //3 sec
    })
    .on("ended",function(){
        setFinished(videoId,username);
        window.clearInterval(timer);
    })
}
//ajax folder will have normal php file but we will acess them with the help of ajax
//ajax request
function addDuration(videoId,username){
    $.post("ajax/addDuration.php",{ videoId: videoId,username: username },function(data){  //file we going to request(path),anomous function it does not have name
        //addDuration.php data that is gone out of this page will goes to this funtion data variale
        if(data !== null && data !== ""){ //rater than value it is also checking its type that is it is checking value and its type as well .."" it is for empty string
            alert(data);
        }
    })
}
function updateProgress(videoId,username,progress){
    $.post("ajax/updateDuration.php",{ videoId: videoId,username: username,progress:progress },function(data){  //file we going to request(path),anomous function it does not have name
        //addDuration.php data that is gone out of this page will goes to this funtion data variale
        if(data !== null && data !== ""){ //rater than value it is also checking its type that is it is checking value and its type as well .."" it is for empty string
            alert(data);
        }
    })
}

function setFinished(videoId,username){
    $.post("ajax/setFinished.php",{ videoId: videoId,username: username },function(data){  //file we going to request(path),anomous function it does not have name
        //addDuration.php data that is gone out of this page will goes to this funtion data variale
        if(data !== null && data !== ""){ //rater than value it is also checking its type that is it is checking value and its type as well .."" it is for empty string
            alert(data);
        }
    })
}
//ajex requiest using jquery ..post because it is post requiest ..we will send data using post method...
//and the first paramenter is the file we want to requied to scond paramenter the data we want to send..{ } is used to send data in username and userid to ajex php page
function setStartTime(videoId,username){
    $.post("ajax/getProgress.php",{ videoId: videoId,username: username },function(data){  //file we going to request(path),anomous function it does not have name
        //addDuration.php data that is gone out of this page will goes to this funtion data variale
        if(isNaN(data)){ //isNotNumber()... is it number or not
            alert(data); //it will show the message
            return;
        }

        $("video").on("canplay",function(){
            this.currentTime = data;
            $("video").off("canplay");
        })
    })
}

function restartVideo(){
    $("video")[0].currentTime = 0;//when we do a square backet [0] like this on jquerry object access is the access to javascript object that it relate to ,,this is way simpler...javascript video object than we set the current time object to 0
    $("video")[0].play(); 
    $(".upNext").fadeOut();   //.upNext is class and we dont need to target javascript object 
}
function watchVideo(videoId){
    window.location.href = "watch.php?id=" + videoId;
}
function showUpNext(){
    $(".upNext").fadeIn();
}