var ud, dd, ld, rd, sd,jd,kd, md = false;
var mx, my, mmx, mmy;
var evlisten = function () {
    document.addEventListener('keydown', function (e) {
        if (e.keyCode == 68) {
            rd = true;
        }
        else if (e.keyCode == 65) {
            ld = true;
        }
        else if (e.keyCode == 87) {
            ud = true;
        }
        else if (e.keyCode == 74) {
            jd = true;
        }
        else if (e.keyCode == 75) {
            kd = true;
        }
        else if (e.keyCode == 83) {
            dd = true;
        }
        else if (e.keyCode == 32) {
            sd = true;
        }
        else if (e.keyCode == 123) {
           // window.open('http://www.baidu.com');
        }
    }, false);
    document.addEventListener('keyup', function (e) {
        if (e.keyCode == 68) {
            rd = false;
        } else if (e.keyCode == 65) {
            ld = false;
        } else if (e.keyCode == 87) {
            ud = false;
        } else if (e.keyCode == 74) {
            jd = false;
        } else if (e.keyCode == 75) {
            kd = false;
        } else if (e.keyCode == 83) {
            dd = false;
        } else if (e.keyCode == 32) {
            sd = false;
        }
    }, false);
}
document.addEventListener('mousedown', function (e) {
    if (e.layerX || e.layerX == 0) {
        mx = e.layerX;
        my = e.layerY;
    } else if (e.offsetX || e.offsetX == 0) {
        mx = e.offsetX;
        my = e.offsetY;
    }
}, false);
document.addEventListener('mouseup', function (e) {
    if (e.layerX || e.layerX == 0) {
        mx = e.layerX;
        my = e.layerY;
    } else if (e.offsetX || e.offsetX == 0) {
        mx = e.offsetX;
        my = e.offsetY;
    }
}, false);
document.addEventListener('mousemove', function (e) {
    if (e.layerX || e.layerX == 0) {
        mmx = e.layerX;
        mmy = e.layerY;
    } else if (e.offsetX || e.offsetX == 0) {
        mmx = e.offsetX;
        mmy = e.offsetY;
    }
}, false);
var mouselisten = function (x, y, w, h) {
    var areax, areay;
    document.addEventListener('mousedown', function (e) {
        if (e.layerX || e.layerX == 0) {
            areax = e.layerX;
            areay = e.layerY;
        } else if (e.offsetX || e.offsetX == 0) {
            areax = e.offsetX;
            areay = e.offsetY;
        }
        if (areax > x && areay > y && areax < (x + w) && areay < (y + h)) {
            ismousedown = true;
        }
    }, false);
    document.addEventListener('mouseup', function (e) {
        if (e.layerX || e.layerX == 0) {
            areax = e.layerX;
            areay = e.layerY;
        } else if (e.offsetX || e.offsetX == 0) {
            areax = e.offsetX;
            areay = e.offsetY;
        }
        if (areax > x && areay > y && areax < (x + w) && areay < (y + h)) {
            ismousedown = false;
        }
    }, false);
    document.addEventListener('mousemove', function (e) {
        if (e.layerX || e.layerX == 0) {
            areax = e.layerX;
            areay = e.layerY;
        } else if (e.offsetX || e.offsetX == 0) {
            areax = e.offsetX;
            areay = e.offsetY;
        }
        if (areax > x && areay > y && areax < (x + w) && areay < (y + h)) {
            ismousein = true;
        } else {
            ismousein = false;
        }
    }, false);
}