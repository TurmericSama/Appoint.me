var req = require( "request" )
var sent = []

setInterval( function() {	
	req( "http://localhost/fetch", ( err, res, body ) => {
		data = JSON.parse( body )
		data.forEach( cur => {
			req( "http://localhost/getsent", ( err, res, body ) => {
				sent = JSON.parse( body )
				if( sent.findIndex( x => x.uid == cur.user_id && x.aid == cur.appointment_id ) == -1 ) {
					console.log( "ENTERED TRUE" )					
					selfie = `Your event ${ cur.name }`
					others = `The event ${ cur.name } of ${ cur.fname + " " + cur.lname }`
					message = `${ cur.user_id == cur.creator? selfie: others } is now beginning`
					req.post( {
						url: "https://automation.8layertech.io/bot2.php",
						form: {
							labas: "oo",
							psid: cur.facebook_id,
							mensahe: message
						}
					}, ( err, res, body ) => {
						console.log( "INSIDE CALLBACK" )
						if( err ) console.log( err )
						else {
							req.post( {
								url: "http://localhost/fetchpost",
								form: {
									uid: cur.user_id,
									aid: cur.appointment_id
								}
							})
						}
					}).on( "error", err => {
						console.log( err )
						console.log( "INSIDE OPT" )
					})
				} else {
					console.log( "ENTERED FALSE" )
				}
			})			
		})
	})
}, 3000 )