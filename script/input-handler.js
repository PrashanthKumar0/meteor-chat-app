
// const _sendto_host_uri="http://localhost:8080/send";
// const _broadcaster_host_uri="./services/broadcaster.php";
const _sendto_host_uri="./services/index.php";


//-[temp]------------------
// let room='testRoom',u_name='user_'+Math.floor(Math.random()*9999);
// let _broadcaster_host_uri="http://localhost:8080/"+room; //room
let _broadcaster_host_uri="./services/broadcaster/index.php"; //room
//-------------------------



let f_upload,f_message,f_send_button;

let _EventSource_handler;
let _cookie_name;

// document.onclick=function(){
//     document.body.requestFullscreen();
// }

function check_and_set_cookie(){
    _cookie_name=document.cookie.match(/SSEID=(.{0,});/gmi);
    if(!_cookie_name) return;
    _cookie_name=_cookie_name.length>0?(_cookie_name[0].split('=')[1]).split(';')[0]:'';
};

const _sendto_req=new XMLHttpRequest();
      _sendto_req.open("POST",_sendto_host_uri);

function input_handler_init(){
    _broadcaster_host_uri="./services/broadcaster/index.php?room="+room;

    f_upload=$("#f_upload");
    f_message=$("#f_message");
    f_send_button=$("#f_send_button");
    
    check_and_set_cookie();
    init_uis();
    
    //--[EVENT SOURCE]---------------------------------------------------
        _EventSource_handler=new EventSource(_broadcaster_host_uri);
            
        _EventSource_handler.addEventListener('message',function(evt){
            // console.log('message:',evt.data);
            // $("#chatScreenChatArea").innerHTML+=('message:',)+"<br><br>";
            // if([sessid])
            try{
            	if(evt.data=="👋") return; //heroku hack for keeping sse alive
                let data=JSON.parse(evt.data);      
                console.log(data);
                box=ui_makeChatBox(data);
                if(!box) { 
                    console.error('failed making box');
                    return;
                }
                $("#chatScreenChatArea").appendChild(box);
                $("#chatScreenChatArea").scrollTo(0,$("#chatScreenChatArea").scrollHeight);
            }catch(err){
                ui_showErrPopup("Error Something Went Wrong on Server!");
            }
        });
        
        _EventSource_handler.onerror=function(err){
            console.log("error :",err);
        }
        // _EventSource_handler.onopen=function(ev){
        //     console.log("opened : ",ev);    
        //     // _send_to_req.onerror=function(){};
        // }

    //--[/EVENT SOURCE]---------------------------------------------------



    f_send_button.onclick=function(){
        let _message=$("#f_message").value;

        let _formData=new FormData();
        _formData.append("room","/"+room);
        _formData.append("u_name",u_name);
        _formData.append("message",_message);
        _formData.append("timestamp",(new Date()));
        
        _sendto_req.open("POST",_sendto_host_uri);
        _sendto_req.send(_formData);

        _sendto_req.onreadystatechange=function(e){
            if(_sendto_req.readyState==4 && _sendto_req.status==200){
                $('body').inneHTML=(_sendto_req.response);
                console.log(_sendto_req.response);
                check_and_set_cookie();
            }
        }        
    };


}



//-----[UI STUFF]----------------------------------

function ui_makeChatBox(data){
    // if(data[0].length<=0) return 0;
    if(!data[0]['chattext']) return 0;
    // console.log((data[0]['sessid']).replace(' ','').match(_cookie_name));
    // console.log(data[0]['chattext']);
    let elem=document.createElement('div');
    let date=new Date(data[0]['js_time']);
    date=date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
    var elDate=document.createElement('div');
    elDate.classList.add('date');
    elDate.innerText=date;
    //idk why thera lots of spaces and key is converted to lower case
    if((data[0]['sessid']).replace(' ','').match(_cookie_name)){ //to me
        //clear input box here
        $('#f_message').value='';
        elem.classList.add('me');
        elem.innerText+=data[0]['chattext'];
        elem.appendChild(elDate);
        return elem;
    }else{//to you
        elem.classList.add('you');
        let name=document.createElement('div');
        name.classList.add('name');
        name.innerText+=data[0]['u_name'];
        elem.innerText+=data[0]['chattext'];
        elem.appendChild(elDate);
        elem.prepend(name);
        return elem;
    }

}
function ui_showErrPopup(errTxt){

}



function init_uis(){
    //show info on app bar
    let empty_container=document.createElement('span');
    let info=document.createElement('span');
    let infoName=document.createElement('span');
    let br=document.createElement('br');
    
    infoName.classList.add('appBarPathAt');
    infoName.classList.add('fa');
    infoName.textContent=u_name;
    info.classList.add('appBarPath');
    info.classList.add('fa');
    info.textContent=room;
    empty_container.appendChild(br);
    empty_container.appendChild(info);
    empty_container.appendChild(infoName);
    $('.appBarAppName').appendChild(empty_container);
}




//-----[/UI STUFF]----------------------------------------------------