// Whenever someone clicks the thingy with the ID of purchase we run this code
$('#purchase').click(e => {
    sx.moneyRequest('https://'+window.location.host+'/webhooks/paymentcompleted.php', 'MyPaymentID', 10000)
})

// This function is executed when the money has been taken from the player.
// It is executed by the client though, so do not trust it. Use it for reloading a page or something. Never trust the client.
function sx_MoneyRequestAccept(){
    $('#purchase').text('Thx 4 moneyz')
}

// Whenever someone clicks the thingy with the ID of notification we run this code
$('#notification').click(e => {
    // Send post request to our api
    $.post('/api/sendnotification.php', {}, data => {
        data = JSON.parse(data)
        if(!data.success){
            $('#notification').text('Error: '+data.error)
            return
        }
        // Update button text
        $('#notification').text('Notification sent!')
    })
})

// When clicking on the thing with the id of expression, we open this expression
$('#expression').click(e => {
    sx.openExpression('@name cool e2\n@persist BlaBla')
})

// When clicking okay you get the point. We're bascically making the tablet not-closeable, when the checkbox isn't checked
$('#tabletcloseable').on('input', e => {
    sx.setCloseable($('#tabletcloseable').prop('checked'))
})

// Save the dupe (Will ask for confirmation)
$('#dupe').click(e => {
    sx.saveDupe('mydupe.txt', 'content')
})

$('#givemoney').click(e => {
    $.post('/api/givemoney.php', {}, data => {
        data = JSON.parse(data)
        if(!data.success){
            $('#givemoney').text('Error: '+data.error)
            return
        }
        $('#givemoney').text('Moneys sent!')
    })
})