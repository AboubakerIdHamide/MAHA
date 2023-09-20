$(function(){
    $(".ps--active-y").animate({ scrollTop: 999999999 }, 'slow');

    $("#message-reply").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: `${URLROOT}/api/messages`, 
            type: 'POST',
            data: $(this).serialize(),
            success: function({data, messages}) {
                $('#messages').append(`
                    <li class="message d-inline-flex me">
                        <div class="message__body card">
                            <div class="card-body px-2 py-1">
                            <span>${data.message}</span>
                                <div class="text-right">
                                    <small class="text-muted" style="font-size: 10px;">${data.sent_at}</small>
                                </div>
                            </div>
                        </div>
                    </li>
                `);

                $('[name="message"]').val('');
                $(".ps--active-y").animate({ scrollTop: 999999999 }, 'slow');
            },
            error: function({responseJSON: {messages}}) {
                console.log(messages)
                // alert(messages);
            },
        });
    });

    $('#filter-etudiant').keyup(function(e){
        const input = e.target.value;
        if(!input) $(".etudiant").show();
        else $(`.etudiant:not([title*="${input}" i])`).hide();
    });
});