<?php
//create a long path if it does not exist, returns true if exists or finished creating
if( ! function_exists( 'createPath' ) ) {
	function createPath( $path, $startPath = NULL, $string = "<?php header('Location: /');\n" ) {
		createPathFolders( $path );

		if( ! $startPath )
			return true;

		$startPath = rtrim( $startPath, "/" );
		$objects = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $startPath ), RecursiveIteratorIterator::SELF_FIRST );

		foreach( $objects as $name => $object ) {
			if( is_dir( $object->getPathname() ) && strpos( $object->getPathname(), '.svn' ) === FALSE && strpos( $object->getPathname(), '..' ) === FALSE )
				$dirs[] = $object->getPathname();
		}

		$length = strlen( $string );
	}
}


//Create the folders - only call in createPath()
if( ! function_exists( 'createPathFolders' ) ) {
	function createPathFolders( $path ) {
		$path = rtrim( $path, "/" );
		if( ! $path )
			return false;

		if( is_dir( $path ) )
			return true;

		$lastPath = substr( $path, 0, strrpos( $path, '/', -2 ) + 1 );
		$r = createPath( $lastPath );
		return ( $r && is_writable( $lastPath ) ) ? mkdir( $path, 0755, true ) : false;
	}
}
