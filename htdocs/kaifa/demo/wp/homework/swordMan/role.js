/**
 * Created with JetBrains WebStorm.
 * User: Hand_Tug
 * Date: 14-9-9
 * Time: 下午1:53
 * To change this template use File | Settings | File Templates.
 */
function init(){
    if(typeof(localStorage)=='undefined'){
        console.log(typeof(localStorage));
        var a="var localStorage={username:'null',killNum:'null',deadNum:'null'};";
        eval(a);
    }
    if(!localStorage.killNum){
        localStorage.killNum=0;
    }
    if(!localStorage.deadNum){
        localStorage.deadNum=0;
    }
    url='http://180.171.139.212:70';
    socket=io.connect(url);
    imgArr=[];
    manArr=[];
    swordArr=[];
    deadBodyArr=[];
    canvas=document.getElementById('can');
    can=canvas.getContext('2d');
    g_w=canvas.width=640;
    g_h=canvas.height=480;
    mouseX= 0,mouseY=0;
    sceneC='game1';
    button1=new Button('b_single',10,10,100,40);
    id = Math.round($.now()*Math.random());
    /*man1=new Man(50,400,40,40);
    manArr[id]=man1;
    sword1=new Sword(man1);
    swordArr[id]=sword1;*/
    //deadBodyArr[1]=new DeadBody(0,0);
    /*manArr[1]=new Man(300,400,40,40);
    manArr[1].dir='l';
    swordArr[1]=new Sword(manArr[1]);
    manArr[1].id=1;*/
    lineX=460;
    mousePosition=function(mouseX,mouseY,x,y,w,h){
        if(mouseX>x&&mouseX<(x+w)&&mouseY>y&&mouseY<(y+h)){
            return true;
        }else{
            return false;
        }
    }
    arc=function(x,y,r){
        can.globalAlpha=1;
        can.beginPath();
        can.arc(x,y,r,0,Math.PI*2,true);
        can.closePath();
        can.stroke();
    }
    line=function(x,y,xx,yy){
        can.save();
        can.globalAlpha=1;
        can.beginPath();
        can.moveTo(x,y);
        can.lineTo(xx,yy);
        can.closePath();
        can.strokeStyle='gray';
        can.stroke();
        can.restore();
    }
    defence=function(a,b){
        if(a.kick=='k'&& b.kick=='a'&& a.dir!= b.dir&& a.sp== b.sp){
            return true;
        }else{
            return false;
        }
    }
    killsomebody=function(){     //攻击判定
        for(var i in manArr){
            if(i!=id&&manArr[i].alive&&manArr[id].alive){
                if(manArr[id].kick=='k'){
                    var manX1=manArr[i].x+9;
                    var manX2=manArr[i].x+9+manArr[id].w-20;
                    var lswoX1=swordArr[id].x;
                    var rswoX1=swordArr[id].x+swordArr[id].w;

                        if(lswoX1<manX2&&lswoX1>(manX1-swordArr[id].w/2)){
                            if(!defence(manArr[id],manArr[i])){
                                localStorage.killNum++;
                                afterKill(i,swordArr[id].dir);
                                socket.emit('kill',{id:i,id2:id,dir:swordArr[id].dir,killNum:manArr[id].killNum});
                            }else{

                                manArr[id].y=415;
                                socket.emit('moving',{
                                    id:id,
                                    y:manArr[id].y
                                });
                            }

                        }



                }
            }
        }
    }

    afterKill=function(i,d){
        if(manArr[i].alive){

            manArr[id].killNum=localStorage.killNum;
            manArr[i].alive=false;
            var a=new DeadBody(manArr[i].x,manArr[i].y);
            a.dir=d;
            deadBodyArr.push(a);

        }

    }
    newMan=function(idd){
        var x=Math.floor(Math.random()*600);
        manArr[idd]=new Man(x,400,40,40);
        manArr[idd].dir='l';
        swordArr[idd]=new Sword(manArr[idd]);
        manArr[idd].id=idd;
        if(idd==id){
            manArr[idd].username=localStorage.username;
            manArr[idd].killNum=localStorage.killNum;
            manArr[idd].deadNum=localStorage.deadNum;
        }
    }
    outMan=function(idd){
        delete swordArr[idd];
        delete manArr[idd];
    }
    //newMan(1);
    //newMan(2);
    newMan(id);
    (function Socket(){
        socket.on('kill',function(data){
            afterKill(data.id,data.dir);
            manArr[data.id2].killNum++;
            localStorage.deadNum++;
            manArr[id].deadNum=localStorage.deadNum;
        });
        socket.on('moving',function(data){
            if(data.x)manArr[data.id].x=data.x;
            if(data.y)manArr[data.id].y=data.y;
            if(data.dir)manArr[data.id].dir=data.dir;
            if(data.sp)manArr[data.id].sp=data.sp;
            if(data.y)manArr[data.id].y=data.y;
            if(data.deadNum)manArr[data.id].deadNum=data.deadNum;
            if(data.jump)manArr[data.id].jump=data.jump;
            if(data.skill)manArr[data.id].skill=data.skill;
            //manArr[data.id].kick=data.kick;
            manArr[data.id].jd=data.jd;
            if(data.alive){
                manArr[data.id].alive=data.alive;
            }
        });
        socket.emit('login',{
            id:id,
            username:manArr[id].username,
            killNum:manArr[id].killNum,
            deadNum:manArr[id].deadNum,
            alive:manArr[id].alive,
            x:manArr[id].x
        });
        socket.on('getout',function(id){
            console.log(id);
            for(var i in manArr){
                if(id.indexOf(manArr[i].id)==-1){

                    console.log(manArr[i].id);
                    outMan(i);
                }
            }
        });
        socket.on('disconnect',function(){
            socket.emit('getid',{id:id});
        });
        socket.on('login',function(data){


            if(!(data.id in manArr)){

                newMan(data.id);
                manArr[data.id].x=data.x;
                manArr[data.id].username=data.username;
                manArr[data.id].killNum=data.killNum;
                manArr[data.id].deadNum=data.deadNum;
                manArr[data.id].alive=data.alive;
                for(var i in manArr){
                    if(manArr[i].ip==data.ip){
                        delete manArr[i];
                    }
                }
                manArr[data.id].ip=data.ip;
                socket.emit('login',{
                    id:id,
                    username:manArr[id].username,
                    killNum:manArr[id].killNum,
                    deadNum:manArr[id].deadNum,
                    alive:manArr[id].alive,
                    x:manArr[id].x
                });


            }

            for(var i in manArr){
                console.log(i,' ');
            }
            //manArr[data.id].x=data.x;
        });
    })();


}
    //////////////////////////////////按钮
    function Button(img,x,y,w,h){
        var t=this;
        t.x=x, t.y=y, t.w=w, t.h=h, t.keydown=false, t.keyclick=false;
        imgCreate(img);
        t.draw=function(){

            t.keydown=mousePosition(mouseX,mouseY, t.x, t.y, t.w, t.h);
            can.drawImage(imgArr[img],x,y,w,h);
            if(t.keydown){
                can.strokeRect(t.x, t.y, t.w, t.h);
            }
        }
        t.click=function(){
            $('#can').click(function(){
                if(t.keydown&&sceneC=='menu'){
                    t.keyclick=true;
                }
            });
        }
    }
    ///////////////////////////////////角色
    function Man(x,y,w,h){
        var kkk=0;
        var xxx;
        var xxx1;
        var t=this;
        t.jd=false;
        t.jump=false;
        t.ip='';
        t.x=x, t.y=y, t.w=w, t.h=h, t.dir='r';
        t.killNum=0;
        t.deadNum=0;
        t.gv=0;
        t.g=0.2;
        t.id=id;
        t.v=3;
        t.gif=1;
        t.sp='u';
        t.kick='a'; //判断是否出手
        t.alive=true;
        t.cut=false; //是否被切
        t.defence=false;
        var ddCan=true;
        var gif=0;
        var v=0;
        var kick=0;
        var canjump=0;
        t.jumpv=0;
        var manImgArr=['a_u_r','a_u_l','a_d_r','a_d_l','k_u_r','k_u_l','k_d_r','k_d_l','l_r1','l_l1','l_r2','l_l2'];
        for(var i in manImgArr){
            imgCreate(manImgArr[i]);
        }
        t.draw=function(){
            if(t.alive){
                t.con();
            }
            if(t.id==id)t.power();
            t.powerGeyser();
            if(t.alive){
                t.kickgif();
            }
            if(t.id==id){
                if(t.alive){
                    $('#b1')[0].disabled=true;
                }else{
                    //alert();
                    $('#b1')[0].disabled=false;
                }
                console.log(t.alive);
            }


            t.y-= t.jumpv;
            t.gravity();
            if(t.id==id)localStorage.deadNum= t.deadNum;
            if(t.alive){

                can.fillText('kill:'+ t.killNum+' dead:'+ t.deadNum, t.x, t.y-40);
                can.fillText(t.alive, t.x, t.y-50);
                can.fillText(t.username, t.x, t.y-60);
                can.drawImage(imgArr[t.kick+'_'+ t.sp+'_'+ t.dir], t.x, t.y, t.w, t.h);
                can.drawImage(imgArr['l_'+ t.dir+ t.gif], t.x, t.y, t.w, t.h);
                //can.strokeRect(t.x+9, t.y, t.w-20, t.h); //人的实际位置
            }
            if(t.id==id){
                can.save();
                if(kick==0&& t.jumpv==0){//kick==0 表示可以攻击
                    can.fillStyle='black';
                    can.strokeStyle='black';
                }else{
                    can.fillStyle='#E4E4E4';
                    can.strokeStyle='#E4E4E4';
                }
                can.strokeRect(5,g_h-20,15,15);
                can.font='15px 微软雅黑';
                can.fillText('A',6,g_h-7);

                if(kick!=0&& t.alive){
                    can.save();
                    can.font = '30px 微软雅黑';
                    can.fillStyle='red';
                    can.fillText('!', t.x+15, t.y-5);
                    can.restore();
                }
                can.restore();
            }


        }

        t.powerNum=0;
        var powerMax=200;
        t.skill=0;
        var skill3=0;
        var pg1=0;
        var skilla=0;
        t.pgx=0;
        t.pgy=0;
        t.pgw=0;
        t.pgh=0;
        t.pgd='r';
        t.pgin=false;

        t.powerGeyser=function(){   //技能处理
            can.save();
            if(t.kick=='k'){

                if(t.skill!=0){
                    skilla= t.skill;
                    if(skilla==1)pg1=50;
                    if(skilla==2)pg1=50;
                    if(skilla==3)pg1=50;
                    //can.strokeRect(t.x+9, t.y, t.w-20, t.h);
                    if(skilla==1){
                        if(t.dir=='r'){
                            t.pgx= t.x+9+t.w-20+200;
                            if(t.x+200>g_w)t.pgx=g_w-10;
                        }else{
                            t.pgx= t.x+9-200;
                            if(t.x-200<0)t.pgx=10;
                        }
                        t.pgh= t.h;
                        t.pgy=lineX- t.pgh;
                        t.pgw=1;
                    }
                    if(skilla==2){
                        t.pgw=20;
                        if(t.dir=='r'){
                            t.pgd='r';
                            t.pgx= t.x+9+t.w-20+10;

                        }else{
                            t.pgd='l';
                            t.pgx= t.x+9-10- t.pgw;

                        }
                        t.pgh= t.h;
                        t.pgy=lineX- t.pgh;

                    }
                    if(skilla==3){

                    }
                }

                //console.log(t.skill);
                t.skill=0;
            }
            console.log(skilla);
            switch (skilla){
                case 1:can.fillStyle='black';break;
                case 2:can.fillStyle='red';break;
                case 3:can.fillStyle='yellow';break;
            }
            if(pg1>0)pg1--;
            if(pg1==0)skilla=0;
            if(pg1>0){
                t.pgin=true;
            }else{
                t.pgin=false;
            }
            if(t.pgin){
                if(skilla==1)can.fillRect(t.pgx, t.pgy, t.pgw, t.pgh);
                if(skilla==2){
                    if(t.pgd=='l'){
                        t.pgx-=9;
                    }else{
                        t.pgx+=9;
                    }
                    can.fillRect(t.pgx, t.pgy, t.pgw, t.pgh);
                }



            }
            can.restore();

        }
        t.power=function(){
            if(t.powerNum<powerMax)t.powerNum+=2;
            if(t.powerNum==powerMax&& t.skill<3){
                t.skill++;
                if(t.id==id){
                    socket.emit('moving',{
                        id:id,
                        skill: t.skill
                    });
                }
                if(t.skill<3)t.powerNum=0;
            }
            switch (t.skill){
                case 1:can.fillRect(87+powerMax+10,464,10,10);break;
                case 2:can.save();can.fillStyle='red';can.fillRect(87+powerMax+30,464,10,10);can.restore();break;
                case 3:
                    can.save();
                    skill3++;
                    if(skill3<5){
                        can.fillStyle='blue';
                    }else{
                        can.fillStyle='yellow';
                        if(skill3>10)skill3=0;
                    }

                    can.fillRect(87+powerMax+50,464,10,10);
                    can.restore();
                    break;
            }
            can.strokeRect(87,464,powerMax,10);
            can.strokeRect(87+powerMax+10,464,10,10);
            can.strokeRect(87+powerMax+30,464,10,10);
            can.strokeRect(87+powerMax+50,464,10,10);
            can.save();
            can.fillStyle='red';
            can.fillRect(87,464, t.powerNum,10);
            can.restore();
            if(!t.alive){
                t.powerNum=0;
                t.skill=1;
            }
        }
        t.gravity=function(){
            t.y+= t.gv;
            t.gv+= t.g;
            if((t.y+ t.h)>=lineX){
                t.gv=0;
                t.jumpv=0;
                t.y= lineX- t.h;
            }
        }
        var vinit= t.v;
        t.con=function(){
            if(t.jumpv>0){
                t.v=vinit+1;
            }else{
                t.v=vinit;
            }
            if(xxx!= t.x){
                t.gifFun();
                xxx= t.x;
            }
            if(t.jump){

                if(t.id==id)socket.emit('moving',{
                    id:id,
                    jump: t.jump
                });
                t.jumpv=4;
                t.jump=false;
            }

            /*if(t.jumpv>0){
                //t.jumpv--;
            }*/

            if(t.id==id){
                //跳跃
                if(kd&&canjump==0){
                    t.jump=true;
                }

                t.jd=jd;
                if(t.jd){
                    t.socket();
                    xxx1=0;
                }else{
                    if(xxx1==0){
                        t.socket();
                    }
                    xxx1=1;

                }
                if(rd){
                    t.dir='r';
                    //t.gifFun();
                    t.x+= t.v;
                    t.socket();


                }
                if(ld){
                    t.socket();
                    t.dir='l';
                    //t.gifFun();
                    t.x-= t.v;

                }

                if(dd&&ddCan){
                    t.socket();
                    t.sp='d';
                    kkk=0;
                }
                if(!dd&&ddCan){
                    if(kkk==0){
                        t.sp='u';
                        t.socket();
                        kkk++;
                    }
                }



            }//

            if(t.x<=0)t.x=0;
            if(t.x>= g_w- t.w)t.x= g_w- t.w;
        }
        t.kickgif=function(){  // 出剑逻辑
            if(t.jd){
                if(kick==0&& t.jumpv==0){
                    $('#kick')[0].currentTime=0;
                    $('#kick')[0].play();

                    t.kick='k';
                    t.powerNum=0;

                    kick=60;
                }

            }
            kick--;
            if(kick<55){
                t.kick='a';
            }
            if(kick<=0){
                kick=0;
            }
            if(t.kick=='k'){
                ddCan=false;
            }else{
                ddCan=true;
            }
        }
        t.gifFun=function(){//腿部动画

            if(gif%10==0){
                t.gif++;
                if(t.gif>2){
                    t.gif=1;
                    gif=0;
                }
            }
            gif++;
        }
        t.socket=function(){
            socket.emit('moving',{
                id: t.id,
                x: t.x,
                sp: t.sp,
                dir: t.dir,
                jd: t.jd
            });
        }
    }
    ///////////////////////////////////宝剑
    function Sword(o){
        var t=this;
        t.id= o.id;
        t.x=50, t.y=50, t.w=40, t.h=40, t.dir='r', t.hand=true;
        var manImgArr=['s_l','s_r'];
        for(var i in manImgArr){
            imgCreate(manImgArr[i]);
        }
        t.draw=function(){
            if(o.alive){
                t.con();
                can.drawImage(imgArr['s_'+ t.dir], t.x, t.y, t.w, t.h);
                can.save();
                can.strokeStyle='red';
                //can.strokeRect(t.x, t.y+20, t.w, t.h-39);//剑的实际位置
                can.restore();
            }
        }
        t.con=function(){
            if(t.hand){
                t.dir= o.dir;
                if(t.dir=='r'){
                    if(o.sp=='u'){
                        t.y= o.y;
                    }else{
                        t.y= o.y+9;
                    }

                    if(o.kick=='k'){
                        t.x= o.x+ o.w;
                    }else{
                        t.x= o.x+ o.w-9;
                    }
                }else{

                    if(o.sp=='u'){
                        t.y= o.y;
                    }else{
                        t.y= o.y+9;
                    }
                    if(o.kick=='k'){
                        t.x= o.x- o.w;
                    }else{
                        t.x= o.x- t.w+9;
                    }
                }
            }
        }
    }
    function DeadBody(x,y){
        var i=0;
        var j=60;
        var t=this;
        t.x=x, t.y=y;
        t.v=1;
        t.id=Math.floor(Math.random()*10000);
        t.img="<img id='die"+t.id+"' src='img/die.gif?"+ t.id+"'/>";
        $('#divdie').append(t.img);

        t.draw=function(){
            t.move();
            var obj=$('#die'+ t.id)[0];
            can.drawImage(obj, t.x, t.y);
        }
        t.move=function(){
            if(t.dir=='r'){
                if(i<j)i++;
                if(i<j&& t.x<g_w-40)t.x+= t.v;

            }
            if(t.dir=='l'){
                if(i<j)i++;
                if(i<j&& t.x>0)t.x-= t.v;
            }
        }
    }
    ///////////////////////////////////
    function imgCreate(img){
        imgArr[img]=new Image();
        imgArr[img].src='img/'+img+'.png';
    }






