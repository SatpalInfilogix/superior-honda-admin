@isset($signature)
<script>
    // Canvas signature script
    $(function() {
        $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd' 
    });
    $('#datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd' 
    });
    $('#date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd' 
    });
        window.requestAnimFrame = (function(callback) {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimaitonFrame ||
                function(callback) {
                    window.setTimeout(callback, 1000 / 60);
                };
        })();

        var canvas = $("#sig-canvas")[0];
        var ctx = canvas.getContext("2d");
        ctx.strokeStyle = "#222222";
        ctx.lineWidth = 4;

        var drawing = false;
        var mousePos = {
            x: 0,
            y: 0
        };
        var lastPos = mousePos;

        $(canvas).on("mousedown", function(e) {
            drawing = true;
            lastPos = getMousePos(canvas, e);
        });

        $(canvas).on("mouseup", function(e) {
            drawing = false;
        });

        $(canvas).on("mousemove", function(e) {
            mousePos = getMousePos(canvas, e);
        });

        // Add touch event support for mobile
        $(canvas).on("touchstart", function(e) {
            e.preventDefault();
            mousePos = getTouchPos(canvas, e);
            var touch = e.touches[0];
            var me = new MouseEvent("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(me);
        });

        $(canvas).on("touchmove", function(e) {
            var touch = e.touches[0];
            var me = new MouseEvent("mousemove", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(me);
        });

        $(canvas).on("touchend", function(e) {
            var me = new MouseEvent("mouseup", {});
            canvas.dispatchEvent(me);
        });

        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            };
        }

        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }

        function renderCanvas() {
            if (drawing) {
                ctx.moveTo(lastPos.x, lastPos.y);
                ctx.lineTo(mousePos.x, mousePos.y);
                ctx.stroke();
                lastPos = mousePos;
            }
        }

        // Prevent scrolling when touching the canvas
        $(document.body).on("touchstart touchend touchmove", function(e) {
            if ($(e.target).is(canvas)) {
                e.preventDefault();
            }
        });

        (function drawLoop() {
            requestAnimFrame(drawLoop);
            renderCanvas();
        })();

        function clearCanvas() {
            canvas.width = canvas.width;
        }

        // Set up the UI
        var sigText = $("#sig-dataUrl")[0];
        var sigImage = $("#sig-image")[0];
        
        var clearBtn = $("#sig-clearBtn")[0];
        var submitBtn = $("#sig-submitBtn")[0];

        $(clearBtn).on("click", function(e) {
            clearCanvas();
            sigText.value = "Data URL for your signature will go here!";
            sigImage.setAttribute("src", "");
            $(sigImage).css("display", "none");
        });

        $(submitBtn).on("click", function(e) {
            var dataUrl = canvas.toDataURL();
            sigText.value = dataUrl;
            sigImage.setAttribute("src", dataUrl);
            $(sigImage).css("display", "block");
        });
    });
    </script>
@endisset
