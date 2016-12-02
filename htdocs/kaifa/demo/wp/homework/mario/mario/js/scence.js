/**
 * Created with JetBrains WebStorm.
 * User: Hand_Tug
 * Date: 14-1-7
 * Time: 下午2:45
 * To change this template use File | Settings | File Templates.
 */
    var flyup=false;
    var gra=4;
var img_map1=new Image();
img_map1.src="img/map/1-1.jpg";
var img_start=new Image();
img_start.src="img/start.png";
var img_start1=new Image();
img_start1.src="img/start1.png";
var sx,sy;//-------------------------------------------------以此判断是否遭遇障碍
/*<<<<<<<<<<<<<<<超级玛丽同学的神之第一关>>>>>>>>>>>>>>>>>*/
var Map=function(x,y){
    this.x=x;
    this.y=y;
    var hj_1x=0;
    var hj_1y=0;

    var hj_1=document.getElementById('hj_1');
    var hj_2=document.getElementById('hj_2');
    var sg_1=document.getElementById('sg_1');
    var arr=[
     /*<<<<<<<<<<<<<<<以下是hand呕心沥血之碰撞检测>>>>>>>>>>>>>>>>*/
        [60,39,323,168],[385,205,408,228],[479 ,204 ,599 ,227 ],
        [529,109,551,132],
        [ 674,254 ,717 ,301 ],[ 915,230 ,957 ,301 ],[ 1106,205 ,1149 ,301 ],
        [ 1372,206 ,1413 , 301],[ 1538,179 , 1559,203 ],[ 1847,203 , 1921, 227],
        [ 1921,108 , 2113,131 ],[ 2184,108 , 2280,131 ],[2256 ,204 ,2281 ,227 ],
        [ 2400,203 ,2448 ,227 ],[2544 ,205 ,2568 ,227 ],[ 2617,108 , 2640,131 ],
        [ 2617,205 , 2640,228 ],[ 2689,204 ,2712 ,228 ],[ 2832,204 , 2857,227 ],
        [2904,108,2977,131],[3071,108,3169,132],[3096,204,3145,227],
        [3216,276,3313,300],[3240,252,3313,300],[3265,228,3313,300],
        [3288,204,3313,300],[3360,205,3384,299],[3384,228,3408,300],
        [3408,252,3432,300],[3432,276,3457,300],[3552,276,3672,300],
        [3577,252,3672,300],[3601,228,3672,300],[3625,204,3672,300],
        [3720,204,3744,300],[3745,228,3768,300],[3769,252,3793,300],
        [3793,277,3817,300],[3915,253,3959,300],[4032,205,4128,227],
        [4298,253,4342,301],[4342,276,4561,300],[4368,252,4561,300],
        [4392,228,4561,300],[4416,204,4561,300],[4440,180,4561,300],
        //地面检测
        [4465,157,4561,300],[4489,132,4561,300],[4513,108,4561,300],
        [4753,275,4777,300],
        [0,300,1657,340],[1705,300,2064,340],[2137,300,5000,340],[0,100,20,300],
        /*飞机*/
        /*[669,174,731,199],*/[,,,],[,,,],[,,,],[,,,],[,,,],[,,,],[,,,]
    ];
    for(var i=0;i<arr.length;i++){//---------------------------------位置修正
        arr[i][1]-=4;
        arr[i][3]-=4;
    }
    this.draw=function(){
        this.barrier();
        if(!xxx)this.gravity();
        if(rd&&this.x>-4639&&mario.x>W/3)this.x-=mario.s;
        if(ld&&this.x<0&&mario.x<2*W/3)this.x+=mario.s;
        //if(ld&&this.x<0)this.x+=5;

        ctx.drawImage(img_map1,this.x,this.y,3648*1.5,H);
        ctx.drawImage(hj_1,this.x+660+hj_1x,this.y+156+hj_1y);
        if(sy>=124.5&&sx>=650&&sx<=728)flyup=true;

        ctx.drawImage(hj_2,this.x+1790,this.y+235);
        ctx.drawImage(sg_1,this.x+2870,this.y+33);
    }
    this.barrier=function(){

        /*<<<<<<<<<<<小玛丽的碰撞算法>>>>>>>>>>>>>*/
        for(var i=0;i<arr.length;i++){


                if(sx>arr[i][0]-w&&sy>arr[i][1]-h&&sy<arr[i][3]&&sx<arr[i][2]){


                    if(Math.abs(sx-arr[i][0]+w)<=10){
                        mario.x=arr[i][0]-w+this.x;
                    }
                    if(Math.abs(sx-arr[i][2])<=10){
                        mario.x=arr[i][2]+this.x;
                    }
                    if(Math.abs(sy-arr[i][1]+h)<=gra){
                        mario.y=arr[i][1]-h+this.y;
                    }
                    if(Math.abs(sy-arr[i][3])<=mario.jumpsp){
                        mario.y=arr[i][3]+this.y;
                    }
                }
        }
        //    [388,207,410,229]
    this.gravity=function(){
        mario.y+=gra;
    }

    }
}
var map1=new Map(0,0);
/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
var menu=function(){


    var img_bg=new Image();
    img_bg.src="img/bg.jpg";
    var Begin=function(x,y){
        this.x=x;
        this.y=y;
        this.draw=function(){
            if(star==0&&starF==0)ctx.drawImage(img_start1,this.x,this.y,200,80);

            //if(star==2)ctx.drawImage(img_start,this.x,this.y,200,80);
            if(starF==0){
                if(star==1)ctx.drawImage(img_start,this.x,this.y,200,80);
            }else if(starF==1){
                ctx.drawImage(objj,this.x,this.y-60,200,200);
            }

        }
    }
    var begin=new Begin(280,260);
    var obj=document.getElementById('menu');
    var objj=document.getElementById('cc');

    var drawMenu=function(){
        sx=mario.x-map1.x;
        sy=mario.y-map1.y;
        var M=function(a){
            var b=Math.floor(a);
            return b;
        }
        document.getElementById('x').innerHTML=M(map1.x);
        document.getElementById('mx').innerHTML=M(mario.x);
        document.getElementById('my').innerHTML=mario.y;
        document.getElementById('t').innerHTML=timeout;
        document.getElementById('mox').innerHTML=M(mx);
        document.getElementById('moy').innerHTML=my;
        document.getElementById('sx').innerHTML=M(sx);
        document.getElementById('sy').innerHTML=sy;
        document.getElementById('momx').innerHTML=M(mx-map1.x);
        document.getElementById('momy').innerHTML=my-map1.y;
        if(start==0){
            evlisten();
            ctx.clearRect(0,0,W,H);

            ctx.drawImage(img_bg,0,0,W,H);

            ctx.drawImage(obj,-30,0,180,200);


            begin.draw();

            if(starF==1){
                begin.y-=10;


            }
        }else{
            evlisten();
            draw();
        }
    }
    setInterval(drawMenu,16);
}

var draw=function(){
    ctx.clearRect(0,0,W,H);
    map1.draw();
    mario.draw();
}


/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
