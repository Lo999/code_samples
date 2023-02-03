<?php

    /*
     * To use this logger, include this file at the top:
        * include_once("/my/location/sconsole2.php")
     * Then, just log like this:
        * slog('my text here');
     * You can log a string or a full variable
        * slog($my_variable);
     * To clear the log, use:
        * slog_wipe();
     * To print the entire backtrace at a given breakpoint, use:
        * slog_everything();
    */

    $directory = '/my/debug/directory/';

    /**
     * @param string $input_string_or_variable //the string or variable to slog
     * @param string $destination //the file we're slogging to
     * @param int $backtrace_level //level in nested backtrace to specify in the timestamp (i.e.
     */
    function slog($input_string_or_variable='breakpoint',
                  $destination="/my/debug/directory/error_slog.txt",
                  $backtrace_level=0,
                  $comment='')
    {
        //open the slog file
        $destination = fopen($destination, "a");

        //add the directory/timestamp of the log
        fwrite($destination, "\n" . time_stamp(debug_backtrace()[$backtrace_level]));

        //add the input
        if (is_string($input_string_or_variable))
        {
            fwrite($destination, $input_string_or_variable);
        }
        else
        {
            //convert the variable into a string using var_dump and ob streams
            if($comment!='') fwrite($destination, $comment . "\n");
            ob_start();
            var_dump($input_string_or_variable);
            $variable_as_string = ob_get_contents();
            ob_end_clean();
            fwrite($destination, $variable_as_string);
        }

        //close the file
        fclose($destination);
    }

    /**
     * A function to log the full backtrace at a given breakpoint
     * @param string $destination //the full filepath of the slog you want to clear
     */
    function slog_everything($destination="/my/debug/directory/error_slog.txt") {

        //open the correct slog file
        $destination = fopen($destination, "a");

        //get the backtrace
        $everything = debug_backtrace();

        //add the directory/timestamp of the log
        fwrite($destination, "\n\n------------------------------------------------------------------------------\n");
        fwrite($destination, "FULL BACKTRACE:" . time_stamp($everything[0], false) . "\n\n");

        for($i=0; $i<count($everything); $i++) {
            $stack = "*Level " . $i . "*\n";
            foreach($everything[$i] as $name => $value) {
                $stack .= $name . ": ";
                if(!is_string($value) and !is_int($value))
                {
                    $stack .= "\n";
                    ob_start();
                    var_dump($value);
                    $stack .= ob_get_contents();
                    ob_end_clean();
                }
                else
                {
                    $stack .= $value;
                }
                $stack .= "\n";
            }
            $stack .= "\n";
            fwrite($destination, $stack);
        }

        fwrite($destination, "------------------------------------------------------------------------------\n");

        fclose($destination);
    }

    /**
     * Clears the contents of a slog file. You can put
     * this at the top of a document that you're testing
     * so you don't have to continually erase and reupload
     * the file every time you rerun the script.
     * @param string $destination //the full filepath of the slog you want to clear
     */
    function slog_wipe($destination="/my/debug/directory/error_slog.txt")
    {
        fclose(fopen($destination, "w"));
    }

    /**
     * Creates a time stamp, including the file, line number, date, and time of the slogging
     * @param string $callback_info //the entire backtrace
     * @param string $include_file_and_line //a boolean indicating whether or not to add file & line to the timestamp
     */
    function time_stamp($callback_info, $include_file_and_line=true)
    {
        $time_stamp = "";
        if($include_file_and_line) $time_stamp = "\n[" . $callback_info['file'] . "]";
        $time_stamp .= "\n[" . date("l") . ", " . date("Y/m/d") . ", " . date("h:i:sa") . "]";
        if($include_file_and_line) $time_stamp .= "\n[" . $callback_info['line'] . "]: ";
        return $time_stamp;
    }
