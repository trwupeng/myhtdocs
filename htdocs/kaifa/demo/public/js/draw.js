
$(function(){
    var canvas = $('.draw');
    canvas[0].width = $('body').width();
    canvas[0].height = $(window).height();

    var var_log = function(str1,str2){
        console.log( str2);
        console.log( str1);
    }

    var draw = {
        'initimg':'upload/welcome/bg.png',
        'bgimg':'upload/welcome/bg.png',
        'mx':0,
        'my':0,
        'ox':0,
        'oy':0,
        'lineArr':[],
        'keydown':0,
        'set':null,
        'cxt':null,
        'time':0,
        'color':'black',
        'init':function(){
            this.cxt = canvas[0].getContext("2d");
            this.mouse();
            this.run();
            /*
            setInterval(function(e){
                var image = canvas[0].toDataURL("image/png");//.replace("image/png", "image/octet-stream");
                //var_log(image);
                draw.sendImg(image);
            },5000);
            */
        },
        'sendImg':function(data){
            var url = '/getImg';
            draw.bgimg = draw.initimg+'?rand='+Math.floor(Math.random() * 9999);
            $.post(url,{data:data},function(e){
                var_log(e);
            });
        },
        'draw':function(){
            this.cxt.fillRect(0,0,1,1);
            var img = new Image();
            //img.src = draw.bgimg;
            //this.cxt.drawImage(img,0,0);
            if(this.keydown){
                if(this.time==0)this.setColor();
                this.line(this.mx,this.my,this.ox,this.oy,this.color);
            }
            this.ox = this.mx;
            this.oy = this.my;
        },
        'setColor':function(){
            this.color = "rgb("+this.rand(0,255)+","+this.rand(0,255)+","+this.rand(0,255)+")";
           // this.color = "black";
        },
        'timeGo':function(){
            this.time ++;
            if(this.time>60){
                this.time = 0;
            }
        },
        'rand':function(begin,end){
            return ( begin + Math.floor(Math.random() * (end - begin)) );
        },
        'line':function(x1,y1,x2,y2,color){
            this.cxt.beginPath();
            this.cxt.moveTo(x1,y1);
            this.cxt.lineTo(x2,y2);
            this.cxt.strokeStyle = color;
            this.cxt.lineWidth = 5;
            this.cxt.stroke();
            this.cxt.closePath();
        },
        'run':function(){
           // var_log(this.draw,'draw >>> ');
            this.set = setInterval(function(){ //Ö´ÐÐÑ­»·¶¯»­
                draw.timeGo();
                draw.draw();
            },17);
        },
        'mouse':function(){
            var_log(this.cxt ,'cxt >>> ');
            canvas.mousemove(function(e){
                draw.mx = e.offsetX;
                draw.my = e.offsetY;
                if(draw.keydown){
                    console.log( draw.mx , draw.my);
                }
            });
            canvas.mousedown(function(e){
                if(e.button == 0)draw.keydown = 1;
            });
            canvas.mouseup(function(e){
                if(e.button == 0)draw.keydown = 0;
            });
        }
    };
    draw.init();
});


var url = 'http://www.sumilicai.com/Api/member/exist';
var post =  function(){
    console.warn('run');
    var phone = 13+''+(100000000+Math.floor(Math.random()*999999999));
    $.post(url,{userName:phone},function(e){
        console.log(e);
        if(e.code == 1){
            alert(phone);
        }else{
            post();
        }
    });
}

//post();
