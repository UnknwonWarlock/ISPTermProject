var x, y, fir, sec, cSettings = [], pics, workingCTX, curPage = 0, rCenter, lCenter;
function set( width, height, canv )
{
    x = width;
    y = height;
    document.getElementById(canv).width = width;
    document.getElementById(canv).height = height;
}

function setDisplay( canv, width, height, settings, picArray ){
    var canvas = document.getElementById(canv);
    workingCTX = canvas.getContext("2d");
    canvas.width = width;
    canvas.height = height;
    x = width;
    y = height;
    fir = (y - y * .95)/2;
    sec = ( 2 * fir ) + ( fir / 2 );
    lCenter = x/4 + fir;
    rCenter = x/2 + x/4 - fir; 
    cSettings = settings;
    pics = picArray;
}

function handleArrows( key ){
    var change = false;
    switch( key ){
        case "left":
            if( curPage != 0 ){
                --curPage
                change = true;
                // alert( "left");
            }
            break;
        case "right":
            if( 2 * curPage < pics.length ){
                ++curPage;
                change = true;
                // alert("right");
            }
    }

    if( change === true ){
        makePage( curPage );
    }
}

function makePage( page ){
    var pageWidth = x/2 - 2 * sec;
    workingCTX.textAlign = "center";
    if( page == 0 ){ // Title Page    
        var t = new Option().style.color = cSettings.text;
        workingCTX.fillStyle = t;
        createPage( 0 );
        workingCTX.font = "60px Arial";
        writeText( workingCTX, y/4, rCenter, cSettings.scrap, pageWidth, 60 );
        workingCTX.font = "30px Arial";
        writeText( workingCTX, y - y/4, rCenter, cSettings.user, pageWidth, 30 );
    }
    else if( pics.length == 2 * page - 1 ){ // Left Page only
        createPage( 2 );
        loadRest( pics[ page * 2  - 2], 0, pageWidth );
    }
    else{ // Both Pages
        createPage( 1 );
        loadRest( pics[ page * 2 - 2], pics[ page * 2 - 1], pageWidth );
    }
}

function loadRest( left, right, pageWidth ){
    if( right != 0 ){
        var imgR = new Image();
        imgR.onload = function(){ 
            workingCTX.drawImage( this, rCenter - x/6, y/5, x/3, y/2 );
        }
        imgR.src = right.path;
    }

    var imgL = new Image();
    imgL.onload = function(){
        workingCTX.drawImage( this, lCenter - x/6, y/5, x/3, y/2 );
    }
    imgL.src = left.path;

    var t = new Option().style.color = cSettings.text;
    workingCTX.fillStyle = t;
    workingCTX.font = "30px Arial";
    if( right !=  0 ){
        writeText( workingCTX, y/8, rCenter, right.title, pageWidth, 30 );
    }
    writeText( workingCTX, y/8, lCenter, left.title, pageWidth, 30 );

    workingCTX.font = "20px Arial";
    if( right != 0 ){
        writeText( workingCTX, y - y/4, rCenter, right.cap, pageWidth, 20 );
    }
    writeText( workingCTX, y - y/4, lCenter, left.cap, pageWidth, 20 ); 

}
function createPage( pageNum ){
    var c = new Option().style.color = cSettings.cover;
    var p = new Option().style.color = cSettings.paper;
    var r = new Option().style.color = cSettings.rings;
    workingCTX.strokeStyle = "rgba(1, 1, 1, 0)";
    workingCTX.fillStyle = c;

    // draws the initial cover of the book
    workingCTX.fillRect( fir, fir, x - ( 2 * fir ), y - ( 2 * fir ) );
    workingCTX.beginPath();
    workingCTX.ellipse( x/2, fir, (x/2)*.1, fir, 0, Math.PI, 2 * Math.PI );
    workingCTX.ellipse( x/2, y - fir, (x/2)*.1, fir, 0, 0, Math.PI );
    workingCTX.stroke();
    workingCTX.fill();

    // Draws the interior circle/shadow that's under the pages.
    workingCTX.fillStyle = c; //
    workingCTX.beginPath();
    workingCTX.arc( x/2, sec, fir, 0, 2 * Math.PI );
    workingCTX.arc( x/2, y - fir - fir, fir, 0, 2 * Math.PI );
    workingCTX.stroke();
    workingCTX.fill();
    // draws the pages
    workingCTX.fillStyle = p;
    switch( pageNum ){
        case 0:
            // right page only
            workingCTX.fillRect( x/2, sec, ( x/2 ) - sec , y - 2 *(sec) );
            break;
        case 2:
            // left page only
            workingCTX.fillRect( sec, sec, x/2 - sec, y - 2 *(sec) );
            break;
        default:
            // both pages
            workingCTX.fillRect( sec, sec, x - 2 *(sec), y - 2 *(sec) );
    }

    // draws the shadow/gap between the pages
    workingCTX.fillStyle = c;
    workingCTX.fillRect( x/2 - ( fir )/2, sec - 1, fir, y - 2 *(sec) + 2 );

    
    workingCTX.fillStyle = r;
    var initVal = sec + fir;
    var left = x / 2 - fir;
    var right = x / 2 + fir;
    var height = y / 60;
    var width = 2 * fir;
    var limit = y - initVal;
    var incrementVal = 2 * height;
    for( var i = initVal; i < limit; i += incrementVal )
    {
        workingCTX.beginPath();
        workingCTX.arc( left, i + height/2, height/2, 0, 2 * Math.PI );
        workingCTX.arc( right, i + height/2, height/2, 0, 2 * Math.PI );
        workingCTX.stroke();
        workingCTX.fillRect( left, i, width, height );
        workingCTX.fill();
    }
}

