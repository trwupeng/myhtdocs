/**
 * Created with JetBrains WebStorm.
 * User: Hand_Tug
 * Date: 14-1-7
 * Time: 下午2:48
 * To change this template use File | Settings | File Templates.
 */
var ctx=document.getElementById('c').getContext('2d');
var run=function(){

    romate();
    menu();
    //scense1();
    setInterval(timeOut,100);
}
var timeOut=function(){
    if(starF==1){
        timeout++;
    }
    if(timeout>5){
        start=1;
    }

}
var romate=function(){
    var ctt=document.getElementById('cc').getContext('2d');
    var drawR=function(){
        ctt.clearRect(0,0,200,200);
        ctt.translate(100,100);
        ctt.rotate(Math.PI/180*30);
        ctt.translate(-100,-100);
        ctt.drawImage(img_start,0,60,200,80);
    }
    setInterval(drawR,17);
}
onload=run;