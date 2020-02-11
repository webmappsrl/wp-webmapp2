<?php
$csvs = glob('./*.csv');
$keysNames = array();
$oldTo3Mapping = array();
foreach ( $csvs as $csv )
{
    $fileName = basename( $csv );
    preg_match('@DATAMODEL\s\-\s(.+)\.csv$@', $fileName, $matches);
    if ( isset( $matches[1] ) )
    {
        $postType = strtolower($matches[1]);
        $oldTo3Mapping[$postType] = [];
        
        if (($handle = fopen($csv, "r")) !== FALSE) 
        {
            $header = array_map('strtolower',fgetcsv($handle, 0 , ';'));
            while ($row = fgetcsv($handle, 0 , ';')) {
                
                $temp = array_combine($header, $row);
                if ( ! isset( $temp['name'] ) || ! $temp['name'] )
                {
                    echo "ERROR: missing the name of this field, it will not be registered.";
                    var_dump( $temp );
                    continue;
                }
                    
                $key = isset( $temp['key'] ) && $temp['key'] ? $temp['key'] : 'wm_' . $postType . '_' . $temp['name'];
                $keysNames[ $key ] = $temp['name'];
                $oldTo3Mapping[$postType][] = 
                [
                    'key' => [ 1 => '' , 2 => '' , 3 => $key ],
                    'name' => [ 1 => '', 2 => '' , 3 => $temp['name'] ]
                ];
            }
            
        }

       
        

    }
}

//rewrite
$myfile = fopen("webmapp3-fields.json", "w") or die("Unable to open file!");
$txt = json_encode($keysNames);
fwrite($myfile, $txt);
fclose($myfile);
echo "SUCCESS: Updated webmapp3-fields.json\n";

//merge

function versioningMerge( $moreImportant, $lessImportant )
{
    $temp = $moreImportant;
    
        foreach ( $moreImportant as $el )
        {
            /** 
                * Every element is an array with 2 keys : name, key
            */
            $found = false;//found the key
            $i = 0; 
            while ( ! $found && $i < count($lessImportant) )
            {
                if ( $el['key'][3] == $lessImportant[$i]['key'][3] )
                {
                    $t = array_filter($lessImportant[$i]);//less important element
                    $temp[$i] = array_merge( $el , $lessImportant[$i] );
                    $found = true;
                }
                $i++;
            }
        }
    return $temp;
}

foreach ( $oldTo3Mapping  as $post_type => $arr )
{
    $filePath = "webmappFieldsVersioning_$post_type.json";
    $myfile = fopen( $filePath , "w" ) or die("Unable to open file!");
    $mergeJson = json_encode( $arr );
    fwrite($myfile, $mergeJson);
    fclose($myfile);
    echo "SUCCESS: Updated $filePath\n";
}









