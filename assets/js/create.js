var x, y;
function set( width, height, canv )
{
    x = width;
    y = height;
    document.getElementById(canv).width = width;
    document.getElementById(canv).height = height;
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
    ctx.fillRect( secWidth, secWidth, x - 2 *(secWidth), y - 2 *(secWidth) );
    // Right page only
    // ctx.fillRect( x/2, secWidth, ( x/2 ) - secWidth , y - 2 *(secWidth) );
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
    writeText( ctx, y/8, leftCenter, "Heljad asjdj asdj j jasjd jsadj jasdj jasdj asjd jasjd jasd jasdj asdj sadj asjd sajd sjad jasd jasdj asdj sj j djsajd sajd jsd jsad jsdk ksdjajd slo", pageWidth, 30 );
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
    return lines;
    // switch( type ){
    //     case "test":
    //         return lines.length;
    //     default:
    //         return lines;
    // }
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
    var lines = parse( ctx, input, 612.5, "test"); 
    if( lines.length > limit ){
        return false;
    }
    return true;
    
}

function writeText( ctx, startH, side, words, pageWidth, height ){
    var lines = parse( ctx, words, pageWidth, "" );
    window.alert( lines.length );
    for( var i = 0; i < lines.length; ++i, startH += height ){
        ctx.fillText( lines[i], side, startH );
    }
}

function loadImg( ctx, pic, side ){
    const img = new Image( x/3, y/2 );
    img.src = pic;
    img.onload = ctx.drawImage( img, side - x/6, y/5, x/3, y/2 );
}

function validateC(toValid, canv, cover, paper, rings, text){
    var s = new Option().style;
    s.color = document.getElementById(toValid).value;
    if( !( s.color == document.getElementById(toValid).value.toLowerCase() ) || document.getElementById(toValid).value === ""  )
        document.getElementById(toValid).style = "border: 1px solid red;";
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