let uses = 0;

// Copy token into clipboard, show notify "Copied to clipboard." then hide it after 5 sec.
function copy(selector) {
    $('.notify').css({"opacity": 1});
    var $temp = $("<div>");
    $("body").append($temp);
    $temp.attr("contenteditable", true)
       .html($(selector).html()).select()
       .on("focus", function() { document.execCommand('selectAll',false,null); })
       .focus();
    document.execCommand("copy");
    $temp.remove();
    
    // Hide "Copied to clipboard." notify
    setTimeout(
        function() {
            $('.notify').css({"opacity": 0});
        },
        5000
    );
}

$('#gen_token_btn').click(function() {
    $.ajax({
        url: '/lib/generate_token.php',
        type: 'POST',
        success: function(data) {
            if (uses == 0) {
                // Remove "GENERATE TOKEN" text
                $('#res').empty();
                $('#res').append(data);
                $('#gen_token_btn').removeAttr('id');
                
                // unhide copy button
                $('.copy-btn').css({"display": "block"});
                
                // Copy token to clipboard
                copy('#res');
                
                // Disable invoke this func again in that page
                uses += 1;
                
                // Hide "Copied to clipboard." notify
                setTimeout(
                    function() {
                        $('.notify').css({"opacity": 0});
                    },
                    5000
                );
            }
        }
    });
});