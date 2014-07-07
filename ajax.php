<?php

if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest')
{
    $separator,
    $length,
    $endNum,
    $capitalize;

    cleanGlobals($_POST);
    validateOptions();

    try
    {
        $file = file_get_contents( 'wordlist.txt' );
        if ($file)
        {
            $wordlist = explode( '\n', $file );
            $password = '';
            for ($i=0; $i < $length; $i++)
            {
                $password += $wordlist[rand( 0, length( $wordlist ) )];

                if ($i != $length - 1)
                {
                    $password += $separator;
                }
                else if ($endNum)
                {
                    $password += $endNum;
                }
            }
        }

        echo json_decode('{result: "success", password:}');
    }
    catch (Exception $e)
    {
        echo json_decode('{result: "error"}');
    }
}

function validateOptions()
{
    global $separator, $length, $endNum, $capitalize;

    $separator = isset( $_POST['separator'] ) ? $_POST['separator'] : '';
    $length = isset( $_POST['length'] ) ? $_POST['length'] : 4;
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
        
        // No directory changes
        $v = str_replace( "../", "&#46;&#46;/", $v );
        
        $data[$k] = $v;
    }
}