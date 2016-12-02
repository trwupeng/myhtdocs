/**
 * Created with JetBrains WebStorm.
 * User: Hand_Tug
 * Date: 14-1-7
 * Time: 下午3:09
 * To change this template use File | Settings | File Templates.
 */
var timeout=0;
var ld=rd=ud=dd=sd=false;
var mx,my;
var start=0;//控制游戏开始
var star=0;
var starF=0;//控制游戏流程
var w=16*1.5,h=33*1.5;
var canrd=canld=candd=canud=true;

var evlisten=function(){
    //控制移动
    document.addEventListener('keydown',function(e){
        if(e.keyCode==68){rd=true;}
        else if(e.keyCode==65){ld=true;}
        else if(e.keyCode==87){ud=true;}
        else if(e.keyCode==83){dd=true;}
        else if(e.keyCode==32){sd=true;}
    },false);
    document.addEventListener('keyup',function(e){
        if(e.keyCode==68){rd=false;}
        else if(e.keyCode==65){ld=false;}
        else if(e.keyCode==87){ud=false;}
        else if(e.keyCode==83){dd=false;}
        else if(e.keyCode==32){sd=false;}
    },false);

/*>>>>>>>>>>>>>>>鼠标监听>>>>>>>>>>>>>>>>>*/

    document.addEventListener('mousedown',function(e){

        if(e.layerX|| e.layerX==0){
            mx= e.layerX;
            my= e.layerY;
        }else if(e.offsetX|| e.offsetX==0){
            mx= e.offsetX;
            my= e.offsetY;
        }
        if(mx>334&&mx<428&&my>277&&my<326){
           starF=1;
        }
        if(start==1){
            if(mx>2*W/3){
                rd=true;
                ld=false;
            }
            if(mx<W/3){
                ld=true;
                rd=false;
            }
            if(mx<2*W/3&&mx>W/3){
                rd=ld=false;
            }
        }

    },false);
    document.addEventListener('mousemove',function(e){

        if(e.layerX|| e.layerX==0){
            mx= e.layerX;
            my= e.layerY;
        }else if(e.offsetX|| e.offsetX==0){
            mx= e.offsetX;
            my= e.offsetY;
        }
        if(mx>334&&mx<428&&my>277&&my<326){
            star=1;
        }else{
            star=0;
        }


    },false);


}