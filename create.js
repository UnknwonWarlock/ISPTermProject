var x, y;
function set( width, height )
{
    x = width;
    y = height;
    document.getElementById("test").width = width;
    document.getElementById("test").height = height;
}

function create(){
    var canvas = document.getElementById("test");
    var ctx = canvas.getContext("2d");

    var c = new Option().style.color;
    c = document.getElementById("cover").value;
    var p = new Option().style.color;
    p = document.getElementById("paper").value;
    var r = new Option().style.color;
    r = document.getElementById("rings").value;
    var t = new Option().style.color;
    t = document.getElementById("textColor").value;

    // outline color, cover color
    ctx.strokeStyle = "rgba(1, 1, 1, 0)"; 
    ctx.fillStyle = c;

    // draws the initial cover of the book
    var startWidth = (y - y * .95)/2;
    var secWidth = ( 2 * startWidth ) + ( startWidth / 2 );
    ctx.fillRect( startWidth, startWidth, x - ( 2 * startWidth ), y - ( 2 * startWidth ) );
    ctx.beginPath();
    ctx.ellipse( x/2, startWidth, (x/2)*.1, startWidth, 0, Math.PI, 2 * Math.PI );
    ctx.ellipse( x/2, y - startWidth, (x/2)*.1, startWidth, 0, 0, Math.PI );
    ctx.stroke();
    ctx.fill();

    // Draws the interior circle/shadow that's under the pages.
    ctx.fillStyle = c; //
    ctx.beginPath();
    ctx.arc( x/2, secWidth, startWidth, 0, 2 * Math.PI );
    ctx.arc( x/2, y - startWidth - startWidth, startWidth, 0, 2 * Math.PI );
    ctx.stroke();
    ctx.fill();
    // draws the pages
    ctx.fillStyle = p;
    // Both Pages
    // ctx.fillRect( secWidth, secWidth, x - 2 *(secWidth), y - 2 *(secWidth) );
    // Right page only
    ctx.fillRect( x/2, secWidth, ( x/2 ) - secWidth , y - 2 *(secWidth) );
    // Left page only
    // ctx.fillRect( secWidth, secWidth, x/2 - secWidth, y - 2 *(secWidth) );


    // draws the shadow/gap between the pages
    ctx.fillStyle = c;
    ctx.fillRect( x/2 - ( startWidth )/2, secWidth - 1, startWidth, y - 2 *(secWidth) + 2 );

    
    ctx.fillStyle = r;
    var initVal = secWidth + startWidth;
    var left = x / 2 - startWidth;
    var right = x / 2 + startWidth;
    var height = y / 60;
    var width = 2 * startWidth;
    var limit = y - initVal;
    var incrementVal = 2 * height;
    for( var i = initVal; i < limit; i += incrementVal )
    {
        ctx.beginPath();
        ctx.arc( left, i + height/2, height/2, 0, 2 * Math.PI );
        ctx.arc( right, i + height/2, height/2, 0, 2 * Math.PI );
        ctx.stroke();
        ctx.fillRect( left, i, width, height );
        ctx.fill();
    }

    ctx.font = "20px Arial";
    ctx.fillStyle = t;
    ctx.textAlign = "center";
    ctx.fillText( "My First Scrap Book!", x/2 + x/4 - startWidth, y/6 );
    const img = new Image( x/3, y/2 );
    img.onload = loadImg;
    img.src = "blep.jpg";
}

function validateC(toValid){
    var s = new Option().style;
    s.color = document.getElementById(toValid).value;
    if( !( s.color == document.getElementById(toValid).value.toLowerCase() ) || document.getElementById(toValid).value === ""  )
        document.getElementById(toValid).style = "border: 1px solid red;";
    else{
        document.getElementById(toValid).style = "border: 1px solid black";
        create();
    }
}

function loadImg(){
    var canvas = document.getElementById("test");
    var ctx = canvas.getContext('2d');

    ctx.drawImage( this, x/2 + x/12, y/4, this.width, this.height );
}

/*
Cover       page            rings           text

aquamarine  floralwhite     cadetblue       navy
lightcoral  linen           saddlebrown     black
teal        cornskilk       goldenrod       indianred
pink        lightyellow     black           navy


*/