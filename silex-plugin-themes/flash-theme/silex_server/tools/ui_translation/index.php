<?
/*
	this file is part of SILEX
	SILEX : RIA developement tool - see http://silex-ria.org/

	SILEX is (c) 2004-2007 Alexandre Hoyau and is released under the GPL License:

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License (GPL)
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	To read the license please visit http://www.gnu.org/copyleft/gpl.html
*/

    class UI_Translation {

        var $path = Array(
            "admin" => "../../lang/",
            "manager" => "../../media/manager/language/",
            "installer" => "../../lang/install/"
        );

        var $ERROR = FALSE;

        function __construct(){
            $this->UI_Translation();
        }

        function UI_Translation (){
            session_start();
            $this->path = array_key_exists( !empty( $_GET['UI'] ) ? "installer" : $_GET['UI'] , $this->path ) ? $this->path[ $_GET['UI'] ] : $this->path['admin'];
            if( !file_exists( $this->path ) )
                $this->ERROR = 'wrong path to work.';
            else
                $this->ERROR = !chdir( $this->path ) ? "Couldt selecet Directory" : FALSE ;
        }

        function checkAuth(){
            if( !require_once realpath ( dirname(__FILE__) . "/../../cgi/amf-core/util/Authenticate.php" ) )
                $this->ERROR = "Could include authentification class<br>Script aborted.";
            if( !class_exists( "Authenticate" ) && !$this->ERROR )
                $this->ERROR = "Could load authentification class<br>Script aborted.";
            else
                $auth = &new Authenticate OR FALSE;
            if( $auth )
                return $auth->isAuthenticated();
            else
                return FALSE;
        }

        function readDir(){
            if ($handle = opendir('./')){
                while ( false !== ( $file = readdir( $handle ) ) ){
                    if ( $file{0} != "." && !is_dir($file)  ){
                        $toReturn[] = $file;
                    }
                }
                closedir( $handle );
            }
            if( func_num_args() > 0 )
                return !$toReturn[ func_get_arg( 0 ) ] ? FALSE : $toReturn[ func_get_arg( 0 ) ];
            else
                return !$toReturn ? FALSE : $toReturn ;

            clearstatcache();
        }

        function readFile( $fileName="" ){
            $this->lastFileContent = file( !file_exists( $fileName ) ? $this->readDir(0) : $fileName );
            return $this->lastFileContent;
            clearstatcache();
        }

        function writeFile(){
            if( $_POST['saveit'] && !$this->ERROR && $this->checkAuth() ){
                $string = "; translatetd with SILEX UI Translation\n";
                $string .= "; please report bugs to drugBox < drugbox-de [at] sourceforge [dot] net > \n\n";
                foreach($_POST as $key => $var ){
                    if($key!='saveit')
                    $string.= "$key=". stripslashes( $var ) ."&\n";
                }
                if(isset( $_GET['destination'] ) && substr( $_GET['destination'] , -4 ) == ".txt"){
                    $fo=fopen(basename( $_GET['destination'] ),w);
                    fwrite( $fo , $string );
                    fclose($fo);
                }
                else
                    $this->ERROR = "missing destination file or wrong format.";
            }
            else
                echo $this->ERROR;
        }

        function parseFileContent($arr=Array("blank")){
            foreach( $arr as $key => $var ){
                if( stripos($var,'&') !== FALSE ){
                    $dump=substr($var,0,stripos($var,'&'));
                    $toReturn[substr( $dump , 0 , stripos($dump,'='))]=!substr($dump,stripos($dump,'=')+1)?"[".substr( $dump , 0 , stripos($dump,'='))."]":substr($dump,stripos($dump,'=')+1);
                }
            }
            return$toReturn;
        }
    }

    $UI = new UI_Translation;
    $UI->writeFile();
    $source = $UI->parseFileContent( $UI->readFile( $_GET['source'] ) );
    $destination = $UI->parseFileContent( $UI->readFile( $_GET['destination'] ) );

    if( is_array( $source ) && is_array( $destination ) )
            foreach( $source as $key => $var ){
                $sc++;
                #if( $sc > '10' )break;
                $output .= "<div class=\"translation\" name=\"$key\" id=\"line$sc\">" . htmlspecialchars( $source[$key] ) . "<br><input id=\"translation\" style=\"width:100%;font-size:14px;padding-left:10px;border:0px;background-color:#787878;\" type=\"text\" value=\"" . htmlspecialchars( $destination[$key] ) . "\" name=\"$key\"/></div>\n";
            }
    else
        $output = "One of the files are not compatible.";

    echo $UI->ERROR;

?>
<html>
<head>
    <title>Silex UI Translation Tool</title>
    <script type="text/javascript" src="UI_Translation.js"></script>
    <link rel="stylesheet" href="UI_Translation.css" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
        <div id="Navigationbar">
            <form name="files" action="<?echo$_SERVER['PHP_SELF'];?>" method="get" style="display:block;">
                <table width="100%">
                    <tr>
                        <td width="33%">Element to translate
                            <select name="UI" onChange="this.form.submit();" style="font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;">
                                <option style="font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;" value="installer" <?php if($_GET['UI'] == 'installer'){echo "selected=\"selected\"";} ?>>Installer</option>
                                <option style="font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;" value="manager" <?php if($_GET['UI'] == 'manager'){echo "selected=\"selected\"";} ?>>Manager</option>
                                <option style="font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;" value="admin" <?php if($_GET['UI'] == 'admin'){echo "selected=\"selected\"";} ?>>WYSING</option>
                            </select>
                        </td>
                        <td width="33%">Source File
                            <select name="source" onChange="this.form.submit();" style="font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;">
                                <?
                                clearstatcache();
                                $files = $UI->readDir();
                                for($sc=0;$sc<count($files);$sc++){
                                    echo "<option value=\"" . $files[$sc] . "\" style=\"font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;\"";
                                    echo $_GET['source'] == $files[$sc] ? "selected=\"selected\"" : "";
                                    echo ">" . $files[$sc] . "</option>";
                                } ?>
                            </select>
                        </td>
                        <td width="33%">Destination File
                            <select name="destination" onChange="this.form.submit();" style="font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;">
                                <?
                                for($sc=0;$sc<count($files);$sc++){
                                    echo "<option value=\"" . $files[$sc] . "\" style=\"font-size:14px;background-color:#787878;border:2px dotted #fcfcfc;width:100%;\"";
                                    echo $_GET['destination'] == $files[$sc] ? "selected=\"selected\"" : "";
                                    echo ">" . $files[$sc] . "</option>";
                                } ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div>
            <form name="silexTranslation" action="<?echo$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>" method="post">
                <div>
                    <table width="100%">
                        <tr>
                            <td width="25%">
                                <input name="saveit" type="reset" style="color:#FF0000;font-weight:bold;border:0px;"/>
                            </td>
                            <td width="25%">
                                <input name="saveit" type="submit" style="color:#00C800;font-weight:bold;border:0px;"/>
                            </td>
                            <td width="25%">
                                <a href="javascript:addLanguage();"><span style="color:#ffff00">*</span> create a new language</a>
                            </td>
                            <td width="25%">
                                <a style="text-decoration:line-through;" href="javascript:SubmitToCommunity();">submit your language-file to the community</a>
                            </td>
                        </tr>
                    </table>
                </div>
                                <?echo $output?>
            </form>
        </div>
</body>
</html>