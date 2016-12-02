/**
 * Created with JetBrains WebStorm.
 * User: Hand_Tug
 * Date: 14-1-8
 * Time: 下午12:08
 * To change this template use File | Settings | File Templates.
 */
var speed=5;
var xxx=false;
var g=2;//----------------------------------起跳速度

var Mario=function(x,y){
    this.x=x;
    this.y=y;
    this.s=0;
    var spee=this.s;//-----------------------------重置速度
    var dir;
    this.jumpsp;
    var isjump=false;
    var canjump=true;
    var firjumpsp=13.5;//-------------------------起跳速度
    var temjsp;//---------------------------------临时位置（判定是否浮空）
    var temy;//-----------------------------------起跳高度

    this.jump=function(){
        if(ud&&canjump){
            this.jumpsp=firjumpsp;
            canjump=false;
            isjump=true;
        }
        if(isjump){
            this.y-=this.jumpsp;
            this.jumpsp-=0.5;
            if(this.jumpsp<0)this.jumpsp=0;
            if(this.jumpsp==0){
                if(temjsp==this.y){
                    canjump=true;
                }else{
                    canjump=false;
                    temjsp=this.y;
                }
            }

        }
    }
    this.move=function(){
        if(sd){
            speed=20;
        }else{
            speed=spee;
        }

        if(!rd&&!ld)this.s=1;
        if(rd){
            this.s+=0.1;

            if(this.s>=3)this.s=3;
            dir='r';
            if(this.x<=W/3||map1.x<=-4639){


                this.x+=this.s;

            }

        }
        if(ld){
            this.s+=0.1;

            if(this.s>=3)this.s=3;
            dir='l';
            if(this.x>=2*W/3||map1.x>=0){
                this.x-=this.s;

            }
        }
        if(ud&&xxx){
            this.y-=this.s;
        }
        if(dd){
            this.y+=this.s;
        }


    }
    var img_mario_l=new Image();
    img_mario_l.src="img/role/mario_l.png";
    var img_mario_r=new Image();
    img_mario_r.src="img/role/mario_r.png";
    this.draw=function(){
        document.getElementById('marios').innerHTML=this.s;
        if(!xxx)this.jump();
        this.move();
        if(dir=='l'){

            ctx.drawImage(img_mario_l,this.x,this.y,w,h);
        }else{

            ctx.drawImage(img_mario_r,this.x,this.y,w,h);
        }
    }
}
var mario=new Mario(59,250);