function create( canv, cover, paper, rings, text ){
    var canvas = document.getElementById(canv);
    var ctx = canvas.getContext("2d");

    var c = new Option().style.color;
    c = document.getElementById(cover).value;
    var p = new Option().style.color;
    p = document.getElementById(paper).value;
    var r = new Option().style.color;
    r = document.getElementById(rings).value;
    var t = new Option().style.color;
    t = document.getElementById(text).value;

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
    //ctx.fillRect( secWidth, secWidth, x - 2 *(secWidth), y - 2 *(secWidth) );
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

    ctx.font = "30px Arial";
    ctx.fillStyle = t;
    ctx.textAlign = "center";
    var leftCenter = x/4 + startWidth;
    var rightCenter = x/2 + x/4 - startWidth;
    var pageWidth = x/2 - 2 * secWidth;
    // max title new lines = 2; height = y/8; txt = 30px
    // max caption new lines = 7; height = y - y/4; txt = 20px
    // var test = "llow, this is a ihasdnio a9j0sd asiojdasio jioasdjio oji asdji jiojgod sfhio sad ioasf hioeafo nfoidstest of characters nieeasdj jasd asjdas  jasdn asjd asdj asjd asdk jasd jasd m0pf jasdop asjopd joaspd jaopsd joasd jopsad jopasd jopasjd asjassaasdjasjasdjas jasdk asjd kasdj asdsaj kasdjasdk adk sadk asj kj ald jjassdj  j ajdjj jasdk kkasdj asdj asjda s, asdjs djw dj aj asdja dsajd sajkd asdkjsa djf sakdsa fjs dsakjfsa djasd asj as d jsadsandjsad as  adas lease ignore thsi tecxt mmmmmmmmm, yes"
    writeText( ctx, y/8, leftCenter, "Hello, I am your ScrapBook!", pageWidth, 30 );
    // loadImg( ctx, "canvas.png", leftCenter );
}

function parse( ctx, words, pageWidth, type){
    var lines = [];
    var sentence = "";
    for( var i = 0; i < words.length; ){
        var curWord = "";
        for(; words.charAt(i) == ' ' && i < words.length; ++i );
        for(; words.charAt(i) != ' ' && i < words.length; ++i )
            curWord += words.charAt(i);
        if( ctx.measureText( sentence + " " + curWord ).width < pageWidth ){
            if( sentence.length == 0 )
                sentence += curWord;
            else
                sentence += " " + curWord;
        }
        else{
            lines.push( sentence );
            sentence = curWord;
        }
    }
    lines.push( sentence );
    switch( type ){
        case "test":
            return lines.length;
        default:
            return lines;
    }
}

function testWords( canv, words, type){
    var canvas = document.getElementById(canv);
    var ctx = canvas.getContext("2d");
    var input = document.getElementById( words ).value;
    var limit;
    switch( type ){
        case "title":
            limit = 2;
            ctx.font = "30px Arial";
            break;
        case "cap":
            limit = 6;
            ctx.font = "20px Arial";
            break;            
    }
    if( parse( ctx, input, 612.5, "test") > limit ){
        return false;
    }
    return true;
    
}

function writeText( ctx, startH, side, words, pageWidth, height ){
    var lines = parse( ctx, words, pageWidth, "" );
    for( var i = 0; i < lines.length; ++i, startH += height ){
        ctx.fillText( lines[i], side, startH );
    }
}

function loadImg( ctx, pic, side ){
    const img = new Image();
    img.onload = function() {
        ctx.drawImage( img, side - x/6, y/5, x/3, y/2 );
    }
    img.src = pic;
}

function validateC(toValid, canv, cover, paper, rings, text){
    var s = new Option().style;
    s.color = document.getElementById(toValid).value;
    if( !( s.color == document.getElementById(toValid).value.toLowerCase() ) || document.getElementById(toValid).value === ""  )
    {
        document.getElementById(toValid).style = "border: 1px solid red;";
    }
    else{
        document.getElementById(toValid).style = "border: 1px solid black";
        create( canv, cover, paper, rings, text );
    }
}

/*
Cover       page            rings           text

aquamarine  floralwhite     cadetblue       navy
lightcoral  linen           saddlebrown     black
teal        cornskilk       goldenrod       indianred
pink        lightyellow     black           navy


*/