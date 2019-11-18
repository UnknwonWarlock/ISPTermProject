function test( x, y, cover, paper, rings){
    var canvas = document.getElementById("test");
    canvas.width = x;
    canvas.height = y;
    var ctx = canvas.getContext("2d");

    // outline color, cover color
    ctx.strokeStyle = "rgba(1, 1, 1, 0)"; 
    ctx.fillStyle = cover;

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
    ctx.fillStyle = cover; //
    ctx.beginPath();
    ctx.arc( x/2, secWidth, startWidth, 0, 2 * Math.PI );
    ctx.arc( x/2, y - startWidth - startWidth, startWidth, 0, 2 * Math.PI );
    ctx.stroke();
    ctx.fill();
    // draws the pages
    ctx.fillStyle = paper;
    ctx.fillRect( secWidth, secWidth, x - 2 *(secWidth), y - 2 *(secWidth) );

    // draws the shadow/gap between the pages
    ctx.fillStyle = cover;
    ctx.fillRect( x/2 - ( startWidth )/2, secWidth - 1, startWidth, y - 2 *(secWidth) + 2 );

    ctx.fillStyle = rings;
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
}