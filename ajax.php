<?php

if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest')
{
    $separator = '/ -';
    $length = 4;
    $endNum = false;
    $capitalize = false;

    cleanGlobals($_POST);
    validateOptions();

    try
    {
        $file = file_get_contents( 'wordlist.txt' );
        if ($file)
        {
            $wordlist = explode( "\n", $file );
            $password = '';

            for ($i=0; $i < $length; $i++)
            {
                $rand = rand( 0, sizeof( $wordlist ) - 1 );
                // Capitalize words
                if ($capitalize)
                {
                    $password .= trim( ucfirst( $wordlist[$rand] ) );
                }
                else
                {
                    $password .= trim( $wordlist[$rand] );
                }

                // Add separator when not the last word
                if ($i != $length - 1 && !empty( $separator ) )
                {
                    $password .= $separator[rand( 0, strlen( $separator ) - 1 )];
                }
                // Add number to the end of the password
                else if ($endNum)
                {
                    $password .= rand( 0,9 );
                }
            }
        }
        else
        {
            echo json_encode( array('result' => 'error') );
        }
        echo json_encode( array('result' => 'success', 'password' => $password ) );
    }
    catch (Exception $e)
    {
        echo json_encode( array('result' => 'error') );
    }
}

function validateOptions()
{
    global $separator, $length, $endNum, $capitalize;

    $separator = isset( $_POST['separator'] ) ? $_POST['separator'] : '';
    $length = isset( $_POST['length'] ) ? intval( $_POST['length'] ) : 4;
    if ($length > 10)
    {
        $length = 10;
    }
    $endNum = isset( $_POST['endNum'] ) ? true : false;
    $capitalize = isset( $_POST['capitalize'] ) ? true : false;
}

function cleanGlobals( &$data )
{
    foreach ( $data as $k => $v )
    {
        if (is_array( $v ))
        {
            cleanGlobals( $v );
        }
        
        // Strip out null characters
        $v = str_replace( chr( '0' ), '', $v );
        $v = str_replace( "\0", '', $v );
        $v = str_replace( "\x00", '', $v );
        $v = str_replace( '%00', '', $v );
        
        // No directory changes allowed
        $v = str_replace( "../", "&#46;&#46;/", $v );
        
        $data[$k] = $v;
    }
}