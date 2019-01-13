var req = require( "request" )
var sent = []

setInterval( function() {
	req( "http://localhost/fetch", ( err, res, body ) => {
		data = JSON.parse( body )
		data.forEach( cur => {
			if( sent.findIndex( x => x.uid == cur.user_id && x.aid == cur.appointment_id ) == -1 ) {
				console.log( "ENTERED TRUE" )
				sent.push( { 
					uid: cur.user_id,
					aid: cur.appointment_id
				})
				selfie = `Your event ${ cur.name }`
				others = `The event ${ cur.name } of ${ cur.uname }`
				message = `${ cur.user_id == cur.creator? selfie: others } is now beginning`
				req.post( {
					url: "https://automation.8layertech.io/bot2.php",
					form: {
						labas: "oo",
						psid: cur.facebook_id,
						mensahe: message
					}
				})
			} else {
				console.log( "ENTERED FALSE" )
			}
		})
	})
}, 1000 )