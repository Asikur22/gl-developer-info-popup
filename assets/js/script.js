function glPopUp() {
	if ( Cookies.get( 'gl-developer-info' ) !== 'closed' ) {
		document.getElementById( 'gl-developer-info' ).classList.add( 'gl-show' );
		document.getElementById( 'gl-developer-info-open' ).classList.add( 'gl-hide' );
	}
	
	document.addEventListener( 'click', function ( event ) {
		if ( event.target.id == 'gl-developer-info-close' ) {
			event.preventDefault();
			event.stopPropagation();
			
			document.querySelector( '.gl-developer-info-inner' ).style.width = document.querySelector( '.gl-developer-info-inner' ).offsetHeight + 'px';
			document.getElementById( 'gl-developer-info' ).classList.add( 'gl-developer-info-pre-minimize' );
			
			setTimeout( function () {
				document.getElementById( 'gl-developer-info' ).classList.remove( 'gl-developer-info-open' );
				document.getElementById( 'gl-developer-info' ).classList.add( 'gl-developer-info-minimize' );
				
				setTimeout( function () {
					document.getElementById( 'gl-developer-info-open' ).classList.remove( 'gl-hide' );
					document.getElementById( 'gl-developer-info' ).classList.remove( 'gl-show' );
					document.getElementById( 'gl-developer-info' ).classList.remove( 'gl-developer-info-pre-minimize' );
				}, 400 );
			}, 300 );
			
			Cookies.set( 'gl-developer-info', 'closed', {expires: 30} );
		}
		
		if ( event.target.id == 'gl-developer-info-open' ) {
			event.preventDefault();
			event.stopPropagation();
			
			document.getElementById( 'gl-developer-info' ).classList.remove( 'gl-developer-info-minimize' );
			document.getElementById( 'gl-developer-info' ).classList.add( 'gl-show' );
			document.querySelector( '.gl-developer-info-inner' ).style.width = null;
			document.getElementById( 'gl-developer-info-open' ).classList.add( 'gl-hide' );
		}
	} );
}

document.body.onload = glPopUp;
