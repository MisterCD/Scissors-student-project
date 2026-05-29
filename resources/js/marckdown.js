/**
 * 
 * @param {string} source
 * @returns {string}
 */
function parseMarkdown(source) {
    let output = source;

    
    output = output.replace(          /#name([\s\S]*?)#endname/g, '<h1>$1</h1>');
    output = output.replace(        /#title([\s\S]*?)#endtitle/g, '<p>$1</p>');
    output = output.replace(          /#text([\s\S]*?)#endtext/g, '<span>$1</span>');
    output = output.replace(    /#section([\s\S]*?)#endsection/g, '<div>$1</div>');
     
    output = output.replace(      /#slider([\s\S]*?)#endslider/g, '<slider-component>$1</slider-component>');
    output = output.replace(          /#grid([\s\S]*?)#endgrid/g, '<grid-component>$1</grid-component>');
    output = output.replace(  /#viewleft([\s\S]*?)#endviewleft/g, '<view-component type="left">$1</view-component>');
    output = output.replace(/#viewright([\s\S]*?)#endviewright/g, '<view-component type="right">$1</view-component>');

    output = output.replace(       /#image\s+(\S+)\s+#endimage/g, '<img src="$1">');

    return output;
}










