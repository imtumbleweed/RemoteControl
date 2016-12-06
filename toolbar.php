<style>
    #Tools { box-shadow: 0 0 40px #222; background: #535353 url('toolboxbody.png') repeat-y; width: 72px; height: 200px; position: absolute; top: 80px; left: calc(50% + 200px); }
    #ToolsHeader { position: relative; width: 72px; height: 22px; background: #535353 url('toolbox-top.png') no-repeat; }
    .ToolIcon { width: 33px; height: 26px; background: url("ic-empty.png") no-repeat; display: inline-block; margin:0; }
    .Toolpad { margin-left: 3px; }
    .ToolIC1 { background: url("") no-repeat; }
    .ToolIC-Empty { background: url("ic-empty.png") no-repeat; }
    .ToolIcon:hover { background: url("ic-empty.png") no-repeat; cursor: pointer; }
    .ToolIcon.Selected { background: url("ic-selected.png") no-repeat; }
    .CameraIcon { background: transparent url('camera.png') repeat-y; width: 24px; height: 24px; position: absolute; top: 70px; left: calc(50% - 350px); }
    #SecondaryToolbar { box-shadow: 0 0 40px #222;  background: #535353 url('SecondaryToolbar.png'); width: 100px; height: 50px; position: absolute; top: 32px; left: calc(50% + 140px); }
    .STPlaceholder { position: relative; margin; 2px; display: inline-block; width: 33px; height; 26px; background: url("SecondaryToolbarSelected.png") no-repeat; }
    .STPlaceholder img { pointer-events: none; }
    .STAdjuster { position: absolute; top: 16px; left: 18px; }
    #SidePanel { position: absolute; top: 32px; right: 32px; width: 226px; height: 250px; background: url("sidepanelbg.png") repeat-y; }
    #Minimap { position: relative; margin: auto; width: 200px; height: 200px; background: black; }
    #MinimapView { position: absolute; top: 0; left: 0; width: 50px; height: 50px; border: 1px solid #444; }
    #ContextMenu { display: none; position: absolute; top: 0; left: 0; width: 150px; cursor:default;}
    .ContextItem { background: #333; font-family: Arial; font-size: 11px; color: goldenrod; padding: 2px; }
    .ContextItem:hover { background: #777; color: black; }
    .ContextItem img { vertical-align: middle; }
    .ContextItem {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Chrome/Safari/Opera */
        -khtml-user-select: none; /* Konqueror */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                                  not supported by any browser */
    }
</style>
<script>$(document).ready(function() {
        //
        document.getElementsByTagName('img').ondragstart = function() { return false; };
        // Animate toolbar to its last position
        if (localStorage) {
            var x = parseInt(localStorage.getItem("toolbarx"));
            var y = parseInt(localStorage.getItem("toolbary"));
            console.log(x);  
            console.log(y);
            $("#Tools").css({"left":x+"px","top":y+"px"});
        }
        // Set tool controls
        $("#Tool1").on("click", function(){ toolbox.currentToolID = toolbox.SELECTION_TOOL; console.log("Selected Selection Tool.");});
        $("#Tool2").on("click", function(){ toolbox.currentToolID = toolbox.MOVE_WORLD; console.log("Selected Move World.");});
        $("#Tool3").on("click", function(){ toolbox.currentToolID = toolbox.BOX_TOOL; console.log("Selected Box Tool.");});
        $("#Tool4").on("click", function(){ toolbox.currentToolID = toolbox.CIRCLE_TOOL; console.log("Selected Circle Tool.");});
        $("#Tool5").on("click", function(){ toolbox.currentToolID = toolbox.ERASER_TOOL; console.log("Selected Eraser Tool.");});
        $("#Tool6").on("click", function(){ toolbox.currentToolID = toolbox.SOME_TOOL; console.log("Selected Some Tool.");});
        $("#Tool7").on("click", function(){ toolbox.currentToolID = toolbox.RAINMAKER; console.log("Selected Rain Maker Tool.");});
        $("#Tool8").on("click", function(){ toolbox.currentToolID = toolbox.CELESTIAL; console.log("Celestial Body Tool."); Celestial.place($(window).width()/2, $(window).height()/2 + 500); });

        // Attach events to context menu
        $("#Context1").on("click", function(){ toolbox.action(ACTION_MAKE_LEFT_SLOPE); });
        $("#Context2").on("click", function(){ toolbox.action(ACTION_MAKE_RIGHT_SLOPE); });
        $("#Context3").on("click", function(){ toolbox.action(ACTION_MAKE_COLLECTIBLE); });

        // Draggable mini map
        $( "#MinimapView" ).draggable({
            containment: '#Minimap',
            drag: function(event) {
                var top = $(this).position().top;
                var left = $(this).position().left;
            }
        });

        $("#Tool2,#Tool3,#Tool4,#Tool5,#Tool6,#Tool7").on("click", function(){MakeRainsSelectable(false);})
        $("#Tool1").on("click", function(){MakeRainsSelectable(true);})

        // Make clickable tool icons
        $('.ToolIcon').on("click", function() {
            $(".ToolIcon").removeClass("Selected");
            $(this).addClass("Selected");
        })});</script>
<div id = "Tools">
    <div id = "ToolsHeader"></div>
    <div style = "height: 6px;"></div>
    <div id = "Tool1" class = "ToolIcon Toolpad Selected"><img src = "ic1a.png" alt = "Select Objects"/></div><div id = "Tool2" class = "ToolIcon"><img src = "ic2a.png" alt = "Move World"/></div>
    <div id = "Tool3" class = "ToolIcon Toolpad ToolIC-Empty"><img src = "boxtool.png" alt = "Box Tool"/></div><div id = "Tool4" class = "ToolIcon ToolIC-Empty"><img src = "circletool.png" alt = "Circle Tool"/></div>
    <div id = "Tool5" class = "ToolIcon Toolpad ToolIC-Empty"><img src = "erasertool.png" alt = "Box Tool"/></div><div id = "Tool6" class = "ToolIcon ToolIC-Empty"></div>
    <div id = "Tool7" class = "ToolIcon Toolpad ToolIC-Empty"><img src = "rainmaker.png" alt = "Box Tool"/></div><div id = "Tool8" class = "ToolIcon ToolIC-Empty"><img src = "celestialicon.png" alt = "Celestial Tool"/></div>
</div>
<div id = "SecondaryToolbar">
    <div class = "STAdjuster">
        <div class = "STPlaceholder" onclick = "Player.spawn(Mouse.x, Mouse.y)">
            <img src = "playericon.png" alt = "" />
        </div>
        <div class = "STPlaceholder">
            <img src = "controllericon.png" alt = ""/>
        </div>
    </div>
</div>
<div id = "SidePanel">
    <img src = "sidepanelheader.png" alt = ""/>
    <div id = "Minimap">
        <div id = "MinimapView"></div>
    </div>
</div>
<div class = "CameraIcon"></div>
<div id = "ContextMenu">
    <div id = "Context1" class = "ContextItem" action = "Convert to Left Slope"><img src = "leftslope.png" alt = "Left slope"/> Left Slope</div>
    <div id = "Context2" class = "ContextItem" action = "Convert to Right Slope"><img src = "rightslope.png" alt = "Right slope"/> Right Slope</div>
    <div id = "Context3" class = "ContextItem" action = "Convert to Collectible"><img src = "collectible.png" alt = "Right slope"/> Collectible</div>
</div>