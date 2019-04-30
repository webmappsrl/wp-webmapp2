<?php


class WebMapp_WpCli_Utils
{
    function __construct()
    {
        return $this;
    }

    function backup_db( $filename )
    {
        $command="wp db export $filename --allow-root";
        return $this->exec( $command );
    }

    function update_post( $id , $post_parent = '' )
    {
        if ( ! empty( $post_parent ) )
            $post_parent = "--post_parent=\"$post_parent\"";

        $command = "wp post update $id $post_parent --porcelain --allow-root";
        return $this->exec( $command );
    }


    /**
     * Exec shell command with web server process user
     * @param $command - string of command to execute
     * @return bool|string|null
     */
    private function exec( $command )
    {
        echo "EXEC COMMAND: $command\n";
        $response = shell_exec( $command );

        if ( ! isset( $response) )
            $response = FALSE;

        return $response;
    }
}