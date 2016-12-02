/**
 * Created by a on 2014/9/8 0008.
 */

$(document).ready(function(){

    (function main(){
        init();
        evlisten();
        scense();
        click();
    })();
    function scense(){

        button1.click();
        setInterval(run,16);
    }
    function run(){
        killsomebody();
        $('#mx').text(mouseX),$('#my').text(mouseY);
        can.clearRect(0,0,g_w,g_h);
        $('#can').mousemove(function(e){
            mouseX= e.offsetX,mouseY= e.offsetY;
        });

        if(sceneC=='menu'){
            button1.draw();

        }
        if(sceneC=='game1'){ //游戏开始后 需要绘制的内容
            for(var i in manArr){
                /*if(manArr[i].alive)*/manArr[i].draw();
                if(swordArr[i])swordArr[i].draw();
            }
            for(var i in deadBodyArr){
                deadBodyArr[i].draw();
            }
            line(0,lineX,640,lineX);
        }
        arc(mouseX,mouseY,3);
        if(button1.keyclick){
            sceneC='game1';
        }
    }
    function click(){
        $('#b2')[0].disabled=true;
        $('#b1').click(function(){
            var x=Math.random()*(g_w-manArr[id].w);
            var y=g_h-2*manArr[id].h;
            manArr[id].alive=true;
            manArr[id].x=x;
            manArr[id].y=y;
            socket.emit('moving',{
                id:id,
                x:x,
                y:y,
                deadNum:manArr[id].deadNum,
                alive:true
            });
        });
    }
//==================================================================//









});